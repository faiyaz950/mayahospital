<?php
/**
 * Admin panel: sign in and manage appointment requests.
 */
require __DIR__ . '/../includes/bootstrap.php';

header('X-Robots-Tag: noindex, nofollow');
header('X-Frame-Options: DENY');

const STATUSES = ['new' => 'New', 'confirmed' => 'Confirmed', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];

$admin    = $config['admin'];
$isSetUp  = $admin['pass_hash'] !== '';
$loggedIn = !empty($_SESSION['admin']);
$error    = '';

// ---- actions ----------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid($_POST['csrf'] ?? null)) {
        $error = 'Session expired. Please try again.';
    } elseif (($_POST['action'] ?? '') === 'login' && $isSetUp) {
        $attempts = $_SESSION['login_attempts'] ?? ['n' => 0, 't' => time()];
        if (time() - $attempts['t'] > 900) {
            $attempts = ['n' => 0, 't' => time()];
        }
        if ($attempts['n'] >= 5) {
            $error = 'Too many attempts. Please wait 15 minutes.';
        } elseif (hash_equals($admin['user'], (string) ($_POST['user'] ?? ''))
            && password_verify((string) ($_POST['pass'] ?? ''), $admin['pass_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin'] = $admin['user'];
            unset($_SESSION['login_attempts']);
            header('Location: ./', true, 303);
            exit;
        } else {
            $attempts['n']++;
            $_SESSION['login_attempts'] = $attempts;
            $error = 'Incorrect username or password.';
        }
    } elseif (($_POST['action'] ?? '') === 'logout') {
        $_SESSION = [];
        session_destroy();
        header('Location: ./', true, 303);
        exit;
    } elseif (($_POST['action'] ?? '') === 'status' && $loggedIn) {
        $status = (string) ($_POST['status'] ?? '');
        if (isset(STATUSES[$status])) {
            db()->prepare('UPDATE appointments SET status = ? WHERE id = ?')->execute([$status, (int) ($_POST['id'] ?? 0)]);
        }
        header('Location: ./?' . http_build_query(['status' => $_GET['status'] ?? '']), true, 303);
        exit;
    }
}

// ---- data -------------------------------------------------------------------
$filter = $_GET['status'] ?? '';
$rows = $counts = [];
if ($loggedIn) {
    foreach (db()->query('SELECT status, COUNT(*) AS n FROM appointments GROUP BY status') as $r) {
        $counts[$r['status']] = (int) $r['n'];
    }
    if (isset(STATUSES[$filter])) {
        $stmt = db()->prepare('SELECT * FROM appointments WHERE status = ? ORDER BY created_at DESC LIMIT 500');
        $stmt->execute([$filter]);
    } else {
        $filter = '';
        $stmt = db()->query('SELECT * FROM appointments ORDER BY created_at DESC LIMIT 500');
    }
    $rows = $stmt->fetchAll();
}
$total = array_sum($counts);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Admin · <?= e($site['name']) ?></title>
<link rel="icon" type="image/png" href="../assets/img/favicon.png">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
</head>
<body>
<?php if (!$loggedIn): ?>
  <main class="login">
    <form method="post" class="login-card">
      <img src="../assets/img/logo.png" alt="" width="56" height="50">
      <h1><?= e($site['name']) ?></h1>
      <p class="muted">Admin panel · Appointment requests</p>
      <?php if (!$isSetUp): ?>
        <div class="alert">Admin login is not set up yet. Add a password hash to <code>includes/config.local.php</code> (see DEPLOYMENT.md).</div>
      <?php else: ?>
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="login">
        <label>Username<input name="user" autocomplete="username" required></label>
        <label>Password<input name="pass" type="password" autocomplete="current-password" required></label>
        <button type="submit">Sign in</button>
      <?php endif; ?>
      <a class="back" href="../">← Back to website</a>
    </form>
  </main>
<?php else: ?>
  <header class="bar">
    <div class="brand"><img src="../assets/img/logo.png" alt="" width="36" height="32"><span><strong><?= e($site['name']) ?></strong><small>Appointment requests</small></span></div>
    <div class="bar-actions">
      <a href="../" target="_blank" rel="noopener">View site</a>
      <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="logout"><button type="submit">Sign out</button></form>
    </div>
  </header>
  <main class="wrap">
    <nav class="tabs">
      <a href="./" class="<?= $filter === '' ? 'on' : '' ?>">All <b><?= $total ?></b></a>
      <?php foreach (STATUSES as $key => $label): ?>
        <a href="?status=<?= $key ?>" class="<?= $filter === $key ? 'on' : '' ?> t-<?= $key ?>"><?= $label ?> <b><?= $counts[$key] ?? 0 ?></b></a>
      <?php endforeach; ?>
    </nav>

    <?php if (!$rows): ?>
      <p class="empty">No appointment requests<?= $filter ? ' with status “' . e(STATUSES[$filter]) . '”' : '' ?> yet.</p>
    <?php else: ?>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Received</th><th>Patient</th><th>Department / Doctor</th><th>Preferred date</th><th>Message</th><th>Status</th></tr></thead>
          <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td data-label="Received"><?= e(date('d M Y, h:i A', strtotime($r['created_at']))) ?></td>
              <td data-label="Patient"><strong><?= e($r['name']) ?></strong><a href="tel:<?= e(tel($r['phone'])) ?>"><?= e($r['phone']) ?></a></td>
              <td data-label="Department"><?= e($r['department']) ?><small><?= e($r['doctor'] ?: 'No preference') ?></small></td>
              <td data-label="Date"><?= $r['preferred_date'] ? e(date('d M Y', strtotime($r['preferred_date']))) : '<span class="muted">—</span>' ?></td>
              <td data-label="Message" class="msg"><?= $r['message'] ? nl2br(e($r['message'])) : '<span class="muted">—</span>' ?></td>
              <td data-label="Status">
                <form method="post" action="?status=<?= e($filter) ?>" class="status-form">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="status">
                  <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                  <select name="status" class="s-<?= e($r['status']) ?>" onchange="this.form.submit()">
                    <?php foreach (STATUSES as $key => $label): ?>
                      <option value="<?= $key ?>"<?= $r['status'] === $key ? ' selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                  </select>
                  <noscript><button type="submit">Save</button></noscript>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </main>
<?php endif; ?>
</body>
</html>
