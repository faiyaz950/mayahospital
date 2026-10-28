<?php
require __DIR__ . '/includes/bootstrap.php';
$page = [
    'id'          => 'contact',
    'title'       => 'Contact Us & Book Appointment | Maya Hospital Farrukhabad',
    'description' => 'Contact Maya Hospital, Awas Vikas Tiraha, Barhpur, Farrukhabad. Appointment: +91 96480 46798. Helpline: +91 77740 47404.',
];
include __DIR__ . '/includes/header.php';
?>
<section class="phero">
  <div class="container">
    <div class="phero-card">
      <span class="phero-ring r1"></span><span class="phero-ring r2"></span><span class="phero-glow"></span>
      <div class="phero-text">
        <nav class="phero-crumbs reveal" aria-label="Breadcrumb"><a href="./"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg>Home</a><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg><span>Contact Us</span></nav>
<h1 class="reveal d1">Contact <em class="serif">Maya Hospital</em></h1>
        <p class="phero-lead reveal d2">For questions about consultations, listed services or appointment availability, reach us using the details below.</p>
</div>
</div>
  </div>
</section>

<section class="section" style="padding-top:20px" id="appointment">
  <div class="container contact-grid">
    <div class="info-stack">
      <a class="info-card primary reveal" href="tel:<?= tel($site['phone_booking']) ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="3"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></span><span><small>Appointment Booking</small><strong><?= e($site['phone_booking']) ?></strong></span></a>
      <a class="info-card reveal d1" href="tel:<?= tel($site['phone_helpline']) ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1v-6h3zM3 19a2 2 0 0 0 2 2h1v-6H3z"/></svg></span><span><small>Central Helpline</small><strong><?= e($site['phone_helpline']) ?></strong></span></a>
      <a class="info-card reveal d2" href="tel:<?= tel($site['phone_extra']) ?>"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg></span><span><small>Additional Contact</small><strong><?= e($site['phone_extra']) ?></strong></span></a>
      <div class="info-card reveal d3"><span class="ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></span><span><small>Hospital Address</small><strong>Maya Hospital, Awas Vikas Tiraha, Barhpur, Farrukhabad, Uttar Pradesh – 209625, India</strong></span></div>
      <div class="notice reveal d4"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg><p>Please confirm the appropriate department and doctor when making an enquiry. Share only the information needed to respond to your request.</p></div>
    </div>

    <div class="form-card reveal d1">
      <span class="eyebrow">Appointment Request</span>
      <h2>Request an <em class="serif accent">appointment</em></h2>
      <p style="color:var(--ink-3);margin:0">Your request is pending until the hospital confirms the date and time.</p>
      <?php
      $flash = $_SESSION['appointment_flash'] ?? null;
      unset($_SESSION['appointment_flash']);
      $old = $flash['old'] ?? [];
      ?>
      <form id="appointment-form" action="appointment.php" method="post" novalidate>
        <?= csrf_field() ?>
        <div class="hp-field" aria-hidden="true"><label for="f-website">Website</label><input id="f-website" name="website" tabindex="-1" autocomplete="off"></div>
        <div class="form-grid">
          <div class="field"><label for="f-name">Patient Name *</label><input id="f-name" name="name" required maxlength="100" autocomplete="name" placeholder="Full name" value="<?= e($old['name'] ?? '') ?>"></div>
          <div class="field"><label for="f-phone">Mobile Number *</label><input id="f-phone" name="phone" type="tel" required pattern="[0-9+ ]{10,15}" maxlength="15" autocomplete="tel" placeholder="10-digit mobile number" value="<?= e($old['phone'] ?? '') ?>"></div>
          <div class="field"><label for="f-dept">Department *</label>
            <select id="f-dept" name="department" required>
              <option value="">Select department</option>
<?php foreach ($config['departments'] as $d): ?>
              <option<?= ($old['department'] ?? '') === $d ? ' selected' : '' ?>><?= e($d) ?></option>
<?php endforeach; ?>
            </select>
          </div>
          <div class="field"><label for="f-doc">Preferred Doctor</label>
            <select id="f-doc" name="doctor">
              <option value="">No preference</option>
<?php foreach ($config['doctors'] as $d): ?>
              <option<?= ($old['doctor'] ?? '') === $d ? ' selected' : '' ?>><?= e($d) ?></option>
<?php endforeach; ?>
            </select>
          </div>
          <div class="field full"><label for="f-date">Preferred Appointment Date</label><input id="f-date" name="date" type="date" min="<?= date('Y-m-d') ?>" value="<?= e($old['date'] ?? '') ?>"></div>
          <div class="field full"><label for="f-msg">Brief Message</label><textarea id="f-msg" name="message" maxlength="1000" placeholder="Briefly describe your concern (optional)"><?= e($old['message'] ?? '') ?></textarea></div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-red">Submit Appointment Request <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></button>
          <a href="tel:<?= tel($site['phone_booking']) ?>" class="btn btn-ghost"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg> Call instead</a>
        </div>
        <p class="form-note">Your request goes directly to the hospital&rsquo;s appointment desk. The team will call you on the number you share to confirm the date and time. Your details are used only to respond to your request.</p>
        <div class="form-error<?= ($flash['type'] ?? '') === 'error' ? ' show' : '' ?>" role="alert"><?= e(($flash['type'] ?? '') === 'error' ? $flash['message'] : '') ?></div>
        <div class="form-success<?= ($flash['type'] ?? '') === 'success' ? ' show' : '' ?>" role="status"><?= e(($flash['type'] ?? '') === 'success' ? $flash['message'] : '') ?></div>
      </form>
    </div>
  </div>
</section>

<section class="section-sm" style="padding-top:0">
  <div class="container">
    <div class="split-head" style="margin-bottom:28px">
      <div class="section-head reveal">
        <span class="eyebrow">Find Us</span>
        <h2>Visit the <em class="serif accent">hospital</em></h2>
      </div>
      <a class="btn btn-ghost reveal" href="https://www.google.com/maps/search/?api=1&amp;query=Maya+Hospital+Awas+Vikas+Tiraha+Barhpur+Farrukhabad" target="_blank" rel="noopener">Open in Google Maps <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
    <div class="map-wrap reveal">
      <iframe title="Map to Maya Hospital, Farrukhabad" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Awas+Vikas+Tiraha,+Barhpur,+Farrukhabad,+Uttar+Pradesh+209625&amp;output=embed"></iframe>
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
