/* Liberaspace site — shared interactions */

// Site loader — animate INTO the hero 3D position so the SVG icosahedron flows into the live scene
(function () {
  const loader = document.getElementById('siteLoader');
  if (!loader) return;

  // The target 3D element on this page (hero or sub-page hero)
  const hero3d = document.querySelector('.hero-stage3d, .page-hero-3d');
  // Hide it during loader so we can fade it in during transition
  if (hero3d) {
    hero3d.style.opacity = '0';
    hero3d.style.transition = 'opacity 0.85s cubic-bezier(0.2, 0.7, 0.2, 1)';
  }

  const MIN_MS = 1500;
  const start = performance.now();
  document.documentElement.style.overflow = 'hidden';

  const dismiss = () => {
    const elapsed = performance.now() - start;
    const wait = Math.max(0, MIN_MS - elapsed);
    setTimeout(() => {
      const stage = loader.querySelector('.loader-stage');

      // Compute target transform: fly to the hero 3D center, scaled to match the actual on-screen icosahedron
      if (stage && hero3d) {
        const heroRect = hero3d.getBoundingClientRect();
        const stageRect = stage.getBoundingClientRect();
        const dx = (heroRect.left + heroRect.width / 2) - (stageRect.left + stageRect.width / 2);
        const dy = (heroRect.top + heroRect.height / 2) - (stageRect.top + stageRect.height / 2);
        // SVG icosahedron occupies ~44% of stage; Three.js mid wireframe ~70% of hero canvas.
        // Empirical 1.6× multiplier lands the SVG ico ON TOP of the Three.js wireframe.
        const targetScale = Math.min(5.5, Math.max(1.4, (heroRect.width / stageRect.width) * 1.6));
        stage.style.transform = `translate(${dx.toFixed(1)}px, ${dy.toFixed(1)}px) scale(${targetScale.toFixed(3)})`;
        // On SP the hero 3D is a dimmed background (opacity 0.55) — soften the SVG ico
        // so the cross-fade doesn't show a sudden brightness shift
        if (window.innerWidth <= 820) {
          stage.style.opacity = '0.65';
        }
      } else if (stage) {
        // No 3D target on this page — just scale up + fade
        stage.style.transform = 'scale(2.4)';
      }

      loader.classList.add('is-transitioning');
      document.documentElement.style.overflow = '';

      // Reveal hero 3D as the icosahedron arrives at its position
      setTimeout(() => { if (hero3d) hero3d.style.opacity = ''; }, 500);
      // Fade out the SVG icosahedron (Three.js scene takes over)
      setTimeout(() => { loader.classList.add('fade-stage'); }, 950);
      // Remove loader from DOM
      setTimeout(() => {
        loader.remove();
        if (hero3d) hero3d.style.transition = '';
      }, 1700);
    }, wait);
  };

  if (document.readyState === 'complete') {
    requestAnimationFrame(dismiss);
  } else {
    window.addEventListener('load', dismiss, { once: true });
    // Hard fallback
    setTimeout(dismiss, 6000);
  }
})();

