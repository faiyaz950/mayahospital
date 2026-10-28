<?php
/**
 * Contact numbers, address and notification email shown across the website.
 */
require __DIR__ . '/_layout.php';
admin_require_login();

if (admin_post_ok()) {
    $errors = [];
    $email  = trim((string) ($_POST['notify_email'] ?? ''));
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    foreach (['phone_booking', 'phone_helpline', 'phone_extra'] as $k) {
        $digits = preg_replace('/\D/', '', (string) ($_POST[$k] ?? ''));
        if ($digits !== '' && (strlen($digits) < 10 || strlen($digits) > 13)) {
            $errors[] = SETTING_FIELDS[$k] . ' does not look like a valid phone number.';
        }
    }
    if ($errors) {
        flash('error', implode(' ', $errors));
    } else {
        foreach (SETTING_FIELDS as $k => $label) {
            save_setting($k, trim((string) ($_POST[$k] ?? '')));
        }
        flash('success', 'Settings saved. The website is updated.');
    }
    admin_redirect('settings.php');
}

// Show saved values, falling back to the defaults the site uses today.
$values = load_settings($config['site']);
$values['notify_email'] = $values['notify_email'] ?? $config['mail']['to'];

admin_head('Settings', 'settings');
?>
  <div class="page-head">
    <div>
      <h1>Settings</h1>
      <p class="muted">These details appear in the top bar, buttons, footer, contact page and FAQs.</p>
    </div>
  </div>

  <form method="post" class="card form">
    <?= csrf_field() ?>
    <?php foreach (SETTING_FIELDS as $k => $label): ?>
      <div class="f-row<?= $k === 'address' ? ' wide' : '' ?>">
        <label for="s-<?= $k ?>"><?= e($label) ?></label>
        <input id="s-<?= $k ?>" name="<?= $k ?>" value="<?= e($values[$k] ?? '') ?>" <?= $k === 'notify_email' ? 'type="email"' : '' ?>>
        <?php if ($k === 'notify_email'): ?><small class="muted">New appointment requests are emailed here.</small><?php endif; ?>
      </div>
    <?php endforeach; ?>
    <div class="f-actions"><button type="submit" class="btn-primary">Save settings</button></div>
  </form>
<?php admin_foot(); ?>
