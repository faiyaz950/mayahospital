<?php
require __DIR__ . '/includes/bootstrap.php';
$page = [
    'id'          => 'home',
    'title'       => hv('meta_title'),
    'description' => hv('meta_desc'),
];
include __DIR__ . '/includes/header.php';
?>
<section class="hero hero-x">
  <div class="hero-bg" aria-hidden="true">
    <div class="grid"></div>
    <span class="blob b1"></span><span class="blob b2"></span><span class="blob b3"></span>
  </div>
  <div class="container hero-grid">
    <div class="hero-copy">
      <div class="pill h-in" style="--d:.05s"><b>MAYA</b><span class="dot"></span> <?= h('hero_pill') ?></div>
      <h1 class="hero-title">
        <span class="ln"><span style="--d:.15s"><?= h('hero_line1') ?></span></span>
        <span class="ln"><em class="serif"><span style="--d:.3s"><?= h('hero_line2') ?></span></em><svg class="swash" viewBox="0 0 420 24" preserveAspectRatio="none" aria-hidden="true"><path d="M4 16 C 90 4, 200 4, 300 12 S 400 18, 416 8"/></svg></span>
        <span class="ln"><span style="--d:.45s"><?= h('hero_line3') ?></span></span>
      </h1>
      <p class="hero-lead h-in" style="--d:.65s"><?= h('hero_lead') ?></p>
      <div class="hero-actions h-in" style="--d:.8s">
        <a href="contact#appointment" class="btn btn-red btn-glow"><?= h('hero_btn1') ?> <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        <a href="services" class="btn btn-ghost"><?= h('hero_btn2') ?></a>
      </div>
      <div class="hero-meta h-in" style="--d:.95s">
        <div><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg></span><span><strong><a href="tel:<?= tel($site['phone_booking']) ?>"><?= e($site['phone_booking']) ?></a></strong><span>Appointment booking</span></span></div>
        <div><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></span><span><strong><?= h('hero_loc_title') ?></strong><span><?= h('hero_loc_sub') ?></span></span></div>
      </div>
    </div>
    <div class="hv" aria-label="Maya Hospital">
      <span class="hv-accent" aria-hidden="true"></span>
      <span class="hv-dots" aria-hidden="true"></span>
      <div class="hv-main h-pop" style="--d:.25s"><img src="<?= e(img(hv('hero_image'))) ?>" onerror="this.onerror=null;this.src='/assets/img/hero.svg'" alt="Maya Hospital building" width="800" height="920"></div>
      <div class="hv-docs h-chip" style="--d:1.1s">
        <div class="hv-doc"><span class="hv-doc-ic red"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="2" width="6" height="4" rx="1.5"/><rect x="8.5" y="7.5" width="7" height="4" rx="1.5"/><rect x="8" y="13" width="8" height="4" rx="1.5"/><rect x="7.5" y="18.5" width="9" height="3.5" rx="1.5"/></svg></span><span><strong>Pain &amp; Spine Care</strong><small>Dr. Satish Rajput</small></span></div>
        <div class="hv-doc"><span class="hv-doc-ic teal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><circle cx="10.5" cy="10.5" r="3.2"/><circle cx="16" cy="15" r="1"/></svg></span><span><strong>IVF &amp; Fertility</strong><small>Dr. Poonam Sharma</small></span></div>
      </div>
    </div>
  </div>
</section>

<section class="find-care" style="padding-bottom:56px">
  <div class="container">
    <div class="find-care-inner reveal">
      <strong><?= h('care_title') ?><small><?= h('care_sub') ?></small></strong>
      <div class="care-chips">
        <a class="care-chip" href="services#pain"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2v4M12 18v4M4.9 4.9l2.8 2.8M16.3 16.3l2.8 2.8M2 12h4M18 12h4M4.9 19.1l2.8-2.8M16.3 7.7l2.8-2.8"/><circle cx="12" cy="12" r="3"/></svg></span>Pain relief</a>
        <a class="care-chip" href="services#pain"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="2" width="6" height="4" rx="1.5"/><rect x="8.5" y="7.5" width="7" height="4" rx="1.5"/><rect x="8" y="13" width="8" height="4" rx="1.5"/><rect x="7.5" y="18.5" width="9" height="3.5" rx="1.5"/></svg></span>Spine &amp; joints</a>
        <a class="care-chip" href="services#ivf"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><circle cx="10.5" cy="10.5" r="3.2"/><circle cx="16" cy="15" r="1"/></svg></span>Fertility &amp; IVF</a>
        <a class="care-chip" href="about#doctors"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="5"/><path d="M12 13v9M9 19h6"/></svg></span>Women's health</a>
      </div>
      <a href="contact#appointment" class="btn btn-red btn-sm">Book now <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
  </div>
</section>

<div class="marquee" aria-hidden="true"><div class="marquee-track"><?php $mq = implode('', array_map(fn ($x) => '<span>' . e($x) . '</span>', lines(hv('marquee')))); echo $mq . $mq; ?></div></div>

