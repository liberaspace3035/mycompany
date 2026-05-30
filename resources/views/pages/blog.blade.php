@extends("layouts.site")

@push("head")
  <style>
    .featured-post {
      display: grid;
      grid-template-columns: 1.1fr 1fr;
      gap: 48px;
      padding: 40px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      margin-bottom: 80px;
      align-items: center;
      position: relative;
      overflow: hidden;
    }
    .featured-post::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 3px; height: 100%;
      background: var(--accent);
    }
    .featured-tag {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 12px;
      background: var(--accent);
      color: var(--accent-ink);
      border-radius: 999px;
      font-family: var(--font-mono);
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-bottom: 24px;
    }
    .featured-post h2 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: clamp(28px, 3vw, 40px);
      letter-spacing: -0.02em;
      line-height: 1.35;
      margin-bottom: 20px;
    }
    .featured-post p { color: var(--text-dim); font-size: 16px; line-height: 1.85; margin-bottom: 28px; }
    .featured-post .meta {
      display: flex;
      gap: 16px;
      font-family: var(--font-mono);
      font-size: 12px;
      color: var(--text-muted);
      letter-spacing: 0.08em;
      align-items: center;
    }
    .featured-art {
      aspect-ratio: 4/3;
      background: var(--bg-2);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      position: relative;
      overflow: hidden;
      display: grid;
      place-items: center;
      isolation: isolate;
    }
    .featured-art::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(to right, rgba(25,27,26,0.05) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(25,27,26,0.05) 1px, transparent 1px);
      background-size: 32px 32px;
      mask-image: radial-gradient(ellipse 80% 70% at 50% 50%, #000 30%, transparent 92%);
      -webkit-mask-image: radial-gradient(ellipse 80% 70% at 50% 50%, #000 30%, transparent 92%);
      z-index: 0;
    }
    .featured-art::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(25,27,26,0.13) 1px, transparent 1.4px);
      background-size: 32px 32px;
      background-position: 16px 16px;
      mask-image: radial-gradient(ellipse 60% 55% at 50% 50%, #000 25%, transparent 85%);
      -webkit-mask-image: radial-gradient(ellipse 60% 55% at 50% 50%, #000 25%, transparent 85%);
      opacity: 0.55;
      z-index: 0;
    }
    .featured-art canvas {
      position: absolute;
      top: 50%; left: 50%;
      width: 65% !important;
      height: auto !important;
      aspect-ratio: 1;
      transform: translate(-50%, -50%);
      z-index: 1;
      display: block;
    }
    .featured-art .badge {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.22em;
      color: var(--text);
      text-transform: uppercase;
      padding: 8px 14px;
      border: 1px solid var(--border-2);
      border-radius: 3px;
      background: var(--bg);
      z-index: 3;
      font-weight: 600;
    }

    .cat-filters {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      margin-bottom: 48px;
      padding: 20px 0;
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      align-items: center;
    }
    .cat-filters .label {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-right: 12px;
    }
    .cat-pill {
      padding: 6px 14px;
      border-radius: 999px;
      border: 1px solid var(--border-2);
      font-size: 13px;
      color: var(--text-dim);
      cursor: pointer;
      background: none;
      font-family: inherit;
      transition: all 0.2s ease;
    }
    .cat-pill:hover { border-color: var(--border-bright); color: var(--text); }
    .cat-pill.active {
      background: var(--accent);
      color: var(--accent-ink);
      border-color: var(--accent);
      font-weight: 600;
    }

    .post-list {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }
    .post-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .post-card:hover { border-color: var(--border-bright); transform: translateY(-4px); }
    .post-thumb {
      aspect-ratio: 16/9;
      position: relative;
      overflow: hidden;
      border-bottom: 1px solid var(--border);
      display: grid;
      place-items: center;
      background: var(--bg-2);
      isolation: isolate;
    }
    .post-thumb::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(to right, rgba(25,27,26,0.045) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(25,27,26,0.045) 1px, transparent 1px);
      background-size: 28px 28px;
      mask-image: radial-gradient(ellipse 80% 70% at 50% 50%, #000 30%, transparent 90%);
      -webkit-mask-image: radial-gradient(ellipse 80% 70% at 50% 50%, #000 30%, transparent 90%);
      z-index: 0;
    }
    .post-thumb::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(25,27,26,0.12) 1px, transparent 1.4px);
      background-size: 28px 28px;
      background-position: 14px 14px;
      mask-image: radial-gradient(ellipse 55% 55% at 50% 50%, #000 25%, transparent 85%);
      -webkit-mask-image: radial-gradient(ellipse 55% 55% at 50% 50%, #000 25%, transparent 85%);
      opacity: 0.55;
      z-index: 0;
    }
    .post-thumb-label {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text);
      padding: 6px 12px;
      background: var(--bg);
      border: 1px solid var(--border-2);
      border-radius: 3px;
      z-index: 2;
      font-weight: 600;
      position: relative;
    }
    /* Per-category accent line at top of thumb */
    .post-thumb .accent-line {
      position: absolute;
      top: 0; left: 0;
      width: 40%; height: 2px;
      background: var(--accent);
      z-index: 2;
    }
    .post-thumb[data-cat="seo"]  .accent-line { background: var(--c-cyan); }
    .post-thumb[data-cat="dx"]   .accent-line { background: var(--c-mint); }
    .post-thumb[data-cat="biz"]  .accent-line { background: var(--c-pink); }
    .post-thumb[data-cat="note"] .accent-line { background: var(--c-yellow); }

    .post-body { padding: 24px 24px 28px; display: flex; flex-direction: column; gap: 12px; flex: 1; }
    .post-card .cat {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--accent);
    }
    .post-card h3 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 18px;
      letter-spacing: -0.005em;
      line-height: 1.5;
      flex: 1;
    }
    .post-card .meta {
      display: flex;
      gap: 12px;
      font-family: var(--font-mono);
      font-size: 11px;
      color: var(--text-muted);
      letter-spacing: 0.08em;
      padding-top: 12px;
      border-top: 1px solid var(--border);
    }

    .pagination {
      display: flex;
      gap: 6px;
      justify-content: center;
      margin-top: 64px;
    }
    .page-btn {
      width: 40px; height: 40px;
      display: grid; place-items: center;
      border: 1px solid var(--border-2);
      border-radius: 8px;
      color: var(--text-dim);
      background: none;
      font-family: var(--font-mono);
      font-size: 13px;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .page-btn:hover { border-color: var(--border-bright); color: var(--text); }
    .page-btn.active { background: var(--accent); color: var(--accent-ink); border-color: var(--accent); font-weight: 600; }
    .page-btn.arrow { padding: 0 14px; width: auto; }

    @media (max-width: 1080px) {
      .featured-post { grid-template-columns: 1fr; }
      .featured-art { max-width: 520px; margin: 0 auto; width: 100%; }
      .post-list { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 720px) {
      .post-list { grid-template-columns: 1fr; }
      .featured-post { padding: 28px 22px; gap: 28px; }
      .featured-post h2 { font-size: clamp(22px, 5.5vw, 28px); }
      .featured-post p { font-size: 14.5px; line-height: 1.8; }
      .featured-art { aspect-ratio: 16/10; }
      .featured-tag { margin-bottom: 16px; }
      .cat-filters { gap: 6px; padding: 16px 0; }
      .cat-pill { font-size: 12px; padding: 6px 12px; }
      .post-card h3 { font-size: 16px; }
      .post-body { padding: 18px 20px 22px; }
      .pagination { flex-wrap: wrap; }
    }
  </style>
@endpush

@section("content")
  <section class="page-hero">
    <span class="page-hero-corner tl" aria-hidden="true"></span>
    <span class="page-hero-corner tr" aria-hidden="true"></span>
    <span class="page-hero-corner bl" aria-hidden="true"></span>
    <span class="page-hero-corner br" aria-hidden="true"></span>
    <div class="page-hero-top" aria-hidden="true">
      <span><strong>{{ strtoupper($page->name) }}</strong> &nbsp;/&nbsp; {{ $page->hero_eyebrow ?? 'NOTES' }}</span>
      <span>SYS // FIELD LOG</span>
    </div>
    <div class="page-hero-3d" aria-hidden="true">
      <canvas data-tech-3d></canvas>
    </div>
    <div class="container">
      <div class="eyebrow"><span class="dot"></span> {{ $page->name }}</div>
      <h1>{!! nl2br(e($page->hero_title)) !!}</h1>
      @if($page->hero_sub)
        <p class="lead">{{ $page->hero_sub }}</p>
      @endif
    </div>
  </section>

  <section style="padding: 80px 0 140px;">
    <div class="container">

      <!-- Featured -->
      @if($featured)
        <article class="featured-post">
          <div>
            <span class="featured-tag">★ Featured</span>
            <h2>{{ $featured->title }}</h2>
            @if($featured->summary)
              <p>{{ $featured->summary }}</p>
            @endif
            <div class="meta">
              @if($featured->category)<span>{{ strtoupper($featured->category->name) }}</span><span>·</span>@endif
              <span>{{ $featured->published_at?->format('Y.m.d') }}</span>
            </div>
            <div style="margin-top: 32px;">
              <a href="{{ route('blog.show', $featured->slug) }}" class="btn btn-primary">記事を読む <span class="arrow">→</span></a>
            </div>
          </div>
          <div class="featured-art" aria-hidden="true">
            @if($featured->eyecatch)
              <img src="{{ \Illuminate\Support\Str::startsWith($featured->eyecatch, 'http') ? $featured->eyecatch : asset('uploads/' . $featured->eyecatch) }}" alt="" style="width:100%; height:100%; object-fit: cover;">
            @else
              <canvas data-tech-3d></canvas>
              <span class="badge" style="position: absolute; bottom: 16px; right: 16px;">/ {{ strtoupper($featured->category?->name ?? 'NOTE') }}</span>
            @endif
          </div>
        </article>
      @endif

      <!-- Categories -->
      @php $allCats = \App\Models\Category::orderBy('position')->get(); @endphp
      <div class="cat-filters">
        <span class="label">Categories</span>
        <button class="cat-pill active">All</button>
        @foreach($allCats as $cat)
          <button class="cat-pill">{{ $cat->name }}</button>
        @endforeach
      </div>

      <!-- Posts -->
      <div class="post-list">
        @foreach($posts as $i => $post)
          @php
            $catSlug = $post->category?->slug ?? "";
            $catShort = match($catSlug) {
              "ai"       => "ai",
              "tech"     => "web",
              "business" => "biz",
              "design"   => "note",
              default    => "note",
            };
          @endphp
          <a href="{{ route("blog.show", $post->slug) }}" class="post-card" @if($i > 0) data-delay="{{ $i }}" @endif style="text-decoration: none; color: inherit;">
            <div class="post-thumb" data-cat="{{ $catShort }}">
              <span class="accent-line"></span>
              <span class="post-thumb-label">/ {{ strtoupper($catShort) }}</span>
            </div>
            <div class="post-body">
              <span class="cat">{{ strtoupper($post->category?->name ?? "") }}</span>
              <h3>{{ $post->title }}</h3>
              <div class="meta"><span>{{ $post->published_at?->format("Y.m.d") }}</span></div>
            </div>
          </a>
        @endforeach
      </div>

      <div class="pagination">
        <button class="page-btn arrow">←</button>
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn">4</button>
        <button class="page-btn arrow">→</button>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section style="padding: 100px 0; background: var(--bg-2); border-top: 1px solid var(--border);">
    <div class="container">
      <div style="max-width: 720px; margin: 0 auto; text-align: center;" class="">
        <div class="eyebrow" style="margin: 0 auto 28px; justify-content: center;">
          <span class="dot"></span> Newsletter
        </div>
        <h2 style="font-family: var(--font-jp); font-weight: 700; font-size: clamp(32px, 3.5vw, 44px); letter-spacing: -0.02em; line-height: 1.3;">
          月1通、現場のリアルを<br>お届けします。
        </h2>
        <p style="color: var(--text-dim); margin: 24px auto 36px; font-size: 16px; line-height: 1.85; max-width: 48ch;">
          AI活用・Web制作・DX推進に関する最新ノウハウを、ノイズ少なめに月1通でお送りします。
          配信解除はいつでも。
        </p>
        <form style="display: flex; gap: 8px; max-width: 480px; margin: 0 auto;" onsubmit="event.preventDefault(); this.querySelector('button').innerText='送信完了 ✓';">
          <input type="email" placeholder="email@example.com" required
            style="flex:1;padding:14px 18px;background:var(--surface);border:1px solid var(--border-2);border-radius:999px;color:var(--text);font-family:inherit;font-size:14px;outline:none;"
            onfocus="this.style.borderColor='var(--accent)'"
            onblur="this.style.borderColor='var(--border-2)'" />
          <button type="submit" class="btn btn-primary">登録 <span class="arrow">→</span></button>
        </form>
      </div>
    </div>
  </section>
@endsection

@push("scripts")
<script src="{{ asset("assets/tech-3d.js") }}"></script>
  <script>
    document.querySelectorAll('.cat-pill, .page-btn').forEach(b => {
      if (b.classList.contains('arrow')) return;
      b.addEventListener('click', () => {
        b.parentElement.querySelectorAll(b.tagName.toLowerCase() === 'button' && b.classList.contains('cat-pill') ? '.cat-pill' : '.page-btn').forEach(x => {
          if (!x.classList.contains('arrow')) x.classList.remove('active');
        });
        b.classList.add('active');
      });
    });
  </script>
@endpush
