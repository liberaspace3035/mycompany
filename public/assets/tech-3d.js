/* Shared mini Three.js wireframe widget for sub-page heroes */
(function () {
  if (!window.THREE) return;
  document.querySelectorAll('canvas[data-tech-3d]').forEach((canvas) => {
    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
    renderer.setPixelRatio(Math.min(2, window.devicePixelRatio));

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(38, 1, 0.1, 100);
    camera.position.set(0, 0, 10);

    const ACCENT = 0x56847A;
    const INK    = 0x191B1A;

    // Core
    const coreGeo = new THREE.IcosahedronGeometry(0.55, 0);
    const core = new THREE.Mesh(coreGeo,
      new THREE.MeshBasicMaterial({ color: ACCENT, transparent: true, opacity: 0.95 }));
    scene.add(core);
    const coreWire = new THREE.LineSegments(new THREE.EdgesGeometry(coreGeo),
      new THREE.LineBasicMaterial({ color: 0x16241F, transparent: true, opacity: 0.5 }));
    scene.add(coreWire);

    // Mid wire
    const mid = new THREE.LineSegments(
      new THREE.EdgesGeometry(new THREE.IcosahedronGeometry(1.55, 1)),
      new THREE.LineBasicMaterial({ color: ACCENT, transparent: true, opacity: 0.7 })
    );
    scene.add(mid);

    // Outer faint
    const outer = new THREE.LineSegments(
      new THREE.EdgesGeometry(new THREE.IcosahedronGeometry(2.35, 0)),
      new THREE.LineBasicMaterial({ color: INK, transparent: true, opacity: 0.18 })
    );
    scene.add(outer);

    // Ring particles
    const ringGeo = new THREE.BufferGeometry();
    const N = 70;
    const pos = new Float32Array(N * 3);
    for (let i = 0; i < N; i++) {
      const a = (i / N) * Math.PI * 2;
      const r = 2.9 + (Math.random() - 0.5) * 0.2;
      pos[i*3] = Math.cos(a) * r;
      pos[i*3+1] = (Math.random() - 0.5) * 0.18;
      pos[i*3+2] = Math.sin(a) * r;
    }
    ringGeo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    const ring = new THREE.Points(ringGeo, new THREE.PointsMaterial({
      color: INK, size: 0.045, transparent: true, opacity: 0.7
    }));
    ring.rotation.x = Math.PI * 0.42;
    ring.rotation.z = Math.PI * 0.08;
    scene.add(ring);

    function resize() {
      const w = canvas.clientWidth;
      const h = canvas.clientHeight;
      if (!w || !h) return;
      if (canvas.width === w && canvas.height === h) return;
      renderer.setSize(w, h, false);
      camera.aspect = w / h;
      camera.updateProjectionMatrix();
    }
    resize();
    window.addEventListener('resize', resize, { passive: true });
    if (window.ResizeObserver) {
      const ro = new ResizeObserver(resize);
      ro.observe(canvas);
    }

    let t = Math.random() * 10;
    (function tick() {
      resize();
      t += 0.006;
      mid.rotation.y = t * 0.8;
      mid.rotation.x = t * 0.4;
      outer.rotation.y = -t * 0.3;
      outer.rotation.z = t * 0.18;
      core.rotation.y = t * 1.2;
      core.rotation.x = t * 0.6;
      coreWire.rotation.copy(core.rotation);
      ring.rotation.y = t * 0.55;
      const pulse = 1 + Math.sin(t * 3) * 0.06;
      core.scale.setScalar(pulse);
      coreWire.scale.setScalar(pulse);
      renderer.render(scene, camera);
      requestAnimationFrame(tick);
    })();
  });
})();
