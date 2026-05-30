@extends("layouts.site")

@push("head")
  <style>
    /* ============ Page-specific ============ */

    /* ---------- HERO (Tech edition) ---------- */
    .hero {
      position: relative;
      min-height: 100vh;
      padding: calc(var(--nav-h) + 56px) 0 64px;
      overflow: hidden;
      background: var(--bg);
    }
    /* Technical grid + dot field (replaces gradient blobs) */
    .hero-bg {
      position: absolute; inset: 0;
      pointer-events: none;
      z-index: 0;
    }
    .hero-bg .tech-grid {
      position: absolute; inset: 0;
      background-image:
        linear-gradient(to right, rgba(25,27,26,0.045) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(25,27,26,0.045) 1px, transparent 1px);
      background-size: 64px 64px;
      mask-image: radial-gradient(ellipse 110% 75% at 55% 50%, #000 35%, transparent 92%);
      -webkit-mask-image: radial-gradient(ellipse 110% 75% at 55% 50%, #000 35%, transparent 92%);
    }
    .hero-bg .tech-dots {
      position: absolute; inset: 0;
      background-image: radial-gradient(circle, rgba(25,27,26,0.16) 1px, transparent 1.4px);
      background-size: 64px 64px;
      background-position: 32px 32px;
      mask-image: radial-gradient(ellipse 80% 60% at 60% 55%, #000 25%, transparent 85%);
      -webkit-mask-image: radial-gradient(ellipse 80% 60% at 60% 55%, #000 25%, transparent 85%);
      opacity: 0.55;
    }
    /* Scanning line that travels across hero */
    .hero-bg .scan {
      position: absolute;
      top: 18%;
      left: 0; right: 0;
      height: 1px;
      background: linear-gradient(to right,
        transparent 0%,
        rgba(86,132,122,0.0) 10%,
        rgba(86,132,122,0.55) 50%,
        rgba(86,132,122,0.0) 90%,
        transparent 100%);
      animation: scan-y 9s ease-in-out infinite;
      opacity: 0.85;
    }
    @keyframes scan-y {
      0%, 100% { transform: translateY(0); opacity: 0.0; }
      10%      { opacity: 0.85; }
      90%      { opacity: 0.85; }
      50%      { transform: translateY(58vh); }
    }
    /* Crosshair corner brackets — removed for a cleaner, more open hero */
    .hero-corner {
      display: none;
      position: absolute;
      width: 22px; height: 22px;
      border: 1.5px solid var(--text);
      z-index: 1;
      pointer-events: none;
      opacity: 0.7;
    }
    .hero-corner.tl { top: calc(var(--nav-h) + 20px); left: var(--gutter);  border-right: 0; border-bottom: 0; }
    .hero-corner.tr { top: calc(var(--nav-h) + 20px); right: var(--gutter); border-left: 0;  border-bottom: 0; }
    .hero-corner.bl { bottom: 36px; left: var(--gutter);  border-right: 0; border-top: 0; }
    .hero-corner.br { bottom: 36px; right: var(--gutter); border-left: 0;  border-top: 0; }

    .hero-inner {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      grid-template-rows: auto 1fr auto auto auto;
      column-gap: 24px;
      row-gap: 24px;
      min-height: calc(100vh - 240px);
    }
    /* Floating year numeral in negative space */
    .hero-numeral {
      position: absolute;
      top: 8%;
      left: 2%;
      font-family: var(--font-en);
      font-weight: 400;
      font-size: clamp(80px, 9vw, 140px);
      line-height: 1;
      letter-spacing: -0.04em;
      color: transparent;
      -webkit-text-stroke: 1px var(--text-faint);
      pointer-events: none;
      user-select: none;
      z-index: 0;
      opacity: 0.4;
    }
    /* Top-left meta (editorial corner) */
    .hero-top-l {
      grid-column: 1 / span 7;
      grid-row: 1;
      display: flex;
      align-items: center;
      gap: 14px;
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.2em;
      color: var(--text-dim);
      text-transform: uppercase;
      z-index: 5;
    }
    .hero-top-l strong { color: var(--text); font-weight: 600; }
    .hero-top-l .rule { width: 32px; height: 1px; background: var(--text-faint); display: inline-block; }

    /* Top-right tag / status */
    .hero-top-r {
      grid-column: 8 / -1;
      grid-row: 1;
      justify-self: end;
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.2em;
      color: var(--text-dim);
      text-transform: uppercase;
      z-index: 5;
      background: var(--bg);
      padding: 2px 0 2px 12px;
    }
    .hero-top-r .live {
      width: 8px; height: 8px;
      background: var(--accent);
      border-radius: 50%;
      animation: pulse-dot 1.8s ease-in-out infinite;
      box-shadow: 0 0 0 0 rgba(86, 132, 122, 0.5);
    }
    @keyframes pulse-dot {
      0%, 100% { box-shadow: 0 0 0 0 rgba(86, 132, 122, 0.5); }
      50%      { box-shadow: 0 0 0 10px rgba(86, 132, 122, 0); }
    }

    .hero-headline {
      grid-column: 1 / span 5;
      grid-row: 2;
      align-self: center;
      position: relative;
    }
    .hero h1 {
      font-family: var(--font-en);
      font-weight: 600;
      font-size: clamp(40px, 5.4vw, 84px);
      line-height: 1.02;
      letter-spacing: -0.035em;
      max-width: 16ch;
      margin: 0;
    }
    .hero h1 .accent  { color: var(--c-orange); }
    .hero h1 .pink    { color: var(--c-pink); }
    .hero h1 .violet  { color: var(--c-violet); }
    .hero h1 .blue    { color: var(--c-blue); }
    .hero h1 .row { display: block; }
    .hero h1 .row.r2 { padding-left: 0.6em; }
    .hero h1 .row.r3 { padding-left: 0.15em; }

    .hero-tag-jp {
      margin: 18px 0 0;
      font-family: var(--font-jp);
      font-weight: 600;
      font-size: clamp(15px, 1.25vw, 19px);
      line-height: 1.5;
      letter-spacing: 0.02em;
      color: var(--text);
      max-width: 28ch;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .hero-tag-jp::before {
      content: '';
      width: 22px;
      height: 1px;
      background: var(--accent);
      flex-shrink: 0;
    }

    .hero h1 .word { display: inline-block; position: relative; }
    .hero h1 .word.shake:hover { animation: shake 0.4s ease-in-out; }
    @keyframes shake {
      0%,100% { transform: rotate(0); }
      25% { transform: rotate(-3deg); }
      75% { transform: rotate(3deg); }
    }
    .hero h1 .scribble {
      position: relative;
      display: inline-block;
    }
    .hero h1 .scribble svg {
      position: absolute;
      left: -5%; bottom: -0.12em;
      width: 110%;
      height: 0.3em;
      overflow: visible;
    }
    .hero h1 .scribble svg path {
      stroke-dasharray: 1000;
      stroke-dashoffset: 1000;
      animation: drawIn 1.6s 0.6s cubic-bezier(0.2,0.7,0.2,1) forwards;
    }
    @keyframes drawIn { to { stroke-dashoffset: 0; } }

    .hero-bottom-l {
      grid-column: 1 / span 6;
      grid-row: 3;
      align-self: end;
      max-width: 44ch;
    }
    .hero-sub {
      color: var(--text-dim);
      font-size: clamp(15px, 1.15vw, 17px);
      line-height: 1.85;
    }
    .hero-sub strong { color: var(--text); font-weight: 600; }
    .hero-sub .hi { font-weight: 600; }

    .hero-bottom-r {
      grid-column: 1 / span 7;
      grid-row: 4;
      align-self: end;
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      flex-wrap: wrap;
    }
    .hero-cta {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 12px;
      flex-wrap: wrap;
    }
    .hero-foot-cue {
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      color: var(--text-muted);
      text-transform: uppercase;
    }
    .scroll-line {
      width: 56px; height: 1px; background: var(--text-faint);
      position: relative; overflow: hidden;
    }
    .scroll-line::after {
      content: ''; position: absolute; inset: 0;
      background: var(--accent);
      transform: translateX(-100%);
      animation: slideIn 2.4s infinite;
    }
    @keyframes slideIn {
      0%   { transform: translateX(-100%); }
      50%  { transform: translateX(0); }
      100% { transform: translateX(100%); }
    }

    /* ---------- 3D wireframe stage (Three.js canvas) ---------- */
    .hero-stage3d {
      position: absolute;
      top: 50%;
      right: -6%;
      transform: translateY(-50%);
      width: clamp(460px, 60vw, 820px);
      height: clamp(460px, 60vw, 820px);
      z-index: 1;
      pointer-events: none;
    }
    .hero-stage3d canvas {
      display: block;
      width: 100% !important;
      height: 100% !important;
    }
    /* Tech labels floating around the 3D stage */
    .stage-label {
      position: absolute;
      font-family: var(--font-mono);
      font-size: 10px;
      letter-spacing: 0.16em;
      color: var(--text-muted);
      text-transform: uppercase;
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
      z-index: 2;
      pointer-events: none;
    }
    .stage-label .swatch {
      width: 8px; height: 8px;
      background: var(--text);
      border-radius: 1px;
    }
    .stage-label .swatch.accent { background: var(--accent); }
    .stage-label .swatch.ring   { background: transparent; border: 1px solid var(--text); }
    .stage-label .line {
      width: 28px; height: 1px;
      background: var(--text-faint);
    }
    .stage-label.top-r  { top: 8%;   right: 4%; }
    .stage-label.mid-l  { top: 50%;  left: -2%; transform: translateY(-50%); }
    .stage-label.bot-r  { bottom: 8%; right: 6%; }
    /* Status pill on stage */
    .stage-status {
      position: absolute;
      top: 18%;
      left: 50%;
      transform: translateX(-50%);
      padding: 6px 12px;
      background: var(--text);
      color: var(--bg);
      border-radius: 4px;
      font-family: var(--font-mono);
      font-size: 10px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      z-index: 3;
    }
    .stage-status::before {
      content: '';
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--accent);
      animation: pulse-dot 1.6s ease-in-out infinite;
    }
    /* Data readout strip */
    .hero-readout {
      grid-column: 1 / -1;
      grid-row: 5;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
      margin-top: 8px;
    }
    .hero-readout .cell {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .hero-readout .k {
      font-family: var(--font-mono);
      font-size: 10px;
      letter-spacing: 0.2em;
      color: var(--text-muted);
      text-transform: uppercase;
    }
    .hero-readout .v {
      font-family: var(--font-en);
      font-size: 17px;
      font-weight: 500;
      color: var(--text);
      letter-spacing: -0.005em;
      display: flex;
      align-items: baseline;
      gap: 6px;
    }
    .hero-readout .v .unit {
      font-family: var(--font-mono);
      font-size: 11px;
      color: var(--text-dim);
      letter-spacing: 0.1em;
    }
    .hero-readout .v .pulse {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: var(--accent);
      animation: pulse-dot 1.8s ease-in-out infinite;
      align-self: center;
      margin-left: 4px;
      box-shadow: 0 0 0 0 rgba(86, 132, 122, 0.5);
    }

    /* ---------- Section stamp (huge ghost text drifting horizontally) ---------- */
    .section-stamp {
      position: absolute;
      top: 50%;
      left: -20vw;
      right: -20vw;
      transform: translateY(-50%);
      font-family: var(--font-en);
      font-weight: 700;
      font-size: clamp(140px, 22vw, 380px);
      letter-spacing: -0.05em;
      line-height: 0.9;
      color: transparent;
      -webkit-text-stroke: 1.5px var(--border-2);
      white-space: nowrap;
      pointer-events: none;
      user-select: none;
      z-index: 0;
      text-align: center;
      opacity: 0.75;
    }
    .section-stamp.top { top: 14%; }
    .section-stamp.bottom { top: auto; bottom: 6%; }
    .section-stamp.solid {
      color: var(--text-faint);
      -webkit-text-stroke: 0;
      opacity: 0.32;
    }
    .section-stamp.outline-bright {
      -webkit-text-stroke-color: var(--accent);
      opacity: 0.35;
    }
    /* Ensure section content stacks above the stamp */
    .section > .container,
    .ai-section > .container,
    .principles > .container,
    .how > .container,
    .works-preview > .container,
    .why > .container,
    .cta > .container,
    .at-glance > .container {
      position: relative;
      z-index: 2;
    }

    /* ---------- BIG MARQUEE ---------- */
    .big-marquee {
      padding: 64px 0;
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      background: var(--bg);
      overflow: hidden;
    }
    .big-marquee .marquee-item {
      font-size: clamp(40px, 6vw, 88px);
      font-weight: 600;
      color: var(--text);
      gap: 40px;
      padding-right: 40px;
    }
    .big-marquee .marquee-item .sep {
      width: 18px; height: 18px;
    }
    .big-marquee .marquee-item .ghost {
      -webkit-text-stroke: 1px var(--text-dim);
      color: transparent;
    }

    /* ---------- AT A GLANCE ---------- */
    .at-glance {
      padding: 100px 0;
      background: var(--bg-2);
      border-bottom: 1px solid var(--border);
      position: relative;
      overflow: hidden;
    }
    .at-glance .blob { opacity: 0.25; }
    .at-glance .blob.b1 { width: 320px; height: 320px; top: -120px; left: 20%;
      background: radial-gradient(circle, var(--c-pink), transparent 60%); }
    .at-glance .blob.b2 { width: 320px; height: 320px; bottom: -120px; right: 20%;
      background: radial-gradient(circle, var(--c-blue), transparent 60%); }

    .glance-grid {
      position: relative;
      z-index: 2;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }
    .glance-item {
      padding: 36px 32px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      display: flex;
      flex-direction: column;
      gap: 16px;
      position: relative;
      overflow: hidden;
      transition: transform 0.3s ease;
    }
    .glance-item:hover { transform: translateY(-4px); }
    .glance-item .ico-wrap {
      position: absolute;
      top: 32px; right: 32px;
      width: 56px; height: 56px;
      border-radius: 16px;
      display: grid;
      place-items: center;
      background: linear-gradient(135deg, var(--c-pink), var(--c-violet));
      box-shadow: 0 8px 30px rgba(255,94,148,0.35);
      transform: rotate(-6deg);
    }
    .glance-item:nth-child(2) .ico-wrap {
      background: linear-gradient(135deg, var(--c-blue), var(--c-cyan));
      box-shadow: 0 8px 30px rgba(79,168,255,0.35);
    }
    .glance-item:nth-child(3) .ico-wrap {
      background: linear-gradient(135deg, var(--c-yellow), var(--c-orange));
      box-shadow: 0 8px 30px rgba(255,138,76,0.4);
    }
    .glance-item .ico-wrap svg { color: #fff; }
    .glance-num {
      font-family: var(--font-en);
      font-size: clamp(64px, 7vw, 96px);
      font-weight: 500;
      letter-spacing: -0.04em;
      line-height: 1;
      color: var(--text);
    }
    .glance-num .unit {
      color: var(--accent);
      font-weight: 400;
      font-size: 0.4em;
      vertical-align: 0.4em;
      margin-left: 4px;
    }
    .glance-item:nth-child(2) .glance-num .unit { color: var(--c-cyan); }
    .glance-item:nth-child(3) .glance-num .unit { color: var(--c-orange); }
    .glance-label {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text-muted);
    }
    .glance-desc { font-size: 14.5px; color: var(--text-dim); line-height: 1.75; }

    /* ---------- SECTION shell ---------- */
    .section {
      padding: 140px 0;
      position: relative;
    }
    .section-head {
      display: grid;
      grid-template-columns: 1fr 1.6fr;
      gap: 60px;
      margin-bottom: 72px;
      align-items: end;
    }
    .section-head h2 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: clamp(36px, 4.4vw, 64px);
      letter-spacing: -0.03em;
      line-height: 1.15;
    }
    .section-head .lede {
      color: var(--text-dim);
      font-size: 17px;
      line-height: 1.85;
      max-width: 60ch;
    }

    /* ---------- SERVICES (colored) ---------- */
    .svc-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }
    .svc {
      position: relative;
      padding: 36px 32px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      display: flex;
      flex-direction: column;
      gap: 24px;
      transition: all 0.4s ease;
      overflow: hidden;
      min-height: 480px;
    }
    .svc-glow {
      position: absolute;
      inset: 0;
      opacity: 0;
      transition: opacity 0.4s ease;
      pointer-events: none;
      background: radial-gradient(circle at 50% 0%, var(--c1), transparent 60%);
    }
    .svc:hover .svc-glow { opacity: 0.5; }
    .svc:hover { border-color: transparent; transform: translateY(-6px) rotate(-0.5deg); }
    .svc:nth-child(2):hover { transform: translateY(-6px) rotate(0.5deg); }

    .svc-badge {
      position: absolute;
      top: 28px;
      right: 28px;
      width: 56px; height: 56px;
      border-radius: 18px;
      display: grid;
      place-items: center;
      color: #fff;
      box-shadow: 0 10px 30px rgba(0,0,0,0.4);
      transform: rotate(-8deg);
      transition: transform 0.4s ease;
    }
    .svc:hover .svc-badge { transform: rotate(8deg) scale(1.05); }

    .svc.c-pink   .svc-badge { background: linear-gradient(135deg, var(--c-pink),   var(--c-magenta)); }
    .svc.c-blue   .svc-badge { background: linear-gradient(135deg, var(--c-blue),   var(--c-cyan)); }
    .svc.c-orange .svc-badge { background: linear-gradient(135deg, var(--c-yellow), var(--c-orange)); color: #2A1404;}

    .svc.c-pink   { --c1: rgba(255,94,148,0.16); }
    .svc.c-blue   { --c1: rgba(79,168,255,0.16); }
    .svc.c-orange { --c1: rgba(255,138,76,0.16); }

    .svc-num {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.2em;
      color: var(--text-muted);
      z-index: 2;
      position: relative;
    }
    .svc h3 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 28px;
      letter-spacing: -0.01em;
      line-height: 1.3;
      z-index: 2;
      position: relative;
    }
    .svc h3 .en {
      display: block;
      font-family: var(--font-en);
      font-size: 13px;
      font-weight: 500;
      color: var(--text-muted);
      letter-spacing: 0.14em;
      text-transform: uppercase;
      margin-bottom: 10px;
    }
    .svc-desc { color: var(--text-dim); font-size: 14.5px; z-index: 2; position: relative; }
    .svc-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: auto; z-index: 2; position: relative; }
    .svc-foot {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-top: 24px;
      border-top: 1px solid var(--border);
      font-family: var(--font-mono);
      font-size: 12px;
      letter-spacing: 0.08em;
      z-index: 2;
      position: relative;
    }
    .svc.c-pink   .svc-foot { color: var(--c-pink); }
    .svc.c-blue   .svc-foot { color: var(--c-cyan); }
    .svc.c-orange .svc-foot { color: var(--c-orange); }

    /* ---------- MANIFESTO sticky scroll ---------- */
    .manifesto {
      padding: 100px 0;
      background: var(--bg-2);
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      overflow: hidden;
    }
    .manifesto-inner {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 var(--gutter);
    }
    .manifesto-title {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: clamp(36px, 5vw, 72px);
      letter-spacing: -0.025em;
      line-height: 1.35;
      color: var(--text-faint);
      transition: color 0.4s ease;
    }
    .manifesto-title .w {
      transition: color 0.5s ease;
      display: inline-block;
    }
    .manifesto-title .w.in { color: var(--text); }
    .manifesto-title .w.accent.in { color: var(--c-lime); }
    .manifesto-title .w.pink.in   { color: var(--c-pink); }
    .manifesto-title .w.blue.in   { color: var(--c-cyan); }
    .manifesto-title .w.violet.in { color: var(--c-violet); }

    /* ---------- AI DRIVEN ---------- */
    .ai-section {
      padding: 140px 0;
      background:
        radial-gradient(800px 400px at 50% 0%, rgba(156, 109, 255, 0.18), transparent 70%),
        var(--bg);
      overflow: hidden;
      position: relative;
    }
    .ai-section .blob.b1 { width: 360px; height: 360px; top: 10%; right: -100px;
      background: radial-gradient(circle, var(--c-cyan), transparent 60%); opacity: 0.35; }

    .ai-grid {
      display: grid;
      grid-template-columns: 1.05fr 1fr;
      gap: 80px;
      align-items: center;
      position: relative;
    }
    .ai-copy h2 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: clamp(40px, 4.4vw, 64px);
      letter-spacing: -0.03em;
      line-height: 1.15;
    }
    .ai-copy h2 .accent { color: var(--c-lime); }
    .ai-copy .lead {
      margin-top: 28px;
      color: var(--text-dim);
      font-size: 17px;
      line-height: 1.9;
      max-width: 48ch;
    }
    .ai-stack {
      margin-top: 40px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }
    .ai-tool {
      padding: 20px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      display: flex;
      flex-direction: column;
      gap: 6px;
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    .ai-tool:hover { border-color: var(--accent); transform: translateY(-2px); }
    .ai-tool .name { font-family: var(--font-en); font-weight: 600; font-size: 15px; color: var(--text); }
    .ai-tool .tag {
      font-family: var(--font-mono);
      font-size: 10px;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--accent);
    }
    .ai-tool .role { margin-top: 4px; font-size: 13px; color: var(--text-dim); }
    .ai-tool:nth-child(2) .tag { color: var(--c-pink); }
    .ai-tool:nth-child(3) .tag { color: var(--c-blue); }
    .ai-tool:nth-child(4) .tag { color: var(--c-violet); }

    /* Terminal */
    .terminal {
      background: #0A0C0F;
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow:
        0 30px 80px rgba(0,0,0,0.5),
        0 0 0 1px rgba(197, 240, 62, 0.04),
        0 0 100px rgba(156, 109, 255, 0.25);
      position: relative;
      transform: rotate(-1deg);
      transition: transform 0.4s ease;
    }
    .terminal:hover { transform: rotate(0); }
    .terminal-bar {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      gap: 8px;
      border-bottom: 1px solid var(--border);
      background: rgba(255,255,255,0.02);
    }
    .term-dot { width: 11px; height: 11px; border-radius: 50%; }
    .term-dot.r { background: #FF5F57; }
    .term-dot.y { background: #FEBC2E; }
    .term-dot.g { background: #28C840; }
    .term-title { margin-left: 12px; font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); letter-spacing: 0.08em; }
    .term-body {
      padding: 24px 24px 28px;
      font-family: var(--font-mono);
      font-size: 13.5px;
      line-height: 1.85;
      color: var(--text-dim);
      min-height: 360px;
    }
    .term-prompt { color: var(--accent); margin-right: 8px; }
    .term-line { display: block; }
    .term-line.muted { color: var(--text-muted); }
    .term-line.user  { color: var(--text); }
    .term-line.code  { color: #BCE9FF; padding-left: 16px; }
    .term-line.ok    { color: var(--accent); }
    .term-line .num  { color: var(--c-orange); }
    .term-line .pink { color: var(--c-pink); }
    .cursor {
      display: inline-block;
      width: 8px; height: 16px;
      background: var(--accent);
      vertical-align: -3px;
      animation: blink 1s steps(1) infinite;
    }
    @keyframes blink { 50% { opacity: 0; } }

    .ai-outcomes {
      margin-top: 48px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
    }
    .ai-outcome {
      padding: 24px 20px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      transition: all 0.3s ease;
    }
    .ai-outcome:hover { transform: translateY(-3px) rotate(-1deg); }
    .ai-outcome:nth-child(2):hover { transform: translateY(-3px) rotate(1deg); }
    .ai-outcome .v {
      font-family: var(--font-en);
      font-weight: 600;
      font-size: 36px;
      letter-spacing: -0.02em;
    }
    .ai-outcome:nth-child(1) .v { color: var(--c-lime); }
    .ai-outcome:nth-child(2) .v { color: var(--c-pink); }
    .ai-outcome:nth-child(3) .v { color: var(--c-cyan); }
    .ai-outcome .l { margin-top: 6px; font-size: 13px; color: var(--text-dim); }

    /* ---------- 4 PRINCIPLES (with colored stickers) ---------- */
    .principles { padding: 140px 0; position: relative; overflow: hidden; }
    .principles .blob.b1 { width: 360px; height: 360px; top: 30%; left: -150px;
      background: radial-gradient(circle, var(--c-orange), transparent 60%); opacity: 0.2; }

    .pr-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }
    .pr {
      position: relative;
      padding: 40px 36px 36px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      transition: all 0.3s ease;
      overflow: hidden;
    }
    .pr:hover { transform: translateY(-4px); border-color: var(--border-bright); }
    .pr .sticker {
      position: absolute;
      top: 24px; right: 24px;
    }
    .pr-emoji {
      font-family: var(--font-en);
      font-size: 56px;
      font-weight: 600;
      letter-spacing: -0.04em;
      line-height: 1;
      margin-bottom: 24px;
      background: linear-gradient(135deg, var(--c1), var(--c2));
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      display: inline-block;
    }
    .pr:nth-child(1) { --c1: var(--c-lime);  --c2: var(--c-mint); }
    .pr:nth-child(2) { --c1: var(--c-blue);  --c2: var(--c-cyan); }
    .pr:nth-child(3) { --c1: var(--c-pink);  --c2: var(--c-violet); }
    .pr:nth-child(4) { --c1: var(--c-yellow); --c2: var(--c-orange); }

    .pr h3 {
      font-family: var(--font-en);
      font-size: 13px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--text-muted);
      font-weight: 500;
      margin-bottom: 6px;
    }
    .pr .jp {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 28px;
      letter-spacing: -0.01em;
      margin-bottom: 20px;
    }
    .pr p { font-size: 15px; color: var(--text-dim); line-height: 1.85; }

    .pr-flow {
      margin-top: 48px;
      padding: 28px 32px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      display: flex;
      align-items: center;
      gap: 18px;
      flex-wrap: wrap;
      position: relative;
      overflow: hidden;
    }
    .pr-flow-label {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--text-muted);
    }
    .pr-flow-items {
      display: flex; align-items: center; gap: 18px; flex-wrap: wrap; flex: 1;
    }
    .pr-step {
      font-family: var(--font-jp); font-weight: 500; font-size: 15px; color: var(--text);
    }
    .pr-arrow { color: var(--accent); font-family: var(--font-mono); }

    /* ---------- HOW WE WORK ---------- */
    .how {
      padding: 140px 0;
      background: var(--bg-2);
      position: relative;
      overflow: hidden;
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
    }
    .steps {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 0;
      position: relative;
    }
    .step {
      padding: 32px 24px 32px 0;
      border-top: 2px solid var(--c1);
      position: relative;
    }
    .step:nth-child(1) { --c1: var(--c-lime); }
    .step:nth-child(2) { --c1: var(--c-mint); }
    .step:nth-child(3) { --c1: var(--c-blue); }
    .step:nth-child(4) { --c1: var(--c-violet); }
    .step:nth-child(5) { --c1: var(--c-pink); }
    .step::before {
      content: '';
      position: absolute;
      top: -8px; left: 0;
      width: 14px; height: 14px;
      background: var(--c1);
      border-radius: 50%;
      box-shadow: 0 0 0 4px var(--bg-2), 0 0 0 5px var(--c1);
    }
    .step-no {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      color: var(--c1);
      margin-bottom: 16px;
    }
    .step h4 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 18px;
      letter-spacing: -0.005em;
      margin-bottom: 10px;
    }
    .step p { font-size: 13.5px; color: var(--text-dim); line-height: 1.7; }

    .how-note {
      margin-top: 56px;
      padding: 24px 28px;
      border-radius: var(--radius);
      display: flex;
      align-items: center;
      gap: 18px;
      background:
        linear-gradient(120deg, rgba(197,240,62,0.08), rgba(79,168,255,0.06));
      border: 1px solid rgba(197,240,62,0.2);
    }
    .how-note .badge {
      font-family: var(--font-mono);
      font-size: 10px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--accent-ink);
      background: var(--accent);
      padding: 5px 9px;
      border-radius: 4px;
      font-weight: 600;
      transform: rotate(-3deg);
    }
    .how-note p { font-size: 15px; color: var(--text); }

    /* ---------- WORKS PREVIEW ---------- */
    .works-preview {
      padding: 140px 0 100px;
      position: relative;
      overflow: hidden;
    }
    .works-list { display: flex; flex-direction: column; }
    .work-row {
      display: grid;
      grid-template-columns: 60px 1.5fr 1fr 0.8fr 60px;
      gap: 24px;
      padding: 28px 0;
      border-bottom: 1px solid var(--border);
      align-items: center;
      transition: padding 0.3s ease;
      cursor: pointer;
      position: relative;
    }
    .work-row:first-child { border-top: 1px solid var(--border); }
    .work-row:hover { padding-left: 16px; }
    .work-row:hover .work-arrow { color: var(--accent); transform: translateX(4px); }
    .work-row:hover .work-bullet { transform: scale(1.4); }
    .work-no {
      font-family: var(--font-mono);
      font-size: 12px;
      color: var(--text-muted);
      letter-spacing: 0.1em;
      display: flex; align-items: center; gap: 12px;
    }
    .work-bullet {
      display: inline-block;
      width: 8px; height: 8px; border-radius: 50%;
      background: var(--c1, var(--accent));
      transition: transform 0.3s ease;
    }
    .work-row:nth-child(1) { --c1: var(--c-pink); }
    .work-row:nth-child(2) { --c1: var(--c-blue); }
    .work-row:nth-child(3) { --c1: var(--c-orange); }
    .work-row:nth-child(4) { --c1: var(--c-violet); }
    .work-row:nth-child(5) { --c1: var(--c-mint); }
    .work-title {
      font-family: var(--font-jp); font-weight: 600; font-size: 19px; letter-spacing: -0.005em;
    }
    .work-meta { font-family: var(--font-mono); font-size: 12px; color: var(--text-dim); letter-spacing: 0.06em; }
    .work-year { font-family: var(--font-mono); font-size: 13px; color: var(--text-dim); }
    .work-arrow { color: var(--text-muted); transition: all 0.3s ease; text-align: right; }

    /* ---------- WHY ---------- */
    .why { padding: 140px 0; background: var(--bg-2); border-top: 1px solid var(--border); position: relative; overflow: hidden; }
    .why-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }
    .why-card {
      padding: 36px 32px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      display: flex;
      flex-direction: column;
      gap: 20px;
      min-height: 320px;
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
    }
    .why-card::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--c1), transparent 50%);
      opacity: 0;
      transition: opacity 0.4s ease;
      pointer-events: none;
    }
    .why-card:hover { transform: translateY(-6px); }
    .why-card:hover::before { opacity: 0.18; }
    .why-card:nth-child(1) { --c1: var(--c-pink); }
    .why-card:nth-child(2) { --c1: var(--c-blue); }
    .why-card:nth-child(3) { --c1: var(--c-lime); }
    .why-card .ico {
      width: 56px; height: 56px;
      border-radius: 18px;
      display: grid; place-items: center;
      background: linear-gradient(135deg, var(--c1), var(--c2));
      color: #fff;
      box-shadow: 0 10px 30px rgba(0,0,0,0.4);
      transform: rotate(-6deg);
      transition: transform 0.4s ease;
      position: relative; z-index: 2;
    }
    .why-card:hover .ico { transform: rotate(6deg) scale(1.05); }
    .why-card:nth-child(1) { --c2: var(--c-violet); }
    .why-card:nth-child(2) { --c2: var(--c-cyan); }
    .why-card:nth-child(3) { --c2: var(--c-mint); }
    .why-card h3 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 22px;
      letter-spacing: -0.01em;
      line-height: 1.4;
      position: relative; z-index: 2;
    }
    .why-card p { font-size: 14.5px; color: var(--text-dim); line-height: 1.85; position: relative; z-index: 2; }

    /* ---------- FINAL CTA (Tech edition) ---------- */
    .cta {
      padding: 160px 0 140px;
      position: relative;
      overflow: hidden;
      text-align: center;
      background: var(--bg);
    }
    .cta-bg { position: absolute; inset: 0; pointer-events: none; z-index: 0; }
    .cta-bg .tech-grid {
      position: absolute; inset: 0;
      background-image:
        linear-gradient(to right, rgba(25,27,26,0.04) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(25,27,26,0.04) 1px, transparent 1px);
      background-size: 64px 64px;
      mask-image: radial-gradient(ellipse 90% 70% at 50% 50%, #000 30%, transparent 88%);
      -webkit-mask-image: radial-gradient(ellipse 90% 70% at 50% 50%, #000 30%, transparent 88%);
    }
    .cta-bg .tech-dots {
      position: absolute; inset: 0;
      background-image: radial-gradient(circle, rgba(25,27,26,0.14) 1px, transparent 1.4px);
      background-size: 64px 64px;
      background-position: 32px 32px;
      mask-image: radial-gradient(ellipse 65% 55% at 50% 50%, #000 20%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse 65% 55% at 50% 50%, #000 20%, transparent 80%);
      opacity: 0.6;
    }
    /* Concentric ring guides */
    .cta-bg .rings {
      position: absolute;
      top: 50%; left: 50%;
      width: 900px; height: 900px;
      transform: translate(-50%, -50%);
      pointer-events: none;
    }
    .cta-bg .rings span {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      border: 1px dashed var(--border-2);
      opacity: 0.45;
      animation: ring-spin 60s linear infinite;
    }
    .cta-bg .rings span:nth-child(2) { transform: scale(0.7); animation-duration: 80s; animation-direction: reverse; }
    .cta-bg .rings span:nth-child(3) { transform: scale(0.45); animation-duration: 100s; opacity: 0.6; border-style: solid; border-color: var(--border); }
    @keyframes ring-spin {
      to { transform: rotate(360deg); }
    }
    .cta-bg .rings span:nth-child(2) { animation-name: ring-spin-r; }
    .cta-bg .rings span:nth-child(3) { animation-name: ring-spin-r3; }
    @keyframes ring-spin-r {
      from { transform: scale(0.7) rotate(0); }
      to   { transform: scale(0.7) rotate(-360deg); }
    }
    @keyframes ring-spin-r3 {
      from { transform: scale(0.45) rotate(0); }
      to   { transform: scale(0.45) rotate(360deg); }
    }

    .cta-inner { position: relative; z-index: 2; }
    /* 3D mini stage (Three.js) — replaces the spin badge */
    .cta-stage3d {
      width: 200px; height: 200px;
      margin: 0 auto 28px;
      position: relative;
      display: grid;
      place-items: center;
    }
    .cta-stage3d canvas {
      display: block;
      width: 100% !important;
      height: 100% !important;
    }
    .cta-stage3d::before, .cta-stage3d::after {
      content: '';
      position: absolute;
      top: 50%; left: 50%;
      width: 240px; height: 240px;
      transform: translate(-50%, -50%);
      border: 1px dashed var(--border-2);
      border-radius: 50%;
      animation: ring-spin 30s linear infinite;
      pointer-events: none;
    }
    .cta-stage3d::after {
      width: 290px; height: 290px;
      border-style: solid;
      border-color: var(--border);
      animation-duration: 50s;
      animation-direction: reverse;
    }

    .cta h2 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: clamp(48px, 7vw, 104px);
      letter-spacing: -0.035em;
      line-height: 1.05;
      max-width: 18ch;
      margin: 0 auto;
    }
    .cta h2 .accent { color: var(--c-lime); font-style: italic; font-family: var(--font-en); font-weight: 500; }
    .cta .lead {
      margin: 32px auto 0; max-width: 50ch; color: var(--text-dim); font-size: 17px; line-height: 1.85;
    }
    .cta-btns {
      margin-top: 48px;
      display: inline-flex; gap: 14px; flex-wrap: wrap; justify-content: center;
    }
    .cta-foot {
      margin-top: 56px;
      display: flex; justify-content: center; gap: 40px;
      font-family: var(--font-mono); font-size: 12px; color: var(--text-muted); letter-spacing: 0.14em;
    }
    .cta-foot span { display: inline-flex; align-items: center; gap: 8px; }
    .cta-foot .dot {
      width: 6px; height: 6px; border-radius: 50%; background: var(--c-lime);
    }
    .cta-foot span:nth-child(2) .dot { background: var(--c-pink); }
    .cta-foot span:nth-child(3) .dot { background: var(--c-blue); }

    /* =========================================
       Section entry animations (triggered by .vis)
       ========================================= */

    /* AT A GLANCE — icons pop in with rotation, staggered */
    .at-glance .ico-wrap {
      transform: rotate(-90deg) scale(0.3);
      transition: transform 0.85s cubic-bezier(0.2, 1.7, 0.3, 1);
    }
    .at-glance.vis .glance-item:nth-child(1) .ico-wrap { transform: rotate(-6deg)  scale(1); transition-delay: 0.10s; }
    .at-glance.vis .glance-item:nth-child(2) .ico-wrap { transform: rotate(-6deg)  scale(1); transition-delay: 0.20s; }
    .at-glance.vis .glance-item:nth-child(3) .ico-wrap { transform: rotate(-6deg)  scale(1); transition-delay: 0.30s; }

    /* SERVICES — badges spin in */
    .section .svc-badge {
      transform: rotate(-180deg) scale(0.3);
      transition: transform 0.9s cubic-bezier(0.2, 1.6, 0.3, 1);
    }
    .section.vis .svc:nth-child(1) .svc-badge { transform: rotate(-8deg) scale(1); transition-delay: 0.15s; }
    .section.vis .svc:nth-child(2) .svc-badge { transform: rotate(-8deg) scale(1); transition-delay: 0.30s; }
    .section.vis .svc:nth-child(3) .svc-badge { transform: rotate(-8deg) scale(1); transition-delay: 0.45s; }
    /* Tag chips slide in horizontally */
    .section .svc-tags .chip {
      transform: translateX(-12px);
      transition: transform 0.5s cubic-bezier(0.2, 0.7, 0.2, 1);
    }
    .section.vis .svc-tags .chip { transform: translateX(0); }

    /* AI section — terminal lines slide up sequentially with clip-path */
    .ai-section .term-line {
      clip-path: inset(0 100% 0 0);
      transition: clip-path 0.5s cubic-bezier(0.2, 0.7, 0.2, 1);
    }
    .ai-section.vis .term-line { clip-path: inset(0 0 0 0); }
    .ai-section.vis .term-line:nth-child(1)  { transition-delay: 0.20s; }
    .ai-section.vis .term-line:nth-child(2)  { transition-delay: 0.55s; }
    .ai-section.vis .term-line:nth-child(3)  { transition-delay: 0.85s; }
    .ai-section.vis .term-line:nth-child(4)  { transition-delay: 1.05s; }
    .ai-section.vis .term-line:nth-child(5)  { transition-delay: 1.20s; }
    .ai-section.vis .term-line:nth-child(6)  { transition-delay: 1.30s; }
    .ai-section.vis .term-line:nth-child(7)  { transition-delay: 1.55s; }
    .ai-section.vis .term-line:nth-child(8)  { transition-delay: 1.85s; }
    .ai-section.vis .term-line:nth-child(9)  { transition-delay: 2.00s; }
    .ai-section.vis .term-line:nth-child(10) { transition-delay: 2.15s; }
    .ai-section.vis .term-line:nth-child(11) { transition-delay: 2.35s; }
    .ai-section.vis .term-line:nth-child(12) { transition-delay: 2.60s; }
    .ai-section.vis .term-line:nth-child(13) { transition-delay: 2.75s; }
    .ai-section.vis .term-line:nth-child(14) { transition-delay: 2.90s; }
    .ai-section.vis .term-line:nth-child(15) { transition-delay: 3.05s; }
    /* AI tool cards bounce in */
    .ai-section .ai-tool {
      transform: translateY(20px) scale(0.95);
      transition: transform 0.6s cubic-bezier(0.2, 1.5, 0.3, 1);
    }
    .ai-section.vis .ai-tool { transform: translateY(0) scale(1); }
    .ai-section.vis .ai-tool:nth-child(1) { transition-delay: 0.10s; }
    .ai-section.vis .ai-tool:nth-child(2) { transition-delay: 0.20s; }
    .ai-section.vis .ai-tool:nth-child(3) { transition-delay: 0.30s; }
    .ai-section.vis .ai-tool:nth-child(4) { transition-delay: 0.40s; }
    /* Outcome metric pop in */
    .ai-section .ai-outcome .v {
      transform: scale(0.4);
      display: inline-block;
      transition: transform 0.7s cubic-bezier(0.2, 1.8, 0.3, 1);
    }
    .ai-section.vis .ai-outcome .v { transform: scale(1); }
    .ai-section.vis .ai-outcome:nth-child(1) .v { transition-delay: 0.45s; }
    .ai-section.vis .ai-outcome:nth-child(2) .v { transition-delay: 0.55s; }
    .ai-section.vis .ai-outcome:nth-child(3) .v { transition-delay: 0.65s; }

    /* PRINCIPLES — emoji initials draw up; stickers pop and tilt */
    .principles .pr-emoji {
      transform: translateY(40px) rotate(-8deg);
      transition: transform 0.9s cubic-bezier(0.2, 1.4, 0.3, 1);
    }
    .principles.vis .pr-emoji { transform: translateY(0) rotate(0); }
    .principles.vis .pr:nth-child(1) .pr-emoji { transition-delay: 0.10s; }
    .principles.vis .pr:nth-child(2) .pr-emoji { transition-delay: 0.20s; }
    .principles.vis .pr:nth-child(3) .pr-emoji { transition-delay: 0.30s; }
    .principles.vis .pr:nth-child(4) .pr-emoji { transition-delay: 0.40s; }

    .principles .pr .sticker {
      transform: rotate(0) scale(0);
      transition: transform 0.6s cubic-bezier(0.2, 1.8, 0.3, 1);
    }
    .principles.vis .pr:nth-child(1) .sticker { transform: rotate(-6deg) scale(1); transition-delay: 0.30s; }
    .principles.vis .pr:nth-child(2) .sticker { transform: rotate(5deg)  scale(1); transition-delay: 0.40s; }
    .principles.vis .pr:nth-child(3) .sticker { transform: rotate(-8deg) scale(1); transition-delay: 0.50s; }
    .principles.vis .pr:nth-child(4) .sticker { transform: rotate(6deg)  scale(1); transition-delay: 0.60s; }

    /* HOW WE WORK — timeline draws */
    .how .step {
      position: relative;
    }
    .how .step::after {
      content: '';
      position: absolute;
      top: -2px; left: 0;
      width: 100%; height: 2px;
      background: var(--c1);
      transform-origin: left;
      transform: scaleX(0);
      transition: transform 0.7s cubic-bezier(0.2, 0.7, 0.2, 1);
    }
    .how.vis .step::after { transform: scaleX(1); }
    .how.vis .step:nth-child(1)::after { transition-delay: 0.10s; }
    .how.vis .step:nth-child(2)::after { transition-delay: 0.35s; }
    .how.vis .step:nth-child(3)::after { transition-delay: 0.60s; }
    .how.vis .step:nth-child(4)::after { transition-delay: 0.85s; }
    .how.vis .step:nth-child(5)::after { transition-delay: 1.10s; }
    .how .step { border-top: 0 !important; }  /* let ::after draw the line */

    /* Step dot pop */
    .how .step::before {
      transform: scale(0);
      transition: transform 0.5s cubic-bezier(0.2, 1.8, 0.3, 1);
    }
    .how.vis .step::before { transform: scale(1); }
    .how.vis .step:nth-child(1)::before { transition-delay: 0.05s; }
    .how.vis .step:nth-child(2)::before { transition-delay: 0.30s; }
    .how.vis .step:nth-child(3)::before { transition-delay: 0.55s; }
    .how.vis .step:nth-child(4)::before { transition-delay: 0.80s; }
    .how.vis .step:nth-child(5)::before { transition-delay: 1.05s; }

    /* WORKS — bullets pulse on entry */
    .works-preview .work-bullet {
      transform: scale(0);
      transition: transform 0.55s cubic-bezier(0.2, 1.8, 0.3, 1);
    }
    .works-preview.vis .work-bullet { transform: scale(1); }
    .works-preview.vis .work-row:nth-child(1) .work-bullet { transition-delay: 0.05s; }
    .works-preview.vis .work-row:nth-child(2) .work-bullet { transition-delay: 0.15s; }
    .works-preview.vis .work-row:nth-child(3) .work-bullet { transition-delay: 0.25s; }
    .works-preview.vis .work-row:nth-child(4) .work-bullet { transition-delay: 0.35s; }
    .works-preview.vis .work-row:nth-child(5) .work-bullet { transition-delay: 0.45s; }

    /* WHY — icons rotate-bounce in */
    .why .why-card .ico {
      transform: rotate(-180deg) scale(0.4);
      transition: transform 0.85s cubic-bezier(0.2, 1.6, 0.3, 1);
    }
    .why.vis .why-card:nth-child(1) .ico { transform: rotate(-6deg) scale(1); transition-delay: 0.10s; }
    .why.vis .why-card:nth-child(2) .ico { transform: rotate(-6deg) scale(1); transition-delay: 0.22s; }
    .why.vis .why-card:nth-child(3) .ico { transform: rotate(-6deg) scale(1); transition-delay: 0.34s; }

    /* CTA — final pulse, big text reveal via clip */
    .cta h2 {
      clip-path: inset(0 0 100% 0);
      transition: clip-path 1s cubic-bezier(0.2, 0.7, 0.2, 1);
    }
    .cta.vis h2 { clip-path: inset(0 0 0 0); transition-delay: 0.15s; }

    @media (max-width: 1080px) {
      .section-head { grid-template-columns: 1fr; gap: 24px; margin-bottom: 56px; }
      .svc-grid, .why-grid { grid-template-columns: 1fr 1fr; }
      .pr-grid { grid-template-columns: 1fr 1fr; }
      .glance-grid { grid-template-columns: 1fr; }
      .ai-grid { grid-template-columns: 1fr; gap: 56px; }
      .steps { grid-template-columns: 1fr 1fr; gap: 28px; }
      /* Hero: shrink 3D, allow text more room */
      .hero-stage3d { width: clamp(360px, 50vw, 580px); height: clamp(360px, 50vw, 580px); right: -8%; }
      .hero h1 { font-size: clamp(40px, 7vw, 76px); }
      .hero-headline { grid-column: 1 / span 7; }
    }
    @media (max-width: 820px) {
      /* Hero: 3D becomes full-bleed background, content overlays */
      .hero {
        padding: calc(var(--nav-h) + 48px) 0 72px;
        min-height: 90vh;
        overflow: hidden;
        position: relative;
      }
      .hero-inner {
        display: flex;
        flex-direction: column;
        gap: 22px;
        min-height: 0;
        position: relative;
        z-index: 3;
      }
      .hero-inner > * { position: relative; z-index: 3; }
      .hero-top-l, .hero-top-r {
        position: relative;
        grid-column: auto; grid-row: auto;
        justify-self: auto;
      }
      .hero-top-r { background: transparent; padding: 0; align-self: flex-start; }
      .hero h1 { font-size: clamp(40px, 10vw, 68px); max-width: none; }
      .hero-headline { grid-column: auto; align-self: auto; }

      /* 3D as background — big, slightly oversized, low opacity */
      .hero-stage3d {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -45%);
        width: 130vw;
        height: 130vw;
        max-width: none;
        max-height: 100%;
        aspect-ratio: auto;
        margin: 0;
        z-index: 1;
        opacity: 0.55;
        pointer-events: none;
      }
      .hero-stage3d canvas {
        width: 100% !important;
        height: 100% !important;
      }
      .stage-status, .stage-label { display: none; }

      /* Cream scrim for text readability — anchored to left where text sits */
      .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
          radial-gradient(ellipse 70% 50% at 25% 40%,
            color-mix(in oklab, var(--bg) 88%, transparent) 0%,
            color-mix(in oklab, var(--bg) 0%, transparent) 65%),
          linear-gradient(to bottom,
            color-mix(in oklab, var(--bg) 30%, transparent) 0%,
            transparent 25%,
            transparent 75%,
            color-mix(in oklab, var(--bg) 50%, transparent) 100%);
        z-index: 2;
        pointer-events: none;
      }

      .hero-bottom-l, .hero-bottom-r {
        grid-column: auto; grid-row: auto;
        max-width: none;
        width: 100%;
      }
      .hero-bottom-r {
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: 12px;
      }
      .hero-foot-cue { display: none; }
      .hero-readout {
        grid-template-columns: repeat(2, 1fr);
        gap: 14px 18px;
        padding-top: 16px;
      }
      .hero-numeral { display: none; }
      .hero-corner { width: 14px; height: 14px; }
      .hero-corner.tl, .hero-corner.tr { top: calc(var(--nav-h) + 14px); }
      .hero-corner.bl, .hero-corner.br { bottom: 24px; }
      .section-stamp { font-size: clamp(80px, 18vw, 200px); }
    }
    @media (max-width: 720px) {
      .svc-grid, .why-grid, .pr-grid { grid-template-columns: 1fr; }
      .steps { grid-template-columns: 1fr; }
      .work-row { grid-template-columns: 1fr 32px; gap: 12px; padding: 22px 0; }
      .work-row .work-no { display: none; }
      .work-row .work-meta, .work-row .work-year { display: none; }
      .work-title {
        font-size: 16px;
        line-height: 1.5;
        word-break: keep-all;
        overflow-wrap: anywhere;
        text-wrap: balance;
      }
      .ai-stack, .ai-outcomes { grid-template-columns: 1fr; }
      /* pr-flow: stack vertically on mobile */
      .pr-flow {
        flex-direction: column;
        align-items: flex-start;
        padding: 22px 20px;
        gap: 14px;
      }
      .pr-flow-items {
        width: 100%;
        flex: 0 1 auto;
        gap: 12px;
        row-gap: 10px;
      }
      .pr-step { font-size: 14px; }
      .pr-arrow { font-size: 13px; }
      /* Hero further tweaks for small phones */
      .hero h1 { font-size: clamp(34px, 10vw, 50px); }
      .hero-tag-jp { font-size: 14px; }
      .hero-sub { font-size: 14px; line-height: 1.75; }
      .hero-readout .v { font-size: 14px; }
      .hero-readout .k { font-size: 9px; }
      .hero-foot-cue { display: none; }
      /* Section padding compression */
      .section, .ai-section, .principles, .how, .works-preview, .why, .cta, .at-glance {
        padding: 80px 0;
      }
      .section-head h2 { font-size: clamp(28px, 6.5vw, 40px); }
      .ai-copy h2, .ai-section h2 { font-size: clamp(28px, 6.5vw, 40px); }
      .cta h2 { font-size: clamp(36px, 8.5vw, 56px); }
      .cta .lead { font-size: 15px; }
      .glance-num { font-size: clamp(48px, 12vw, 72px); }
      .at-glance .glance-item { padding: 28px 24px; }
      .at-glance .glance-item .ico-wrap { width: 44px; height: 44px; top: 24px; right: 24px; border-radius: 12px; }
      .at-glance .glance-item .ico-wrap svg { width: 18px; height: 18px; }
      .svc { padding: 28px 24px; min-height: 0; }
      .svc h3 { font-size: 22px; }
      .svc-badge { width: 44px; height: 44px; top: 22px; right: 22px; border-radius: 14px; }
      .svc-badge svg { width: 20px; height: 20px; }
      .pr { padding: 32px 28px 28px; }
      .pr-emoji { font-size: 44px; margin-bottom: 18px; }
      .pr .jp { font-size: 22px; }
      .why-card { min-height: 0; padding: 28px 24px; }
      .terminal { transform: none; }
      .terminal .term-body { padding: 20px 18px; font-size: 12px; }
      .ai-outcomes .v { font-size: 28px; }
      .ai-tool { padding: 18px; }
      .manifesto-title { font-size: clamp(28px, 7vw, 44px); }
      /* Marquee text smaller */
      .big-marquee { padding: 40px 0; }
      .big-marquee .marquee-item { font-size: clamp(32px, 8vw, 56px); gap: 24px; padding-right: 24px; }
    }
  </style>