<section class="section">
  <div class="container">
    <div class="split-head">
      <div class="section-head reveal">
        <span class="eyebrow"><?= h('svc_eyebrow') ?></span>
        <h2><?= h('svc_title') ?> <em class="serif accent"><?= h('svc_accent') ?></em></h2>
        <p><?= h('svc_text') ?></p>
      </div>
      <a href="services" class="btn btn-ghost reveal">View all services <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="svc-grid">
      <?= render_services() ?>
      <div class="svc-cta reveal d2">
        <span class="svc-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1v-6h3zM3 19a2 2 0 0 0 2 2h1v-6H3z"/></svg></span>
        <h3><?= h('svc_cta_title') ?></h3>
        <p><?= h('svc_cta_text') ?></p>
        <a href="tel:<?= tel($site['phone_helpline']) ?>" class="svc-cta-phone"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg> <?= e($site['phone_helpline']) ?></a>
        <a href="contact#appointment" class="btn btn-red btn-sm">Book Appointment <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container split">
    <div class="media-stack reveal">
      <div class="media-frame"><img src="<?= e(img(hv('about_image'))) ?>" alt="Maya Hospital" loading="lazy"></div>
      <div class="badge-card"><div class="big"><?= h('about_badge_num') ?></div><p><?= h('about_badge_text') ?></p></div>
    </div>
    <div>
      <span class="eyebrow reveal"><?= h('about_eyebrow') ?></span>
      <h2 class="reveal d1"><?= h('about_title') ?> <em class="serif accent"><?= h('about_accent') ?></em></h2>
      <p class="reveal d2"><?= h('about_text') ?></p>
      <ul class="check-list two reveal d3">
        <?php foreach (lines(hv('about_points')) as $pt): ?><li><?= e($pt) ?></li><?php endforeach; ?>
      </ul>
      <div class="hero-actions reveal d4">
        <a href="about" class="btn">Learn more about us <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      </div>
    </div>
  </div>
</section>

<section class="section hdoc-section">
  <div class="container hdoc-grid">
    <div class="hdoc-intro reveal">
      <span class="eyebrow"><?= h('doc_eyebrow') ?></span>
      <h2><?= h('doc_title') ?> <em class="serif accent"><?= h('doc_accent') ?></em></h2>
      <p><?= h('doc_text') ?></p>
      <ul class="hdoc-points">
        <?php foreach (array_slice(lines(hv('doc_points')), 0, 3) as $i => $pt): ?><li><span><?= icon(['steth', 'calendar', 'phone'][$i]) ?></span><?= e($pt) ?></li><?php endforeach; ?>
      </ul>
      <div class="hdoc-cta">
        <a href="about#doctors" class="btn">Full doctor profiles <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        <a href="tel:<?= tel($site['phone_booking']) ?>" class="hdoc-phone"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg><span><small>Appointments</small><?= e($site['phone_booking']) ?></span></a>
      </div>
    </div>
    <?= render_home_doctors() ?>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head center reveal">
      <span class="eyebrow"><?= h('steps_eyebrow') ?></span>
      <h2><?= h('steps_title') ?> <em class="serif accent"><?= h('steps_accent') ?></em></h2>
    </div>
    <div class="bento">
      <article class="card span-4 reveal"><span class="num">01</span><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg></span><h3><?= h('step1_title') ?></h3><p><?= h('step1_text') ?></p></article>
      <article class="card span-4 reveal d1"><span class="num">02</span><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3v6a5 5 0 0 0 10 0V3"/><path d="M11 14v2a5 5 0 0 0 10 0v-2"/><circle cx="21" cy="12" r="2"/></svg></span><h3><?= h('step2_title') ?></h3><p><?= h('step2_text') ?></p></article>
      <article class="card span-4 reveal d2"><span class="num">03</span><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 21v-4h6v4M10 8h4M12 6v4"/></svg></span><h3><?= h('step3_title') ?></h3><p><?= h('step3_text') ?></p></article>
    </div>
  </div>
</section>

<section class="section" style="background:#fff">
  <div class="container faq-wrap">
    <div class="section-head reveal" style="margin-bottom:0">
      <span class="eyebrow"><?= h('faq_eyebrow') ?></span>
      <h2><?= h('faq_title') ?> <em class="serif accent"><?= h('faq_accent') ?></em></h2>
      <p><?= rich(hv('faq_text')) ?></p>
    </div>
    <div class="faq">
      <?= render_faqs() ?>
    </div>
  </div>
</section>
<section class="section-sm">
  <div class="container">
    <div class="cta-band reveal">
      <span class="ring r1"></span><span class="ring r2"></span>
      <div>
        <span class="eyebrow" style="color:#ff8a8f"><?= h('cta_eyebrow') ?></span>
        <h2><?= h('cta_title') ?> <em class="serif"><?= h('cta_accent') ?></em></h2>
        <p><?= h('cta_text') ?></p>
      </div>
      <div class="cta-actions">
        <a class="phone-card" href="tel:<?= tel($site['phone_booking']) ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="3"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></span><span><small>Appointment Booking</small><strong><?= e($site['phone_booking']) ?></strong></span></a>
        <a class="phone-card" href="tel:<?= tel($site['phone_helpline']) ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1v-6h3zM3 19a2 2 0 0 0 2 2h1v-6H3z"/></svg></span><span><small>Central Helpline</small><strong><?= e($site['phone_helpline']) ?></strong></span></a>
      </div>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
