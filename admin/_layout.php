<?php
/**
 * Shared admin helpers: sign-in guard, page frame, flash messages and image uploads.
 */
require_once __DIR__ . '/../includes/bootstrap.php';

header('X-Robots-Tag: noindex, nofollow');
header('X-Frame-Options: DENY');

const ADMIN_NAV = [
    'appointments' => ['./', 'Appointments'],
    'doctors'      => ['content.php?type=doctors', 'Doctors'],
    'services'     => ['content.php?type=services', 'Services'],
    'gallery'      => ['content.php?type=gallery', 'Gallery'],
    'faqs'         => ['content.php?type=faqs', 'FAQs'],
    'settings'     => ['settings.php', 'Settings'],
];

function admin_logged_in(): bool
{
    return !empty($_SESSION['admin']);
}

function admin_require_login(): void
{
    if (!admin_logged_in()) {
        header('Location: ./', true, 303);
        exit;
    }
}

function flash(string $type, string $message): void
{
    $_SESSION['admin_flash'] = [$type, $message];
}

function admin_redirect(string $to): never
{
    header('Location: ' . $to, true, 303);
    exit;
}

/** POST guard for every admin action. */
function admin_post_ok(): bool
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        return false;
    }
    if (!csrf_valid($_POST['csrf'] ?? null)) {
        flash('error', 'Session expired. Please try again.');
        return false;
    }
    return true;
}

/**
 * Save an uploaded image to assets/uploads and return its path, or null when no file was sent.
 * Throws RuntimeException with a readable message for bad files.
 */
function admin_upload(string $field): ?string
{
    $f = $_FILES[$field] ?? null;
    if (!$f || $f['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($f['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed. The file may be larger than the server allows.');
    }
    if ($f['size'] > 8 * 1024 * 1024) {
        throw new RuntimeException('Image is too large. Please use a file under 8 MB.');
    }
    $types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime  = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    if (!isset($types[$mime]) || !getimagesize($f['tmp_name'])) {
        throw new RuntimeException('Only JPG, PNG or WEBP images can be uploaded.');
    }

    $dir = __DIR__ . '/../assets/uploads';
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        throw new RuntimeException('Could not create the uploads folder on the server.');
    }
    $name = date('Ymd') . '-' . bin2hex(random_bytes(6)) . '.' . $types[$mime];
    $dest = "$dir/$name";

    // Large photos are scaled to 1600px wide to keep pages fast (needs the GD extension).
    [$w, $h] = getimagesize($f['tmp_name']);
    if ($w > 1600 && function_exists('imagecreatetruecolor')) {
        $src = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($f['tmp_name']),
            'image/png'  => imagecreatefrompng($f['tmp_name']),
            'image/webp' => imagecreatefromwebp($f['tmp_name']),
        };
        $nh  = (int) round($h * 1600 / $w);
        $dst = imagecreatetruecolor(1600, $nh);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, 1600, $nh, $w, $h);
        $ok = match ($mime) {
            'image/jpeg' => imagejpeg($dst, $dest, 82),
            'image/png'  => imagepng($dst, $dest, 7),
            'image/webp' => imagewebp($dst, $dest, 82),
        };
    } else {
        $ok = move_uploaded_file($f['tmp_name'], $dest);
    }
    if (!$ok) {
        throw new RuntimeException('Could not save the image on the server.');
    }
    return 'assets/uploads/' . $name;
}

function admin_head(string $title, string $active): void
{
    global $site;
    $flash = $_SESSION['admin_flash'] ?? null;
    unset($_SESSION['admin_flash']);
    ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($title) ?> · Admin · <?= e($site['name']) ?></title>
<link rel="icon" type="image/png" href="../assets/img/favicon.png">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
</head>
<body>
  <header class="bar">
    <div class="brand"><img src="../assets/img/logo.png" alt="" width="36" height="32"><span><strong><?= e($site['name']) ?></strong><small>Admin panel</small></span></div>
    <div class="bar-actions">
      <a href="../" target="_blank" rel="noopener">View site ↗</a>
      <form method="post" action="./"><?= csrf_field() ?><input type="hidden" name="action" value="logout"><button type="submit">Sign out</button></form>
    </div>
  </header>
  <nav class="side-nav">
    <?php foreach (ADMIN_NAV as $key => [$href, $label]): ?>
      <a href="<?= e($href) ?>" class="<?= $key === $active ? 'on' : '' ?>"><?= e($label) ?></a>
    <?php endforeach; ?>
  </nav>
  <main class="wrap">
    <?php if ($flash): ?><div class="flash flash-<?= e($flash[0]) ?>"><?= e($flash[1]) ?></div><?php endif; ?>
<?php
}

function admin_foot(): void
{
    ?>
  </main>
</body>
</html>
<?php
}
