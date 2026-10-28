<?php
require __DIR__ . '/includes/bootstrap.php';
http_response_code(404);
$page = [
    'id'          => '404',
    'title'       => 'Page not found | ' . $site['name'],
    'description' => 'The page you are looking for could not be found.',
];
include __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="container" style="text-align:center;max-width:640px">
    <span class="eyebrow">Error 404</span>
    <h1>Page not <em class="serif accent">found</em></h1>
    <p style="color:var(--ink-3);font-size:1.1rem">The page you are looking for may have moved. Use the menu above, or call us on <a href="tel:<?= tel($site['phone_booking']) ?>" style="color:var(--red-600);font-weight:700"><?= e($site['phone_booking']) ?></a>.</p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:28px">
      <a href="/" class="btn btn-red">Go to Home</a>
      <a href="/contact" class="btn btn-ghost">Contact Us</a>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