@endpush

@section("content")
  <section class="hero">
    <div class="hero-bg" aria-hidden="true">
      <div class="tech-grid"></div>
      <div class="tech-dots"></div>
      <div class="scan"></div>
    </div>

    <span class="hero-corner tl" aria-hidden="true"></span>
    <span class="hero-corner tr" aria-hidden="true"></span>
    <span class="hero-corner bl" aria-hidden="true"></span>
    <span class="hero-corner br" aria-hidden="true"></span>

    <div class="container hero-inner">

      <span class="hero-numeral" aria-hidden="true" data-parallax="0.18" data-parallax-x="0.06">2026</span>

      <div class="hero-top-l">
        <strong>LIBERASPACE&trade;</strong>
        <span class="rule"></span>
        <span>2026 / Service Deck</span>
      </div>
      <div class="hero-top-r">
        <span class="live"></span>
        <span>Now Accepting — Q3 2026</span>
      </div>

      <div class="hero-headline">
        <h1>
          @foreach(preg_split('/\r?\n/', $page->hero_title ?? '') as $i => $row)
            <span class="row">{!! \App\Support\HeroFormatter::renderHeadlineRow($row) !!}</span>
          @endforeach
        </h1>
        @if($page->hero_jp_tagline)
          <p class="hero-tag-jp">{{ $page->hero_jp_tagline }}</p>
        @endif
      </div>

      <div class="hero-bottom-l">
        <p class="hero-sub">{!! \App\Support\HeroFormatter::renderSub($page->hero_sub) !!}</p>
      </div>

      <div class="hero-bottom-r">
        <div class="hero-cta">
          @if($page->cta_label)
            <a href="{{ $page->cta_url ?? '#' }}" class="btn btn-primary magnet">
              {{ $page->cta_label }} <span class="arrow">→</span>
            </a>
          @endif
          @if($page->secondary_cta_label)
            <a href="{{ $page->secondary_cta_url ?? '#' }}" class="btn btn-ghost magnet">
              {{ $page->secondary_cta_label }} <span class="arrow">→</span>
            </a>
          @endif
        </div>
        <div class="hero-foot-cue">
          <span class="scroll-line"></span>
          SCROLL — NEXT
        </div>
      </div>

      <!-- Data readout strip -->
      <div class="hero-readout" aria-hidden="true">
        @foreach($page->hero_meta ?? [] as $cell)
          <div class="cell">
            <span class="k">{{ $cell['label'] ?? '' }}</span>
            <span class="v">{{ $cell['value'] ?? '' }}</span>
          </div>
        @endforeach
        @if(empty($page->hero_meta))
        <div class="cell">
          <span class="k">// STATUS</span>
          <span class="v">ACCEPTING <span class="unit">— Q3</span></span>
        </div>
        @endif
      </div>

      <!-- 3D wireframe stage — Three.js -->
      <div class="hero-stage3d" aria-hidden="true" data-parallax="0.18" data-parallax-x="0.04">
        <span class="stage-status">SYS // RENDERING</span>
        <canvas id="hero3d"></canvas>
        <span class="stage-label top-r">
          <span class="swatch accent"></span>NODE.A · ICO-32
        </span>
        <span class="stage-label mid-l">
          <span class="line"></span>R = 1.40
        </span>
        <span class="stage-label bot-r">
          <span class="swatch ring"></span>ORBIT // 80 PT
        </span>
      </div>

    </div>
  </section>

  <!-- AT A GLANCE -->
  <section class="at-glance">
    <div class="section-stamp solid" data-parallax-x="-0.30" aria-hidden="true">AT A GLANCE</div>
    <div class="blob b1" aria-hidden="true" data-parallax="0.22"></div>
    <div class="blob b2" aria-hidden="true" data-parallax="-0.18"></div>
    <div class="container">
      <div class="glance-grid">
        <div class="glance-item">
          <div class="ico-wrap">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
          </div>
          <span class="glance-label">01 / Coverage</span>
          <span class="glance-num"><span data-count="3">0</span><span class="unit">領域</span></span>
          <span class="glance-desc">HP制作 / Webシステム開発 / 業務効率化。事業を伸ばす3つの領域を一貫提供。</span>
        </div>
        <div class="glance-item" data-delay="1">
          <div class="ico-wrap">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
          </div>
          <span class="glance-label">02 / Ownership</span>
          <span class="glance-num">1<span class="unit">人称</span></span>
          <span class="glance-desc">企画・設計・実装・分析・運用。分業せず、一人称で責任を持って完走します。</span>
        </div>
        <div class="glance-item" data-delay="2">
          <div class="ico-wrap">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M13 2L4 14h7l-1 8 9-12h-7z"/></svg>
          </div>
          <span class="glance-label">03 / Velocity</span>
          <span class="glance-num">AI<span class="unit">駆動</span></span>
          <span class="glance-desc">AIをチームメンバーのように使いこなし、高品質と短納期を両立します。</span>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES -->
  <section class="section" id="services">
    <div class="section-stamp top" data-parallax-x="-0.35" aria-hidden="true">SERVICES — SERVICES — SERVICES</div>
    <div class="container">
      <div class="section-head">
        <div>
          <div class="eyebrow" style="margin-bottom: 20px;">
            <span class="dot"></span> 02 — Services
          </div>
          <h2>事業を伸ばす、<br><span class="hi pink">3つのサービス領域。</span></h2>
        </div>
        <p class="lede">
          単発のHP制作で終わらせず、サイトに「稼ぐ力」を組み込み、バックオフィスまで仕組み化する。
          つくる・集める・回すを、同じ人間が一気通貫で担当します。
        </p>
      </div>

      <div class="svc-grid">
        <article class="svc c-pink" data-delay="1" data-hover>
          <div class="svc-glow"></div>
          <div class="svc-badge">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          </div>
          <span class="svc-num">01 — WEB &amp; SEO</span>
          <h3>
            <span class="en">HP制作・リニューアル</span>
            成果につながる<br>サイトを構築する。
          </h3>
          <p class="svc-desc">
            デザインを整えるだけでなく、ビジネスの成果（コンバージョン）から逆算したサイトを設計。
            WordPress完全オリジナルテーマで、ブランドを表現し検索でも勝てる構造に。
          </p>
          <div class="svc-tags">
            <span class="chip">WordPress</span>
            <span class="chip">SEO / SGO</span>
            <span class="chip">GA4</span>
            <span class="chip">Search Console</span>
          </div>
          <div class="svc-foot">
            <span>→ 成果につながるサイト</span>
            <span>01</span>
          </div>
        </article>

        <article class="svc c-blue" data-delay="2" data-hover>
          <div class="svc-glow"></div>
          <div class="svc-badge">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
          </div>
          <span class="svc-num">02 — DEVELOPMENT</span>
          <h3>
            <span class="en">Webシステム開発</span>
            HPに「稼ぐ力」を<br>組み込む。
          </h3>
          <p class="svc-desc">
            ECサイト・マッチングアプリ・独自Webサービス。複雑なロジックを必要とする
            プラットフォームを、AI駆動の開発体制でスピーディに構築します。
          </p>
          <div class="svc-tags">
            <span class="chip">Stripe</span>
            <span class="chip">Laravel</span>
            <span class="chip">AWS</span>
            <span class="chip">AI Native</span>
          </div>
          <div class="svc-foot">
            <span>→ 収益化と機能拡張</span>
            <span>02</span>
          </div>
        </article>

        <article class="svc c-orange" data-delay="3" data-hover>
          <div class="svc-glow"></div>
          <div class="svc-badge">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          </div>
          <span class="svc-num">03 — OPERATIONS</span>
          <h3>
            <span class="en">業務効率化システム</span>
            利益率を、<br>仕組みで底上げ。
          </h3>
          <p class="svc-desc">
            自動見積システム・管理画面・DX推進。手作業で行っていた業務を仕組み化し、
            ヒューマンエラー削減と時間創出で、売上はそのまま利益を残します。
          </p>
          <div class="svc-tags">
            <span class="chip">自動見積</span>
            <span class="chip">管理システム</span>
            <span class="chip">DX</span>
            <span class="chip">自動化</span>
          </div>
          <div class="svc-foot">
            <span>→ 利益率の向上</span>
            <span>03</span>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- MANIFESTO -->
  <section class="manifesto" id="manifesto">
    <div class="manifesto-inner">
      <p class="manifesto-title" data-parallax-x="-0.08">
        <span class="w">技術より、</span>
        <span class="w">先に。</span>
        <span class="w accent">姿勢</span>
        <span class="w">と</span>
        <span class="w pink">思考</span>
        <span class="w">を、</span>
        <span class="w">同じ頭で持つこと。</span>
        <span class="w">事業を</span>
        <span class="w blue">前に進める</span>
        <span class="w">ために、</span>
        <span class="w violet">誠実</span>
        <span class="w">と</span>
        <span class="w accent">論理</span>
        <span class="w">を、</span>
        <span class="w">いつも土台に置いています。</span>
      </p>
    </div>
  </section>

  <!-- AI DRIVEN -->
  <section class="ai-section" id="ai">
    <div class="section-stamp solid bottom" data-parallax-x="0.40" aria-hidden="true">AI · NATIVE · AI · NATIVE</div>
    <div class="blob b1" aria-hidden="true" data-parallax="0.20"></div>
    <div class="container">
      <div class="ai-grid">
        <div class="ai-copy">
          <div class="eyebrow" style="margin-bottom: 24px;">
            <span class="dot"></span> 04 — AI Development
          </div>
          <h2 class="" data-delay="1">
            AIを<span class="accent">使う</span>、<br>ではなく<br>
            AIで<span class="accent">設計する</span>。
          </h2>
          <p class="lead" data-delay="2">
            コーディング、設計レビュー、ドキュメント生成、UI設計まで、AIを開発プロセスに組み込み済み。
            高品質なコードを、これまでより短い納期で提供します。
          </p>

          <div class="ai-stack" data-delay="3">
            <div class="ai-tool" data-hover>
              <span class="tag">Design</span>
              <span class="name">Claude Design</span>
              <span class="role">UI / 提案資料の高速化</span>
            </div>
            <div class="ai-tool" data-hover>
              <span class="tag">Code</span>
              <span class="name">Claude Code</span>
              <span class="role">大規模リファクタ / 設計</span>
            </div>
            <div class="ai-tool" data-hover>
              <span class="tag">Editor</span>
              <span class="name">Cursor</span>
              <span class="role">日常開発の生産性 ×N</span>
            </div>
            <div class="ai-tool" data-hover>
              <span class="tag">Research</span>
              <span class="name">Gemini ほか</span>
              <span class="role">調査 / 仕様書整形</span>
            </div>
          </div>

          <div class="ai-outcomes" data-delay="4">
            <div class="ai-outcome">
              <div class="v">×2</div>
              <div class="l">進行スピード</div>
            </div>
            <div class="ai-outcome">
              <div class="v">×N</div>
              <div class="l">レビュー複線化</div>
            </div>
            <div class="ai-outcome">
              <div class="v">柔軟</div>
              <div class="l">仕様変更追従</div>
            </div>
          </div>
        </div>

        <div class="ai-visual" data-parallax="0.08">
          <div class="terminal" id="terminal">
            <div class="terminal-bar">
              <span class="term-dot r"></span>
              <span class="term-dot y"></span>
              <span class="term-dot g"></span>
              <span class="term-title">~/liberaspace/project — claude-code</span>
            </div>
            <div class="term-body" id="termBody">
              <span class="term-line muted"># 事業ヒアリングから受け取った要件を投入</span>
              <span class="term-line"><span class="term-prompt">$</span> <span class="user">claude analyze --goal"CVR向上" --site current.url</span></span>
              <span class="term-line muted">  → 構造分析中... GA4データを取得...</span>
              <span class="term-line code">  ✓ 28ページのSEO診断完了</span>
              <span class="term-line code">  ✓ コンバージョン経路 <span class="pink">7パターン</span> 抽出</span>
              <span class="term-line"></span>
              <span class="term-line"><span class="term-prompt">$</span> <span class="user">claude design --brand brief.md --variants 3</span></span>
              <span class="term-line muted">  → UIバリエーション生成中...</span>
              <span class="term-line code">  ✓ Hi-Fiモック × 3案 (45 min)</span>
              <span class="term-line"></span>
              <span class="term-line"><span class="term-prompt">$</span> <span class="user">claude code --scaffold wp-theme --type custom</span></span>
              <span class="term-line muted">  → テーマ実装 / 設計レビュー / ドキュメント...</span>
              <span class="term-line ok">  ✓ 完了 — 従来比 <span class="num">-52%</span> の工数</span>
              <span class="term-line"></span>
              <span class="term-line"><span class="term-prompt">$</span> <span class="user">_<span class="cursor"></span></span></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4 PRINCIPLES -->
  <section class="principles" id="principles">
    <div class="section-stamp top" data-parallax-x="-0.30" aria-hidden="true">VALUES — VALUES — VALUES</div>
    <div class="blob b1" aria-hidden="true" data-parallax="0.18"></div>
    <div class="container">
      <div class="section-head">
        <div>
          <div class="eyebrow" style="margin-bottom: 20px;">
            <span class="dot"></span> 01 — What I Stand For
          </div>
          <h2>技術より先に、<br><span class="hi violet">姿勢と思考。</span></h2>
        </div>
        <p class="lede">
          事業を前に進めるために、技術以前に大事にしていることがあります。
          誠実さと論理、現状分析と実行力。この4つを土台に、すべての仕事に取り組みます。
        </p>
      </div>

      <div class="pr-grid">
        <div class="pr" data-delay="1">
          <span class="sticker">01</span>
          <span class="pr-emoji">In</span>
          <h3>Integrity</h3>
          <div class="jp">誠実さ</div>
          <p>できる・できないを正直に伝え、リスクは早めに共有します。納期・予算・品質に対して、曖昧な約束はしません。</p>
        </div>
        <div class="pr" data-delay="2">
          <span class="sticker blue">02</span>
          <span class="pr-emoji">Lo</span>
          <h3>Logic</h3>
          <div class="jp">論理的思考</div>
          <p>「なぜそうするか」を構造で語れること。感覚や流行ではなく、根拠と数字で意思決定をサポートします。</p>
        </div>
        <div class="pr" data-delay="3">
          <span class="sticker pink">03</span>
          <span class="pr-emoji">Di</span>
          <h3>Diagnosis</h3>
          <div class="jp">現状分析と課題化</div>
          <p>ぼんやりした「困りごと」を、解ける単位の課題に分解。本当に効く打ち手から優先順位をつけます。</p>
        </div>
        <div class="pr" data-delay="4">
          <span class="sticker yellow">04</span>
          <span class="pr-emoji">Ex</span>
          <h3>Execution</h3>
          <div class="jp">問題解決へつなげる力</div>
          <p>分析を「実装」と「運用」まで自分で落とし込める。レポートで終わらせず、結果が出るまで伴走します。</p>
        </div>
      </div>

      <div class="pr-flow" data-delay="5">
        <span class="pr-flow-label">Thinking Flow / 考え方の順番</span>
        <div class="pr-flow-items">
          <span class="pr-step">現状を観る</span>
          <span class="pr-arrow" style="color: var(--c-pink)">→</span>
          <span class="pr-step">課題に翻訳する</span>
          <span class="pr-arrow" style="color: var(--c-blue)">→</span>
          <span class="pr-step">仮説を立てる</span>
          <span class="pr-arrow" style="color: var(--c-violet)">→</span>
          <span class="pr-step">手を動かして解く</span>
        </div>
      </div>
    </div>
  </section>

  <!-- HOW WE WORK -->
  <section class="how" id="how">
    <div class="section-stamp bottom" data-parallax-x="0.35" aria-hidden="true">METHOD / 2026</div>
    <div class="container">
      <div class="section-head">
        <div>
          <div class="eyebrow" style="margin-bottom: 20px;">
            <span class="dot"></span> 05 — How We Work
          </div>
          <h2>ヒアリングから<wbr>運用改善まで、<br><span class="hi blue">同じ人間</span>が<span class="nowrap">完走します。</span></h2>
        </div>
        <p class="lede">
          営業・ディレクター・エンジニア・分析が分業しないこと。
          意思決定が早く、ブレない。それが小さなチームだからできる仕事の進め方です。
        </p>
      </div>

      <div class="steps">
        <div class="step" data-delay="1">
          <div class="step-no">STEP 01</div>
          <h4>事業ヒアリング</h4>
          <p>事業ゴールとKPIを揃え、課題の輪郭を一緒に描きます。</p>
        </div>
        <div class="step" data-delay="2">
          <div class="step-no">STEP 02</div>
          <h4>設計・要件定義</h4>
          <p>技術選定と工程を見える化し、合意できる形に落とします。</p>
        </div>
        <div class="step" data-delay="3">
          <div class="step-no">STEP 03</div>
          <h4>AI駆動開発</h4>
          <p>高品質なコードを、AIを使い倒して短納期で実装します。</p>
        </div>
        <div class="step" data-delay="4">
          <div class="step-no">STEP 04</div>
          <h4>公開・計測整備</h4>
          <p>GA4 等で初日から数字を取れる状態を整えます。</p>
        </div>
        <div class="step" data-delay="5">
          <div class="step-no">STEP 05</div>
          <h4>分析・改善</h4>
          <p>CVR を伸ばし続けるための運用に、長く伴走します。</p>
        </div>
      </div>

      <div class="how-note">
        <span class="badge">Point</span>
        <p>営業 / ディレクター / エンジニア / 分析 が分業せず、一人称で責任を持って完走。意思決定が早く、ブレません。</p>
      </div>
    </div>
  </section>

  <!-- WORKS PREVIEW -->
  <section class="works-preview">
    <div class="section-stamp top outline-bright" data-parallax-x="-0.40" aria-hidden="true">SELECTED WORKS — 2026</div>
    <div class="container">
      <div class="section-head">
        <div>
          <div class="eyebrow" style="margin-bottom: 20px;">
            <span class="dot"></span> 06 — Selected Works
          </div>
          <h2>最近の<br><span class="hi mint">取り組み</span>から。</h2>
        </div>
        <p class="lede">
          HP・Webシステム・業務効率化の各領域から、代表的なプロジェクトをいくつかご紹介します。
          詳細はWorksページでご覧いただけます。
        </p>
      </div>

      <div class="works-list">
        @foreach($works as $i => $work)
          <a href="{{ url('/works/' . $work->slug) }}" class="work-row" @if($i > 0) data-delay="{{ $i }}" @endif>
            <span class="work-no"><span class="work-bullet"></span>{{ str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT) }}</span>
            <span class="work-title">{{ $work->title }}</span>
            <span class="work-meta">{{ implode(' · ', $work->tags ?? []) }}</span>
            <span class="work-year">{{ $work->year }}</span>
            <span class="work-arrow">→</span>
          </a>
        @endforeach
      </div>

      <div style="margin-top: 48px; display: flex; justify-content: flex-end;">
        <a href="/works" class="btn btn-ghost magnet">
          全ての実績を見る <span class="arrow">→</span>
        </a>
      </div>
    </div>
  </section>

  <!-- WHY -->
  <section class="why">
    <div class="section-stamp bottom solid" data-parallax-x="0.30" aria-hidden="true">WHY US · WHY US</div>
    <div class="container">
      <div class="section-head">
        <div>
          <div class="eyebrow" style="margin-bottom: 20px;">
            <span class="dot"></span> 07 — Why Choose Us
          </div>
          <h2>3つの<span class="nowrap"><span class="hi pink">「同時提供」</span>で、</span><br>分業の壁をなくす。</h2>
        </div>
        <p class="lede">
          コードが書けるだけでも、戦略が語れるだけでも足りません。
          両方を同じ頭で、同時に提供できることが、私たちの強みです。
        </p>
      </div>

      <div class="why-grid">
        <div class="why-card" data-delay="1" data-hover>
          <div class="ico">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="9" cy="12" r="3"/><circle cx="15" cy="12" r="3"/></svg>
          </div>
          <h3>技術と事業の<br>両眼思考</h3>
          <p>コードが書けるだけでも、戦略が語れるだけでも足りない。両方を同じ頭で考えて、判断します。</p>
        </div>
        <div class="why-card" data-delay="2" data-hover>
          <div class="ico">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 12h4l2-7 4 14 2-7h6"/></svg>
          </div>
          <h3>作る・集める・回すを<br>一括で。</h3>
          <p>開発・SEO・運用改善・社内DXまでワンストップ。複数ベンダーを束ねる手間が、不要になります。</p>
        </div>
        <div class="why-card" data-delay="3" data-hover>
          <div class="ico">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M13 2L4 14h7l-1 8 9-12h-7z"/></svg>
          </div>
          <h3>スピードとクオリティの<br>両立。</h3>
          <p>AIをチームメンバーのように使いこなすことで、従来トレードオフだった2つを両立します。</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta" id="cta">
    <div class="section-stamp top" data-parallax-x="-0.40" aria-hidden="true">LET'S TALK · LET'S BUILD</div>
    <div class="cta-bg" aria-hidden="true">
      <div class="tech-grid"></div>
      <div class="tech-dots"></div>
      <div class="rings"><span></span><span></span><span></span></div>
    </div>
    <div class="container cta-inner">
      <div class="cta-stage3d" aria-hidden="true">
        <canvas id="cta3d"></canvas>
      </div>
      <h2 class="" data-delay="1">
        一緒に、<br>
        <span class="accent">勝てる事業</span>を<br>
        作りませんか。
      </h2>
      <p class="lead" data-delay="2">
        要件が固まっていない段階のご相談、リニューアルの可否診断、AI活用の壁打ちなど、お気軽にどうぞ。
        まずは30分の無料ヒアリングから、現状の課題と数字を整理しましょう。
      </p>
      <div class="cta-btns" data-delay="3">
        <a href="/company#contact" class="btn btn-primary magnet">
          無料ヒアリングを予約する <span class="arrow">→</span>
        </a>
        <a href="mailto:liberaspace3035@gmail.com" class="btn btn-ghost magnet">
          メールで相談 <span class="arrow">→</span>
        </a>
      </div>
      <div class="cta-foot" data-delay="4">
        <span><span class="dot"></span>SPOT</span>
        <span><span class="dot"></span>MONTHLY ADVISOR</span>
        <span><span class="dot"></span>PROJECT BASE</span>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
