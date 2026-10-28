<?php
require __DIR__ . '/includes/bootstrap.php';
$page = [
    'id'          => 'home',
    'title'       => 'Maya Hospital | Specialized Care in Farrukhabad',
    'description' => 'Maya Hospital, Farrukhabad — pain management, spine & joint care, radiofrequency, PRP therapy, physiotherapy, IVF & fertility care, obstetrics and gynaecology.',
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
      <div class="pill h-in" style="--d:.05s"><b>MAYA</b><span class="dot"></span> Healthcare in Farrukhabad, Uttar Pradesh</div>
      <h1 class="hero-title">
        <span class="ln"><span style="--d:.15s">Specialized Care.</span></span>
        <span class="ln"><em class="serif"><span style="--d:.3s">Personal Attention.</span></em><svg class="swash" viewBox="0 0 420 24" preserveAspectRatio="none" aria-hidden="true"><path d="M4 16 C 90 4, 200 4, 300 12 S 400 18, 416 8"/></svg></span>
        <span class="ln"><span style="--d:.45s">Better Health.</span></span>
      </h1>
      <p class="hero-lead h-in" style="--d:.65s">Welcome to Maya Hospital — find information about our specialties, medical professionals, treatment services and appointment contacts, all in one place.</p>
      <div class="hero-actions h-in" style="--d:.8s">
        <a href="contact#appointment" class="btn btn-red btn-glow">Book an Appointment <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        <a href="services" class="btn btn-ghost">Explore Our Services</a>
      </div>
      <div class="hero-meta h-in" style="--d:.95s">
        <div><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg></span><span><strong><a href="tel:<?= tel($site['phone_booking']) ?>"><?= e($site['phone_booking']) ?></a></strong><span>Appointment booking</span></span></div>
        <div><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></span><span><strong>Barhpur, Farrukhabad</strong><span>Awas Vikas Tiraha</span></span></div>
      </div>
    </div>
    <div class="hv" aria-label="Maya Hospital">
      <span class="hv-accent" aria-hidden="true"></span>
      <span class="hv-dots" aria-hidden="true"></span>
      <div class="hv-main h-pop" style="--d:.25s"><img src="assets/img/hero.jpg" onerror="this.onerror=null;this.src='assets/img/hero.svg'" alt="Maya Hospital building" width="800" height="920"></div>
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
      <strong>Find the right care<small>Choose what you need help with</small></strong>
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

<div class="marquee" aria-hidden="true"><div class="marquee-track"><span>Pain Management</span><span>Spine &amp; Joint Care</span><span>Radiofrequency Treatment</span><span>C-arm Guided Procedures</span><span>PRP Therapy</span><span>Physiotherapy</span><span>IVF &amp; Fertility Care</span><span>Obstetrics &amp; Gynaecology</span><span>Pain Management</span><span>Spine &amp; Joint Care</span><span>Radiofrequency Treatment</span><span>C-arm Guided Procedures</span><span>PRP Therapy</span><span>Physiotherapy</span><span>IVF &amp; Fertility Care</span><span>Obstetrics &amp; Gynaecology</span></div></div>

<section class="section">
  <div class="container">
    <div class="split-head">
      <div class="section-head reveal">
        <span class="eyebrow">Our Key Services</span>
        <h2>Care for different <em class="serif accent">healthcare needs</em></h2>
        <p>Pain management, spine and joint care, physiotherapy, and IVF and fertility-related healthcare — under one roof.</p>
      </div>
      <a href="services" class="btn btn-ghost reveal">View all services <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="svc-grid">
      <?= render_services() ?>
      <div class="svc-cta reveal d2">
        <span class="svc-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1v-6h3zM3 19a2 2 0 0 0 2 2h1v-6H3z"/></svg></span>
        <h3>Not sure which service you need?</h3>
        <p>Call the helpline and our team will guide you to the right department and doctor.</p>
        <a href="tel:<?= tel($site['phone_helpline']) ?>" class="svc-cta-phone"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg> <?= e($site['phone_helpline']) ?></a>
        <a href="contact#appointment" class="btn btn-red btn-sm">Book Appointment <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="container split">
    <div class="media-stack reveal">
      <div class="media-frame"><img src="assets/img/reception.jpg" onerror="this.onerror=null;this.src='assets/img/reception.svg'" alt="Illustration of the Maya Hospital reception" loading="lazy"></div>
      <div class="badge-card"><div class="big">5</div><p>Medical specialties featured across pain, spine, physiotherapy, fertility and women's health.</p></div>
    </div>
    <div>
      <span class="eyebrow reveal">About Maya Hospital</span>
      <h2 class="reveal d1">Healthcare close to home, <em class="serif accent">in Farrukhabad.</em></h2>
      <p class="reveal d2">Maya Hospital is located at Awas Vikas Tiraha, Barhpur, Farrukhabad. Explore service information, learn about the doctors featured by the hospital, and contact the team to enquire about consultation and appointments.</p>
      <ul class="check-list two reveal d3">
        <li>Pain Medicine</li><li>Spine &amp; Joint Care</li><li>Physiotherapy</li><li>IVF &amp; Fertility</li><li>Obstetrics &amp; Gynaecology</li><li>Appointment support</li>
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
      <span class="eyebrow">Meet Our Doctors</span>
      <h2>Specialists who <em class="serif accent">listen first.</em></h2>
      <p>Meet the doctors behind Maya Hospital&rsquo;s pain, spine, women&rsquo;s health and fertility care &mdash; qualified specialists who take time to understand your concern before discussing options.</p>
      <ul class="hdoc-points">
        <li><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3v6a5 5 0 0 0 10 0V3"/><path d="M11 14v2a5 5 0 0 0 10 0v-2"/><circle cx="21" cy="12" r="2"/></svg></span>Specialist consultation in two departments</li>
        <li><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="3"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></span>Consultation by appointment</li>
        <li><span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-12.4 7.4L3 21l2.1-5.6A8.4 8.4 0 1 1 21 11.5z"/></svg></span>Book by phone or the online form</li>
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
      <span class="eyebrow">Explore Maya Hospital</span>
      <h2>Your visit, in <em class="serif accent">three simple steps</em></h2>
    </div>
    <div class="bento">
      <article class="card span-4 reveal"><span class="num">01</span><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg></span><h3>Call or request online</h3><p>Use the appointment number or the Contact Us form to send your enquiry.</p></article>
      <article class="card span-4 reveal d1"><span class="num">02</span><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3v6a5 5 0 0 0 10 0V3"/><path d="M11 14v2a5 5 0 0 0 10 0v-2"/><circle cx="21" cy="12" r="2"/></svg></span><h3>Confirm department &amp; doctor</h3><p>The team helps identify the right department and confirms the date and time.</p></article>
      <article class="card span-4 reveal d2"><span class="num">03</span><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 21v-4h6v4M10 8h4M12 6v4"/></svg></span><h3>Visit the hospital</h3><p>Meet the specialist at Awas Vikas Tiraha, Barhpur, Farrukhabad.</p></article>
    </div>
  </div>
</section>

<section class="section" style="background:#fff">
  <div class="container faq-wrap">
    <div class="section-head reveal" style="margin-bottom:0">
      <span class="eyebrow">Questions &amp; Answers</span>
      <h2>Good to know <em class="serif accent">before you visit</em></h2>
      <p>Quick answers to common questions. For anything else, call the helpline at <a href="tel:<?= tel($site['phone_helpline']) ?>" style="color:var(--red-600);font-weight:700"><?= e($site['phone_helpline']) ?></a>.</p>
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
