<?php
/**
 * Add, edit, reorder, hide and delete website content (doctors, services, gallery, FAQs).
 */
require __DIR__ . '/_layout.php';
admin_require_login();

$type = $_GET['type'] ?? '';
if (!isset(CONTENT_TYPES[$type])) {
    admin_redirect('./');
}
$def  = CONTENT_TYPES[$type];
$self = 'content.php?type=' . $type;

// ---- actions ----------------------------------------------------------------
if (admin_post_ok()) {
    $action = $_POST['action'] ?? '';
    $id     = (int) ($_POST['id'] ?? 0);

    if ($action === 'save') {
        $data   = [];
        $errors = [];
        $old    = $id ? content_find($type, $id) : null;
        foreach ($def['fields'] as $name => $f) {
            if ($f[0] === 'image') {
                try {
                    $uploaded = admin_upload($name);
                } catch (RuntimeException $ex) {
                    $errors[] = $f[1] . ': ' . $ex->getMessage();
                    $uploaded = null;
                }
                $data[$name] = $uploaded ?? ($old[$name] ?? '');
            } elseif ($f[0] === 'checkbox') {
                $data[$name] = isset($_POST[$name]) ? 1 : 0;
            } else {
                $value = trim((string) ($_POST[$name] ?? ''));
                if ($f[0] === 'lines') {
                    $value = implode("\n", lines($value));
                }
                $data[$name] = $value;
            }
            if (!empty($f['required']) && trim((string) $data[$name]) === '') {
                $errors[] = $f[1] . ' is required.';
            }
        }
        $data['active'] = isset($_POST['active']) ? 1 : 0;

        if ($errors) {
            flash('error', implode(' ', $errors));
            $_SESSION['admin_old'] = $data;
            admin_redirect($self . ($id ? "&id=$id" : '&new=1'));
        }
        if (!$id) {
            $data['sort_order'] = (int) db()->query("SELECT COALESCE(MAX(sort_order), 0) + 10 FROM $type")->fetchColumn();
        }
        content_save($type, $data, $id ?: null);
        flash('success', $def['singular'] . ' saved. The website is updated.');
        admin_redirect($self);
    }

    if ($action === 'delete' && $id) {
        db()->prepare("DELETE FROM $type WHERE id = ?")->execute([$id]);
        flash('success', $def['singular'] . ' deleted.');
        admin_redirect($self);
    }

    if ($action === 'toggle' && $id) {
        db()->prepare("UPDATE $type SET active = 1 - active WHERE id = ?")->execute([$id]);
        admin_redirect($self);
    }

    if ($action === 'move' && $id) {
        $rows = content($type, false);
        $ids  = array_column($rows, 'id');
        $pos  = array_search($id, $ids);
        $swap = $pos + (($_POST['dir'] ?? '') === 'up' ? -1 : 1);
        if ($pos !== false && isset($ids[$swap])) {
            [$ids[$pos], $ids[$swap]] = [$ids[$swap], $ids[$pos]];
            $stmt = db()->prepare("UPDATE $type SET sort_order = ? WHERE id = ?");
            foreach ($ids as $i => $rowId) {
                $stmt->execute([($i + 1) * 10, $rowId]);
            }
        }
        admin_redirect($self);
    }
    admin_redirect($self);
}

// ---- views ------------------------------------------------------------------
$editing = isset($_GET['new']) || isset($_GET['id']);
$row     = null;
if (isset($_GET['id'])) {
    $row = content_find($type, (int) $_GET['id']);
    if (!$row) {
        admin_redirect($self);
    }
}
if (!empty($_SESSION['admin_old'])) {
    $row = array_merge($row ?? [], $_SESSION['admin_old']);
    unset($_SESSION['admin_old']);
}

$imageField = null;
foreach ($def['fields'] as $name => $f) {
    if ($f[0] === 'image') {
        $imageField = $name;
        break;
    }
}

function field_options(string $source): array
{
    return match ($source) {
        'icons'   => array_combine(SERVICE_ICONS, array_map('ucfirst', SERVICE_ICONS)),
        'gallery' => GALLERY_CATEGORIES,
        default   => [],
    };
}

admin_head($def['label'], $type);
?>

