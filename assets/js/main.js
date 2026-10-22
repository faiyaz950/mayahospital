(function () {
  const doc = document.documentElement;

  // Splash screen (home page): shows on every visit, refresh and back/forward return
  let splash = document.getElementById('splash');
  if (splash) {
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const minTime = reduce ? 400 : 2400;
    let timers = [];
    const finish = () => {
      timers.forEach(clearTimeout);
      timers = [];
      splash.classList.add('hide');
      doc.classList.remove('is-loading');
    };
    const play = (fromStart) => {
      doc.classList.add('is-loading');
      if (fromStart) {
        const wait = () => timers.push(setTimeout(finish, Math.max(0, minTime - performance.now())));
        if (document.readyState === 'complete') wait();
        else window.addEventListener('load', wait, { once: true });
        timers.push(setTimeout(finish, 4500));
      } else {
        // restored from back/forward cache: restart the animation on a fresh copy
        const fresh = splash.cloneNode(true);
        fresh.classList.remove('hide');
        splash.replaceWith(fresh);
        splash = fresh;
        timers.push(setTimeout(finish, minTime));
      }
    };
    play(true);
    window.addEventListener('pageshow', (e) => { if (e.persisted) play(false); });
  }

  // Sticky header shadow + back-to-top
  const header = document.querySelector('.header');
  const topBtn = document.querySelector('.fab .top');
  const progress = document.createElement('div');
  progress.className = 'progress';
  document.body.prepend(progress);
  const onScroll = () => {
    const y = window.scrollY;
    const max = doc.scrollHeight - window.innerHeight;
    progress.style.setProperty('--p', max > 0 ? Math.min(y / max, 1) : 0);
    header && header.classList.toggle('scrolled', y > 8);
    topBtn && topBtn.classList.toggle('show', y > 600);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Mobile menu
  const toggle = document.querySelector('.menu-toggle');
  if (toggle) {
    toggle.addEventListener('click', () => {
      const open = doc.classList.toggle('menu-open');
      toggle.setAttribute('aria-expanded', open);
    });
    document.querySelectorAll('.nav-links a').forEach((a) =>
      a.addEventListener('click', () => doc.classList.remove('menu-open'))
    );
  }

  // Scroll reveal
  const els = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(
      (entries) => entries.forEach((e) => {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      }),
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    els.forEach((el) => io.observe(el));
  } else {
    els.forEach((el) => el.classList.add('in'));
  }

  // Cursor spotlight on cards (pointer devices only)
  if (window.matchMedia('(hover: hover)').matches) {
    document.querySelectorAll('.card, .doctor, .treatment, .info-card').forEach((el) =>
      el.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        el.style.setProperty('--mx', `${e.clientX - r.left}px`);
        el.style.setProperty('--my', `${e.clientY - r.top}px`);
      })
    );
  }

  // Home hero: gentle parallax on the image composition
  const hv = document.querySelector('.hv');
  if (hv && window.matchMedia('(hover: hover) and (prefers-reduced-motion: no-preference)').matches) {
    const hero = hv.closest('.hero');
    hero.addEventListener('pointermove', (e) => {
      const r = hv.getBoundingClientRect();
      hv.style.setProperty('--px', ((e.clientX - (r.left + r.width / 2)) / r.width).toFixed(3));
      hv.style.setProperty('--py', ((e.clientY - (r.top + r.height / 2)) / r.height).toFixed(3));
    });
    hero.addEventListener('pointerleave', () => { hv.style.setProperty('--px', 0); hv.style.setProperty('--py', 0); });
  }

  // Footer year
  document.querySelectorAll('[data-year]').forEach((el) => (el.textContent = new Date().getFullYear()));

  // Gallery filters + lightbox
  const filters = document.querySelectorAll('.filter');
  const cards = [...document.querySelectorAll('.g-card')];
  const countEl = document.querySelector('.gal-count strong');
  const visible = () => cards.filter((c) => !c.classList.contains('hide'));
  filters.forEach((btn) =>
    btn.addEventListener('click', () => {
      filters.forEach((b) => { b.classList.remove('active'); b.setAttribute('aria-pressed', 'false'); });
      btn.classList.add('active');
      btn.setAttribute('aria-pressed', 'true');
      const cat = btn.dataset.filter;
      cards.forEach((c) => c.classList.toggle('hide', cat !== 'all' && c.dataset.cat !== cat));
      if (countEl) countEl.textContent = visible().length;
    })
  );

  const lb = document.querySelector('.lightbox');
  if (lb && cards.length) {
    const lbImg = lb.querySelector('.lb-stage img');
    const lbTitle = lb.querySelector('.lb-title');
    const lbCat = lb.querySelector('.lb-cat');
    const lbCount = lb.querySelector('.lb-counter');
    let list = [], index = 0, lastFocus = null;
    const show = (i) => {
      index = (i + list.length) % list.length;
      const card = list[index];
      const img = card.querySelector('img');
      lbImg.src = img.currentSrc || img.src;
      lbImg.alt = img.alt;
      lbTitle.textContent = card.querySelector('strong').textContent;
      lbCat.textContent = card.querySelector('.g-cat').textContent;
      lbCount.textContent = `${index + 1} / ${list.length}`;
    };
    const open = (card) => {
      list = visible();
      lastFocus = document.activeElement;
      show(list.indexOf(card));
      lb.classList.add('open');
      lb.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      lb.querySelector('.lb-close').focus();
    };
    const close = () => {
      lb.classList.remove('open');
      lb.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      lastFocus && lastFocus.focus();
    };
    cards.forEach((c) => c.querySelector('.g-media').addEventListener('click', () => open(c)));
    lb.querySelector('.lb-close').addEventListener('click', close);
    lb.querySelector('.lb-prev').addEventListener('click', () => show(index - 1));
    lb.querySelector('.lb-next').addEventListener('click', () => show(index + 1));
    lb.addEventListener('click', (e) => { if (e.target === lb) close(); });
    document.addEventListener('keydown', (e) => {
      if (!lb.classList.contains('open')) return;
      if (e.key === 'Escape') close();
      if (e.key === 'ArrowLeft') show(index - 1);
      if (e.key === 'ArrowRight') show(index + 1);
    });
    let startX = null;
    lb.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', (e) => {
      if (startX === null) return;
      const dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 50) show(index + (dx < 0 ? 1 : -1));
      startX = null;
    });
  }

  // Appointment form -> WhatsApp message to the appointment desk
  const form = document.querySelector('#appointment-form');
  if (form) {
    const dateInput = form.querySelector('[name="date"]');
    if (dateInput) dateInput.min = new Date().toISOString().split('T')[0];

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (!form.reportValidity()) return;
      const d = Object.fromEntries(new FormData(form));
      const lines = [
        'Appointment Request — Maya Hospital',
        `Name: ${d.name}`,
        `Mobile: ${d.phone}`,
        `Department: ${d.department}`,
        d.doctor ? `Preferred Doctor: ${d.doctor}` : '',
        d.date ? `Preferred Date: ${d.date}` : '',
        d.message ? `Message: ${d.message}` : '',
      ].filter(Boolean);
      const url = `https://wa.me/919648046798?text=${encodeURIComponent(lines.join('\n'))}`;
      window.open(url, '_blank', 'noopener');
      form.querySelector('.form-success').classList.add('show');
    });
  }
})();
