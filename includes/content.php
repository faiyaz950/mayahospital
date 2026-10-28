<?php
/**
 * Editable website content: doctors, services, gallery, FAQs and site settings.
 * The field lists below drive both the database tables and the admin forms.
 */

const GALLERY_CATEGORIES = [
    'exterior'   => 'Exterior & Entrance',
    'reception'  => 'Reception & Waiting',
    'team'       => 'Doctors & Team',
    'facilities' => 'Consultation & Facilities',
    'services'   => 'Services & Awareness',
];

/**
 * Field types: text, textarea, lines (one item per line), image, select, number, checkbox.
 * 'list' marks the columns shown in the admin list.
 */
const CONTENT_TYPES = [
    'doctors' => [
        'label'    => 'Doctors',
        'singular' => 'Doctor',
        'title'    => 'name',
        'fields'   => [
            'name'       => ['text', 'Doctor name', 'required' => true, 'list' => true],
            'department' => ['text', 'Department / speciality', 'list' => true],
            'photo'      => ['image', 'Photo (portrait)'],
            'quals'      => ['lines', 'Qualifications', 'help' => 'One per line, e.g. MBBS'],
            'school'     => ['text', 'Trained at (optional)', 'help' => 'e.g. K.G.M.C., Lucknow'],
            'home_intro' => ['textarea', 'Short intro (Home page card)'],
            'tags'       => ['lines', 'Tags (Home page card)', 'help' => 'One per line, 2–4 short tags'],
            'intro'      => ['textarea', 'Main introduction (About page)'],
            'details'    => ['textarea', 'More details (About page)'],
            'focus'      => ['lines', 'Areas of focus', 'help' => 'One per line'],
            'services'   => ['lines', 'Treatments & services', 'help' => 'One per line'],
        ],
    ],
    'services' => [
        'label'    => 'Services',
        'singular' => 'Service',
        'title'    => 'title',
        'fields'   => [
            'title'       => ['text', 'Service name', 'required' => true, 'list' => true],
            'category'    => ['text', 'Category label', 'list' => true, 'help' => 'e.g. Pain Care, Procedure'],
            'description' => ['textarea', 'Short description'],
            'image'       => ['image', 'Image (landscape, no text on it)'],
            'icon'        => ['select', 'Icon', 'options' => 'icons'],
            'link'        => ['text', 'Learn more link', 'help' => 'e.g. /services#pain'],
        ],
    ],
    'gallery' => [
        'label'    => 'Gallery',
        'singular' => 'Photo',
        'title'    => 'title',
        'fields'   => [
            'title'    => ['text', 'Photo title', 'required' => true, 'list' => true],
            'category' => ['select', 'Category', 'options' => 'gallery', 'list' => true],
            'subtitle' => ['text', 'Small caption'],
            'image'    => ['image', 'Photo', 'required' => true],
            'top'      => ['checkbox', 'Keep top of photo visible (for portraits)'],
        ],
    ],
    'faqs' => [
        'label'    => 'FAQs',
        'singular' => 'FAQ',
        'title'    => 'question',
        'fields'   => [
            'question' => ['text', 'Question', 'required' => true, 'list' => true],
            'answer'   => ['textarea', 'Answer', 'required' => true, 'help' => 'Use {phone_booking} or {phone_helpline} to insert a clickable number.'],
        ],
    ],
];

/** Site settings editable in the admin (defaults come from config.php). */
const SETTING_FIELDS = [
    'tagline'        => 'Tagline',
    'phone_booking'  => 'Appointment booking number',
    'phone_helpline' => 'Central helpline number',
    'phone_extra'    => 'Additional contact number',
    'address'        => 'Full address',
    'address_short'  => 'Short address (top bar)',
    'maps_query'     => 'Google Maps search text',
    'notify_email'   => 'Email for new appointment requests',
];

const SCHEMA_VERSION = '2';