// Inject mobile nav (hamburger + slide panel) into every page
(function () {
  const nav = document.querySelector('.nav .nav-inner');
  const ctaBtn = nav && nav.querySelector('.nav-cta');
  const linksWrap = nav && nav.querySelector('.nav-links');
  if (!nav || !ctaBtn || !linksWrap) return;

  // Build toggle button
  const toggle = document.createElement('button');
  toggle.className = 'nav-toggle';
  toggle.setAttribute('aria-label', 'メニュー');
  toggle.setAttribute('aria-expanded', 'false');
  toggle.innerHTML = '<span></span><span></span><span></span>';
  nav.insertBefore(toggle, ctaBtn.nextSibling);

  // Build slide-out panel from nav-links
  const panel = document.createElement('div');
  panel.className = 'nav-mobile-panel';
  panel.setAttribute('aria-hidden', 'true');
  // Map each link from existing nav-links
  const links = [
    ['/',         'Top',      'TOP'],
    ['/services', 'Services', 'SERVICES'],
    ['/works',    'Works',    'WORKS'],
    ['/blog',     'Blog',     'BLOG'],
    ['/company',  'Company',  'COMPANY']
  ];
  const here = location.pathname;
  const isActive = (href) => href === '/' ? here === '/' : (here === href || here.startsWith(href + '/'));
  panel.innerHTML = links.map(([href, jp, en]) =>
    `<a href="${href}"${isActive(href) ? ' class="active"' : ''}>${jp}<span class="en">${en}</span></a>`
  ).join('') + `<a class="panel-cta" href="/company#contact">無料相談 <span aria-hidden="true">→</span></a>`;
  document.body.appendChild(panel);

  function setOpen(open) {
    toggle.setAttribute('aria-expanded', String(open));
    panel.classList.toggle('open', open);
    panel.setAttribute('aria-hidden', String(!open));
    document.body.style.overflow = open ? 'hidden' : '';
  }
  toggle.addEventListener('click', () => {
    setOpen(toggle.getAttribute('aria-expanded') !== 'true');
  });
  panel.addEventListener('click', (e) => {
    if (e.target.closest('a')) setOpen(false);
  });
  window.addEventListener('resize', () => {
    if (window.innerWidth > 960) setOpen(false);
  });
})();

// Nav scrolled state
(function () {
  const nav = document.querySelector('.nav');
  if (!nav) return;
  const setScrolled = () => nav.classList.toggle('scrolled', window.scrollY > 8);
  setScrolled();
  window.addEventListener('scroll', setScrolled, { passive: true });
})();

// Reveal on scroll
(function () {
  const els = document.querySelectorAll('.appear');
  if (!els.length) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        e.target.classList.add('in');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.01, rootMargin: '0px 0px -10px 0px' });
  els.forEach((el) => io.observe(el));
  // Ensure anything already in viewport on load reveals even if observer is slow
  requestAnimationFrame(() => {
    els.forEach((el) => {
      const r = el.getBoundingClientRect();
      if (r.top < window.innerHeight && r.bottom > 0) el.classList.add('in');
    });
  });
})();

// Custom cursor (dot + lerping ring)
(function () {
  if (matchMedia('(pointer: coarse)').matches) return;
  const dot = document.createElement('div');
  const ring = document.createElement('div');
  dot.className = 'cursor-dot';
  ring.className = 'cursor-ring';
  document.body.appendChild(dot);
  document.body.appendChild(ring);
  let mx = -100, my = -100, rx = -100, ry = -100;
  window.addEventListener('mousemove', (e) => {
    mx = e.clientX; my = e.clientY;
    dot.style.left = mx + 'px';
    dot.style.top  = my + 'px';
  });
  const tick = () => {
    rx += (mx - rx) * 0.18;
    ry += (my - ry) * 0.18;
    ring.style.left = rx + 'px';
    ring.style.top  = ry + 'px';
    requestAnimationFrame(tick);
  };
  tick();
  document.addEventListener('mouseover', (e) => {
    if (e.target.closest('a, button, [data-hover]')) ring.classList.add('hover');
  });
  document.addEventListener('mouseout', (e) => {
    if (e.target.closest('a, button, [data-hover]')) ring.classList.remove('hover');
  });
})();

// Magnetic buttons
(function () {
  document.querySelectorAll('.magnet').forEach((el) => {
    let raf;
    el.addEventListener('mousemove', (e) => {
      const r = el.getBoundingClientRect();
      const x = e.clientX - r.left - r.width / 2;
      const y = e.clientY - r.top - r.height / 2;
      cancelAnimationFrame(raf);
      raf = requestAnimationFrame(() => {
        el.style.transform = `translate(${x * 0.25}px, ${y * 0.35}px)`;
      });
    });
    el.addEventListener('mouseleave', () => {
      cancelAnimationFrame(raf);
      el.style.transform = '';
    });
  });
})();

