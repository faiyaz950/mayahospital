<?php
/** Shared page head + top bar + navigation. Expects $page = ['id','title','description']. */
$nav = ['home' => 'Home', 'about' => 'About Us', 'services' => 'Services', 'gallery' => 'Gallery', 'contact' => 'Contact Us'];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page['title']) ?></title>
<meta name="description" content="<?= e($page['description']) ?>">
<link rel="canonical" href="<?= e(rtrim($site['url'], '/') . '/' . ($page['id'] === 'home' ? '' : $page['id'])) ?>">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['description']) ?>">
<meta property="og:image" content="<?= e(rtrim($site['url'], '/')) ?>/assets/img/logo.png">
<meta name="theme-color" content="#08343f">
<link rel="icon" type="image/png" href="/assets/img/favicon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css">
<?php if ($page['id'] === 'home'): ?>
<script>document.documentElement.classList.add('is-loading');setTimeout(function(){document.documentElement.classList.remove('is-loading')},6000)</script>
<?php endif; ?>
</head>
<body id="top">
<?php if ($page['id'] === 'home') include __DIR__ . '/splash.php'; ?>
<div class="topbar">
  <div class="container">
    <div class="tb-left">
      <span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg>Appointments: <a href="tel:<?= tel($site['phone_booking']) ?>"><?= e($site['phone_booking']) ?></a></span>
      <span class="hide-sm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1v-6h3zM3 19a2 2 0 0 0 2 2h1v-6H3z"/></svg>Helpline: <a href="tel:<?= tel($site['phone_helpline']) ?>"><?= e($site['phone_helpline']) ?></a></span>
    </div>
    <div class="tb-right">
      <span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg><?= e($site['address_short']) ?></span>
    </div>
  </div>
</div>

<header class="header">
  <div class="container nav">
    <a href="/" class="brand" aria-label="Maya Hospital home">
      <img src="/assets/img/logo.png" alt="Maya Hospital logo" width="46" height="41">
      <span class="brand-text"><strong>Maya Hospital</strong><span>Farrukhabad</span></span>
    </a>
    <nav aria-label="Main">
      <ul class="nav-links">
<?php foreach ($nav as $id => $label): ?>
        <li><a href="<?= url($id) ?>"<?= $id === $page['id'] ? ' class="active" aria-current="page"' : '' ?>><?= e($label) ?></a></li>
<?php endforeach; ?>
      </ul>
    </nav>
    <div class="nav-cta">
      <a href="/contact#appointment" class="btn btn-red btn-sm btn-desktop">Book Appointment <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      <button class="menu-toggle" aria-label="Open menu" aria-expanded="false"><span></span></button>
    </div>
  </div>
</header>
<main>