@endsection

@push("scripts")
  <script>
    /* ---------- Three.js: Hero wireframe stage ---------- */
    (function () {
      const canvas = document.getElementById('hero3d');
      if (!canvas || !window.THREE) return;

      const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
      renderer.setPixelRatio(Math.min(2, window.devicePixelRatio));

      const scene = new THREE.Scene();
      const camera = new THREE.PerspectiveCamera(38, 1, 0.1, 100);
      camera.position.set(0, 0, 6.2);

      const ACCENT = 0x56847A;
      const INK    = 0x191B1A;

      // Inner solid icosahedron (faceted, low poly)
      const coreGeo = new THREE.IcosahedronGeometry(0.55, 0);
      const core = new THREE.Mesh(
        coreGeo,
        new THREE.MeshBasicMaterial({ color: ACCENT, transparent: true, opacity: 0.95 })
      );
      scene.add(core);
      const coreWire = new THREE.LineSegments(
        new THREE.EdgesGeometry(coreGeo),
        new THREE.LineBasicMaterial({ color: 0x16241F, transparent: true, opacity: 0.5 })
      );
      scene.add(coreWire);

      // Mid wireframe icosahedron
      const midGeo = new THREE.IcosahedronGeometry(1.55, 1);
      const mid = new THREE.LineSegments(
        new THREE.EdgesGeometry(midGeo),
        new THREE.LineBasicMaterial({ color: ACCENT, transparent: true, opacity: 0.7 })
      );
      scene.add(mid);

      // Outer low-res wireframe sphere
      const outerGeo = new THREE.IcosahedronGeometry(2.35, 0);
      const outer = new THREE.LineSegments(
        new THREE.EdgesGeometry(outerGeo),
        new THREE.LineBasicMaterial({ color: INK, transparent: true, opacity: 0.18 })
      );
      scene.add(outer);

      // Orbit ring — particles
      const ringCount = 80;
      const ringGeo = new THREE.BufferGeometry();
      const positions = new Float32Array(ringCount * 3);
      const radii = new Float32Array(ringCount);
      const angles = new Float32Array(ringCount);
      for (let i = 0; i < ringCount; i++) {
        const a = (i / ringCount) * Math.PI * 2;
        const r = 2.9 + (Math.random() - 0.5) * 0.2;
        angles[i] = a;
        radii[i] = r;
        positions[i*3]   = Math.cos(a) * r;
        positions[i*3+1] = (Math.random() - 0.5) * 0.18;
        positions[i*3+2] = Math.sin(a) * r;
      }
      ringGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
      const ringMat = new THREE.PointsMaterial({
        color: INK, size: 0.045, transparent: true, opacity: 0.7,
        sizeAttenuation: true
      });
      const ring = new THREE.Points(ringGeo, ringMat);
      ring.rotation.x = Math.PI * 0.42;
      ring.rotation.z = Math.PI * 0.08;
      scene.add(ring);

      // Second orbit ring (smaller, accent)
      const ring2Geo = new THREE.BufferGeometry();
      const ring2Count = 40;
      const pos2 = new Float32Array(ring2Count * 3);
      for (let i = 0; i < ring2Count; i++) {
        const a = (i / ring2Count) * Math.PI * 2;
        const r = 2.05;
        pos2[i*3]   = Math.cos(a) * r;
        pos2[i*3+1] = (Math.random() - 0.5) * 0.06;
        pos2[i*3+2] = Math.sin(a) * r;
      }
      ring2Geo.setAttribute('position', new THREE.BufferAttribute(pos2, 3));
      const ring2 = new THREE.Points(
        ring2Geo,
        new THREE.PointsMaterial({ color: ACCENT, size: 0.06, transparent: true, opacity: 0.85 })
      );
      ring2.rotation.x = Math.PI * 0.6;
      ring2.rotation.z = -Math.PI * 0.18;
      scene.add(ring2);

      // 3 connector lines from core to outer (small fixed lines, illustrative)
      const connGeo = new THREE.BufferGeometry();
      const connPts = [];
      for (let i = 0; i < 6; i++) {
        const a = (i / 6) * Math.PI * 2;
        connPts.push(0, 0, 0);
        connPts.push(Math.cos(a) * 2.3, Math.sin(a) * 0.3, Math.sin(a) * 2.3);
      }
      connGeo.setAttribute('position', new THREE.Float32BufferAttribute(connPts, 3));
      const conn = new THREE.LineSegments(
        connGeo,
        new THREE.LineBasicMaterial({ color: INK, transparent: true, opacity: 0.15 })
      );
      scene.add(conn);

      // Mouse parallax
      let mx = 0, my = 0;
      window.addEventListener('mousemove', (e) => {
        mx = (e.clientX / window.innerWidth) - 0.5;
        my = (e.clientY / window.innerHeight) - 0.5;
      });

      function resize() {
        const w = canvas.clientWidth || 400;
        const h = canvas.clientHeight || 400;
        renderer.setSize(w, h, false);
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
      }
      resize();
      window.addEventListener('resize', resize, { passive: true });

      let t = 0;
      function animate() {
        t += 0.006;
        mid.rotation.y =  t * 0.8;
        mid.rotation.x =  t * 0.4;
        outer.rotation.y = -t * 0.3;
        outer.rotation.z =  t * 0.18;
        core.rotation.y =  t * 1.2;
        core.rotation.x =  t * 0.6;
        coreWire.rotation.copy(core.rotation);
        ring.rotation.y =  t * 0.55;
        ring2.rotation.y = -t * 0.9;
        conn.rotation.y = t * 0.5;
        const pulse = 1 + Math.sin(t * 3) * 0.06;
        core.scale.setScalar(pulse);
        coreWire.scale.setScalar(pulse);

        camera.position.x += (mx * 0.45 - camera.position.x) * 0.05;
        camera.position.y += (-my * 0.4 - camera.position.y) * 0.05;
        camera.lookAt(0, 0, 0);

        renderer.render(scene, camera);
        requestAnimationFrame(animate);
      }
      animate();
    })();

    /* ---------- Three.js: CTA mini stage ---------- */
    (function () {
      const canvas = document.getElementById('cta3d');
      if (!canvas || !window.THREE) return;

      const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
      renderer.setPixelRatio(Math.min(2, window.devicePixelRatio));

      const scene = new THREE.Scene();
      const camera = new THREE.PerspectiveCamera(40, 1, 0.1, 100);
      camera.position.set(0, 0, 5);

      const ACCENT = 0x56847A;
      const INK    = 0x191B1A;

      // Outer wireframe ring (torus)
      const torus = new THREE.Mesh(
        new THREE.TorusGeometry(1.5, 0.02, 8, 96),
        new THREE.MeshBasicMaterial({ color: INK, transparent: true, opacity: 0.4 })
      );
      torus.rotation.x = Math.PI * 0.55;
      scene.add(torus);

      // Wireframe icosahedron
      const icoGeo = new THREE.IcosahedronGeometry(1.05, 1);
      const ico = new THREE.LineSegments(
        new THREE.EdgesGeometry(icoGeo),
        new THREE.LineBasicMaterial({ color: ACCENT, transparent: true, opacity: 0.8 })
      );
      scene.add(ico);

      // Core
      const core = new THREE.Mesh(
        new THREE.IcosahedronGeometry(0.42, 0),
        new THREE.MeshBasicMaterial({ color: ACCENT })
      );
      scene.add(core);

      function resize() {
        const w = canvas.clientWidth || 200;
        const h = canvas.clientHeight || 200;
        renderer.setSize(w, h, false);
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
      }
      resize();
      window.addEventListener('resize', resize, { passive: true });

      let t = 0;
      function animate() {
        t += 0.008;
        ico.rotation.y = t * 0.9;
        ico.rotation.x = t * 0.5;
        torus.rotation.z = t * 0.4;
        core.scale.setScalar(1 + Math.sin(t * 3) * 0.08);
        renderer.render(scene, camera);
        requestAnimationFrame(animate);
      }
      animate();
    })();
  </script>
  <script>
    // Tilt the terminal slightly on mouse move
    (function(){
      const term = document.getElementById('terminal');
      if (!term) return;
      const wrap = term.parentElement;
      wrap.addEventListener('mousemove', (e) => {
        const r = wrap.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - 0.5;
        const y = (e.clientY - r.top) / r.height - 0.5;
        term.style.transform = `perspective(1000px) rotateY(${x * 5}deg) rotateX(${-y * 5}deg) rotate(${-1 + x * 2}deg)`;
      });
      wrap.addEventListener('mouseleave', () => { term.style.transform = ''; });
      term.style.transition = 'transform 0.2s ease-out';
    })();

    // Manifesto: progressively words on scroll
    (function () {
      const words = document.querySelectorAll('.manifesto-title .w');
      if (!words.length) return;

      const onScroll = () => {
        const rect = document.querySelector('.manifesto').getBoundingClientRect();
        const vh = window.innerHeight;
        // Progress: 0 when section enters viewport bottom, 1 when section exits top
        const total = vh + rect.height;
        const passed = vh - rect.top;
        const p = Math.max(0, Math.min(1, passed / total));
        // Reveal extra words proportional to scroll
        const n = Math.floor(p * words.length * 1.5);
        words.forEach((w, i) => w.classList.toggle('in', i < n));
      };
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();
    })();
  </script>
@endpush