// Number count-up on appear
(function () {
  const nums = document.querySelectorAll('[data-count]');
  if (!nums.length) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      const el = e.target;
      const target = parseFloat(el.dataset.count);
      const dec = (el.dataset.dec ? parseInt(el.dataset.dec) : 0);
      const dur = 1400;
      const t0 = performance.now();
      const tick = (t) => {
        const p = Math.min(1, (t - t0) / dur);
        const eased = 1 - Math.pow(1 - p, 3);
        const val = target * eased;
        el.textContent = dec ? val.toFixed(dec) : Math.round(val).toString();
        if (p < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
      io.unobserve(el);
    });
  }, { threshold: 0.5 });
  nums.forEach((n) => io.observe(n));
})();

// Section in-view trigger — adds `.vis` to sections (and any [data-vis] element)
// when they scroll into view. CSS keys section-level entry animations off this.
(function () {
  const els = document.querySelectorAll('section, [data-vis]');
  if (!els.length) return;
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        e.target.classList.add('vis');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.18, rootMargin: '0px 0px -50px 0px' });
  els.forEach((el) => io.observe(el));
  // Trigger anything already in viewport on load
  requestAnimationFrame(() => {
    els.forEach((el) => {
      const r = el.getBoundingClientRect();
      if (r.top < window.innerHeight * 0.85 && r.bottom > 0) el.classList.add('vis');
    });
  });
})();

// Parallax — translate elements by their position relative to the viewport.
// Usage:
//   data-parallax="0.3"      (Y: positive = moves opposite scroll / appears slower)
//   data-parallax-x="0.5"    (X drift)
//   data-parallax-rotate="8" (degrees of rotation across viewport)
//   data-parallax-scale="0.15" (scale delta)
// Only applies while element is near viewport; clamped to ±range to stay tasteful.
(function () {
  if (matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  const sel = '[data-parallax], [data-parallax-x], [data-parallax-rotate], [data-parallax-scale]';
  const els = [...document.querySelectorAll(sel)];
  if (!els.length) return;

  const anchors = new WeakMap();
  const measure = () => {
    els.forEach((el) => {
      el.style.setProperty('--py', '0px');
      el.style.setProperty('--px', '0px');
      el.style.setProperty('--pr', '0deg');
      el.style.setProperty('--ps', '1');
      const rect = el.getBoundingClientRect();
      anchors.set(el, rect.top + window.scrollY + rect.height / 2);
    });
  };

  let raf = 0;
  const apply = () => {
    const sy = window.scrollY;
    const vh = window.innerHeight;
    const cy = sy + vh / 2;
    const limit = vh * 1.2;
    els.forEach((el) => {
      const anchor = anchors.get(el);
      if (anchor == null) return;
      const dist = cy - anchor;
      const clamped = Math.max(-limit, Math.min(limit, dist));

      const my = parseFloat(el.dataset.parallax) || 0;
      const mx = parseFloat(el.dataset.parallaxX) || 0;
      const mr = parseFloat(el.dataset.parallaxRotate) || 0;
      const ms = parseFloat(el.dataset.parallaxScale) || 0;

      if (my) el.style.setProperty('--py', (clamped * my).toFixed(2) + 'px');
      if (mx) el.style.setProperty('--px', (clamped * mx).toFixed(2) + 'px');
      if (mr) {
        const norm = clamped / limit; // -1..1
        el.style.setProperty('--pr', (norm * mr).toFixed(2) + 'deg');
      }
      if (ms) {
        const norm = clamped / limit;
        el.style.setProperty('--ps', (1 + norm * ms).toFixed(3));
      }
    });
    raf = 0;
  };
  const onScroll = () => { if (!raf) raf = requestAnimationFrame(apply); };

  requestAnimationFrame(() => { measure(); apply(); });
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', () => { measure(); apply(); }, { passive: true });
  window.addEventListener('load', () => { measure(); apply(); });
})();