/** Create content tables and fill them with the current website content the first time. */
function migrate_content(PDO $pdo): void
{
    $sqlite = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite';
    $pk     = $sqlite ? 'INTEGER PRIMARY KEY AUTOINCREMENT' : 'INT UNSIGNED AUTO_INCREMENT PRIMARY KEY';
    $tail   = $sqlite ? '' : ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';
    $key    = $sqlite ? 'TEXT' : 'VARCHAR(64)';

    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (k $key PRIMARY KEY, v TEXT)$tail");

    try {
        $current = $pdo->query("SELECT v FROM settings WHERE k = 'schema_version'")->fetchColumn();
    } catch (Throwable $e) {
        $current = false;
    }
    if ($current === SCHEMA_VERSION) {
        return;
    }

    foreach (CONTENT_TYPES as $type => $def) {
        $cols = [];
        foreach ($def['fields'] as $name => $f) {
            $cols[] = $name . ($f[0] === 'checkbox' ? ' INT NOT NULL DEFAULT 0' : ' TEXT');
        }
        $pdo->exec("CREATE TABLE IF NOT EXISTS $type (id $pk, " . implode(', ', $cols)
            . ', sort_order INT NOT NULL DEFAULT 0, active INT NOT NULL DEFAULT 1, updated_at ' . ($sqlite ? 'TEXT' : 'DATETIME') . ")$tail");

        if ((int) $pdo->query("SELECT COUNT(*) FROM $type")->fetchColumn() === 0) {
            $seed = (require __DIR__ . '/seed.php')[$type] ?? [];
            foreach ($seed as $i => $row) {
                content_save($type, $row + ['sort_order' => ($i + 1) * 10, 'active' => 1], null, $pdo);
            }
        }
    }

    $set = $pdo->prepare($sqlite ? 'INSERT OR REPLACE INTO settings (k, v) VALUES (?, ?)' : 'REPLACE INTO settings (k, v) VALUES (?, ?)');
    $set->execute(['schema_version', SCHEMA_VERSION]);
}

/** Rows of a content type, ordered for display. Falls back to seed data if the database is unavailable. */
function content(string $type, bool $onlyActive = true): array
{
    static $cache = [];
    $k = $type . (int) $onlyActive;
    if (isset($cache[$k])) {
        return $cache[$k];
    }
    try {
        $sql = "SELECT * FROM $type" . ($onlyActive ? ' WHERE active = 1' : '') . ' ORDER BY sort_order, id';
        return $cache[$k] = db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        error_log("Content '$type' unavailable: " . $e->getMessage());
        return $cache[$k] = array_map(fn ($r) => $r + ['id' => 0, 'active' => 1], (require __DIR__ . '/seed.php')[$type] ?? []);
    }
}

function content_find(string $type, int $id): ?array
{
    $stmt = db()->prepare("SELECT * FROM $type WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

/** Insert ($id null) or update a row. Only known columns are written. */
function content_save(string $type, array $data, ?int $id = null, ?PDO $pdo = null): int
{
    $pdo  = $pdo ?? db();
    $cols = array_merge(array_keys(CONTENT_TYPES[$type]['fields']), ['sort_order', 'active']);
    $row  = [];
    foreach ($cols as $c) {
        if (array_key_exists($c, $data)) {
            $row[$c] = $data[$c];
        }
    }
    $row['updated_at'] = date('Y-m-d H:i:s');

    if ($id === null) {
        $names = array_keys($row);
        $stmt  = $pdo->prepare("INSERT INTO $type (" . implode(', ', $names) . ') VALUES (' . implode(', ', array_fill(0, count($names), '?')) . ')');
        $stmt->execute(array_values($row));
        return (int) $pdo->lastInsertId();
    }
    $sets = implode(', ', array_map(fn ($c) => "$c = ?", array_keys($row)));
    $pdo->prepare("UPDATE $type SET $sets WHERE id = ?")->execute([...array_values($row), $id]);
    return $id;
}

/** Saved settings override the defaults from config.php. */
function load_settings(array $site): array
{
    try {
        foreach (db()->query('SELECT k, v FROM settings') as $r) {
            if (isset(SETTING_FIELDS[$r['k']]) && $r['v'] !== '') {
                $site[$r['k']] = $r['v'];
            }
        }
    } catch (Throwable $e) {
        error_log('Settings unavailable: ' . $e->getMessage());
    }
    return $site;
}

function save_setting(string $k, string $v): void
{
    $sqlite = db()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite';
    db()->prepare($sqlite ? 'INSERT OR REPLACE INTO settings (k, v) VALUES (?, ?)' : 'REPLACE INTO settings (k, v) VALUES (?, ?)')->execute([$k, $v]);
}

/** "a\nb\n\n c" -> ['a', 'b', 'c'] */
function lines(?string $text): array
{
    return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $text)), 'strlen'));
}

/** Public URL for a stored image path. */
function img(?string $path): string
{
    if ($path === null || $path === '') {
        return '/assets/img/logo.png';
    }
    return preg_match('#^https?://#', $path) ? $path : '/' . ltrim($path, '/');
}

/** Escape text and turn {phone_*} placeholders into clickable numbers. */
function rich(string $text): string
{
    global $site;
    $html = nl2br(e($text));
    foreach (['phone_booking', 'phone_helpline', 'phone_extra'] as $k) {
        $html = str_replace('{' . $k . '}', '<a href="tel:' . e(tel($site[$k])) . '">' . e($site[$k]) . '</a>', $html);
    }
    return $html;
}
