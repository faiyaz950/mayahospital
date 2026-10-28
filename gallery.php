<?php
require __DIR__ . '/includes/bootstrap.php';
$page = [
    'id'          => 'gallery',
    'title'       => 'Gallery | Maya Hospital Farrukhabad',
    'description' => 'Gallery of Maya Hospital, Farrukhabad — exterior, reception, doctors, consultation rooms and services.',
];
include __DIR__ . '/includes/header.php';
?>
<section class="phero">
  <div class="container">
    <div class="phero-card">
      <span class="phero-ring r1"></span><span class="phero-ring r2"></span><span class="phero-glow"></span>
      <div class="phero-text">
        <nav class="phero-crumbs reveal" aria-label="Breadcrumb"><a href="./"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg>Home</a><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg><span>Gallery</span></nav>
<h1 class="reveal d1">A closer look at <em class="serif">Maya Hospital</em></h1>
        <p class="phero-lead reveal d2">Explore our healthcare environment, medical team and listed specialties &mdash; and get familiar with the hospital before your visit.</p>
</div>
</div>
  </div>
</section>

<section class="section" style="padding-top:20px">
  <div class="container">
    <div class="gal-toolbar reveal">
      <div class="filters" role="toolbar" aria-label="Filter photos">
        <?= render_gallery_filters() ?>
      </div>
      <p class="gal-count" aria-live="polite">Showing <strong><?= gallery_count() ?></strong> photos</p>
    </div>
    <div class="gal-grid">
      <?= render_gallery_items() ?>
    </div>
  </div>
</section>

<section class="section" style="background:#fff">
  <div class="container">
    <div class="section-head center reveal">
      <span class="eyebrow">Gallery Categories</span>
      <h2>What you'll <em class="serif accent">find here</em></h2>
    </div>
    <div class="guide-grid">
      <div class="guide reveal"><div class="n">01</div><h3 style="font-size:1.05rem">Exterior &amp; Entrance</h3><p>Recognize the building, entrance and signage when visiting.</p></div>
      <div class="guide reveal d1"><div class="n">02</div><h3 style="font-size:1.05rem">Reception &amp; Waiting</h3><p>Know where to arrive and whom to approach.</p></div>
      <div class="guide reveal d2"><div class="n">03</div><h3 style="font-size:1.05rem">Doctors &amp; Team</h3><p>Meet the specialists who will care for you.</p></div>
      <div class="guide reveal d3"><div class="n">04</div><h3 style="font-size:1.05rem">Consultation &amp; Facilities</h3><p>A look at rooms and facilities for our services.</p></div>
      <div class="guide reveal d4"><div class="n">05</div><h3 style="font-size:1.05rem">Services &amp; Awareness</h3><p>Pain, spine, physiotherapy and fertility care.</p></div>
    </div>
  </div>
</section>
<section class="section-sm">
  <div class="container">
    <div class="cta-band reveal">
      <span class="ring r1"></span><span class="ring r2"></span>
      <div>
        <span class="eyebrow" style="color:#ff8a8f">Book a consultation</span>
        <h2>Talk to our team <em class="serif">today.</em></h2>
        <p>Call the hospital to enquire about consultation availability, the right department and the doctor best suited to your needs.</p>
      </div>
      <div class="cta-actions">
        <a class="phone-card" href="tel:<?= tel($site['phone_booking']) ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="3"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></span><span><small>Appointment Booking</small><strong><?= e($site['phone_booking']) ?></strong></span></a>
        <a class="phone-card" href="tel:<?= tel($site['phone_helpline']) ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1v-6h3zM3 19a2 2 0 0 0 2 2h1v-6H3z"/></svg></span><span><small>Central Helpline</small><strong><?= e($site['phone_helpline']) ?></strong></span></a>
      </div>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