<?php if (!$editing): ?>
  <div class="page-head">
    <div>
      <h1><?= e($def['label']) ?></h1>
      <p class="muted">Changes appear on the website immediately. Use the arrows to change the order, and the switch to hide an item without deleting it.</p>
    </div>
    <a class="btn-primary" href="<?= e($self) ?>&new=1">+ Add <?= e(strtolower($def['singular'])) ?></a>
  </div>

  <?php $rows = content($type, false); ?>
  <?php if (!$rows): ?>
    <p class="empty">Nothing here yet. Click “Add <?= e(strtolower($def['singular'])) ?>” to create the first one.</p>
  <?php else: ?>
    <div class="items">
      <?php foreach ($rows as $i => $r): ?>
        <div class="item<?= $r['active'] ? '' : ' is-hidden' ?>">
          <?php if ($imageField): ?>
            <img class="thumb" src="<?= e(img($r[$imageField])) ?>" alt="">
          <?php endif; ?>
          <div class="item-main">
            <strong><?= e($r[$def['title']]) ?></strong>
            <span class="muted">
              <?php foreach ($def['fields'] as $name => $f): if (empty($f['list']) || $name === $def['title']) continue; ?>
                <?= e($f[0] === 'select' && $f['options'] === 'gallery' ? (GALLERY_CATEGORIES[$r[$name]] ?? $r[$name]) : $r[$name]) ?>
              <?php endforeach; ?>
              <?= $r['active'] ? '' : ' · <em>Hidden</em>' ?>
            </span>
          </div>
          <div class="item-actions">
            <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="move"><input type="hidden" name="id" value="<?= (int) $r['id'] ?>"><input type="hidden" name="dir" value="up"><button class="icon-btn" title="Move up" <?= $i === 0 ? 'disabled' : '' ?>>↑</button></form>
            <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="move"><input type="hidden" name="id" value="<?= (int) $r['id'] ?>"><input type="hidden" name="dir" value="down"><button class="icon-btn" title="Move down" <?= $i === count($rows) - 1 ? 'disabled' : '' ?>>↓</button></form>
            <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int) $r['id'] ?>"><button class="pill-btn"><?= $r['active'] ? 'Visible' : 'Hidden' ?></button></form>
            <a class="pill-btn edit" href="<?= e($self) ?>&id=<?= (int) $r['id'] ?>">Edit</a>
            <form method="post" onsubmit="return confirm('Delete “<?= e(addslashes($r[$def['title']])) ?>”? This cannot be undone.')"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int) $r['id'] ?>"><button class="pill-btn danger">Delete</button></form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

<?php else: ?>
  <div class="page-head">
    <div>
      <a class="back-link" href="<?= e($self) ?>">← All <?= e(strtolower($def['label'])) ?></a>
      <h1><?= $row && !empty($row['id']) ? 'Edit ' . e(strtolower($def['singular'])) : 'Add ' . e(strtolower($def['singular'])) ?></h1>
    </div>
  </div>

  <form method="post" enctype="multipart/form-data" class="card form">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= (int) ($row['id'] ?? 0) ?>">

    <?php foreach ($def['fields'] as $name => $f): $val = (string) ($row[$name] ?? ''); ?>
      <div class="f-row<?= in_array($f[0], ['textarea', 'lines'], true) ? ' wide' : '' ?>">
        <?php if ($f[0] === 'checkbox'): ?>
          <label class="check"><input type="checkbox" name="<?= $name ?>" value="1" <?= $val === '1' ? 'checked' : '' ?>> <?= e($f[1]) ?></label>
        <?php else: ?>
          <label for="f-<?= $name ?>"><?= e($f[1]) ?><?= !empty($f['required']) ? ' *' : '' ?></label>
          <?php if ($f[0] === 'text'): ?>
            <input id="f-<?= $name ?>" name="<?= $name ?>" value="<?= e($val) ?>" <?= !empty($f['required']) ? 'required' : '' ?>>
          <?php elseif ($f[0] === 'textarea'): ?>
            <textarea id="f-<?= $name ?>" name="<?= $name ?>" rows="4" <?= !empty($f['required']) ? 'required' : '' ?>><?= e($val) ?></textarea>
          <?php elseif ($f[0] === 'lines'): ?>
            <textarea id="f-<?= $name ?>" name="<?= $name ?>" rows="5"><?= e($val) ?></textarea>
          <?php elseif ($f[0] === 'select'): ?>
            <select id="f-<?= $name ?>" name="<?= $name ?>">
              <?php foreach (field_options($f['options']) as $k => $label): ?>
                <option value="<?= e($k) ?>" <?= $val === (string) $k ? 'selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
          <?php elseif ($f[0] === 'image'): ?>
            <div class="img-field">
              <?php if ($val !== ''): ?><img src="<?= e(img($val)) ?>" alt=""><?php endif; ?>
              <div>
                <input id="f-<?= $name ?>" type="file" name="<?= $name ?>" accept="image/jpeg,image/png,image/webp">
                <small class="muted"><?= $val !== '' ? 'Choose a file only if you want to replace the current image. ' : '' ?>JPG, PNG or WEBP, up to 8 MB.</small>
              </div>
            </div>
          <?php endif; ?>
        <?php endif; ?>
        <?php if (!empty($f['help'])): ?><small class="muted"><?= e($f['help']) ?></small><?php endif; ?>
      </div>
    <?php endforeach; ?>

    <div class="f-row">
      <label class="check"><input type="checkbox" name="active" value="1" <?= ($row['active'] ?? 1) ? 'checked' : '' ?>> Show on website</label>
    </div>

    <div class="f-actions">
      <button type="submit" class="btn-primary">Save</button>
      <a href="<?= e($self) ?>" class="btn-ghost">Cancel</a>
    </div>
  </form>
<?php endif; ?>

<?php admin_foot(); ?>
