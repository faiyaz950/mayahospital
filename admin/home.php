<?php
/**
 * Edit Home page text and photos. An empty field falls back to the original text.
 */
require __DIR__ . '/_layout.php';
admin_require_login();

if (admin_post_ok()) {
    $errors = [];
    foreach (home_fields() as $key => [$type, $label]) {
        if ($type === 'image') {
            try {
                $path = admin_upload($key);
                if ($path !== null) {
                    save_setting("home.$key", $path);
                } elseif (!empty($_POST["reset_$key"])) {
                    save_setting("home.$key", '');
                }
            } catch (RuntimeException $ex) {
                $errors[] = "$label: " . $ex->getMessage();
            }
            continue;
        }
        $value = trim((string) ($_POST[$key] ?? ''));
        if ($type === 'lines') {
            $value = implode("\n", lines($value));
        }
        save_setting("home.$key", $value);
    }
    flash($errors ? 'error' : 'success', $errors ? implode(' ', $errors) : 'Home page saved. The website is updated.');
    admin_redirect('home.php');
}

admin_head('Home page', 'home');
?>
  <div class="page-head">
    <div>
      <h1>Home page</h1>
      <p class="muted">Edit the text and photos on the Home page. Leave a field empty to bring back the original text. Services, doctors and FAQs are edited in their own menus.</p>
    </div>
    <a class="btn-ghost" href="../" target="_blank" rel="noopener">View Home page ↗</a>
  </div>

  <form method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php foreach (HOME_SECTIONS as $section => $fields): ?>
      <details class="card form-section" <?= $section === 'Top banner (hero)' ? 'open' : '' ?>>
        <summary><?= e($section) ?></summary>
        <div class="form">
          <?php foreach ($fields as $key => [$type, $label, $default]): $val = hv($key); ?>
            <div class="f-row<?= in_array($type, ['textarea', 'lines'], true) ? ' wide' : '' ?>">
              <label for="h-<?= $key ?>"><?= e($label) ?></label>
              <?php if ($type === 'text'): ?>
                <input id="h-<?= $key ?>" name="<?= $key ?>" value="<?= e($val) ?>" placeholder="<?= e($default) ?>">
              <?php elseif ($type === 'textarea'): ?>
                <textarea id="h-<?= $key ?>" name="<?= $key ?>" rows="3" placeholder="<?= e($default) ?>"><?= e($val) ?></textarea>
              <?php elseif ($type === 'lines'): ?>
                <textarea id="h-<?= $key ?>" name="<?= $key ?>" rows="6"><?= e($val) ?></textarea>
              <?php elseif ($type === 'image'): ?>
                <div class="img-field">
                  <img src="<?= e(img($val)) ?>" alt="">
                  <div>
                    <input id="h-<?= $key ?>" type="file" name="<?= $key ?>" accept="image/jpeg,image/png,image/webp">
                    <small class="muted">Choose a file only to replace this photo. JPG, PNG or WEBP, up to 8 MB.</small>
                    <?php if ($val !== $default): ?>
                      <label class="check"><input type="checkbox" name="reset_<?= $key ?>" value="1"> Use the original photo again</label>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endif; ?>
              <?php if ($key === 'faq_text'): ?><small class="muted">Use {phone_helpline} or {phone_booking} to insert a clickable number.</small><?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </details>
    <?php endforeach; ?>
    <div class="sticky-save"><button type="submit" class="btn-primary">Save Home page</button></div>
  </form>
<?php admin_foot(); ?>
