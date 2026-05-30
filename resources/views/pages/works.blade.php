@extends("layouts.site")

@push("head")
  <style>
    .filters {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      margin: 0 0 56px;
      padding: 24px 0;
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      align-items: center;
    }
    .filters-label {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-right: 16px;
    }
    .filter {
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
    .filter:hover { color: var(--text); border-color: var(--border-bright); }
    .filter.active {
      background: var(--accent);
      color: var(--accent-ink);
      border-color: var(--accent);
      font-weight: 600;
    }
    .works-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
    }
    .work-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .work-card:hover { border-color: var(--border-bright); transform: translateY(-4px); }
    .work-card:hover .work-thumb-fg { transform: scale(1.04); }
    .work-thumb {
      position: relative;
      aspect-ratio: 16 / 10;
      background: var(--bg-2);
      overflow: hidden;
      border-bottom: 1px solid var(--border);
      isolation: isolate;
    }
    .work-thumb::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(to right, rgba(25,27,26,0.045) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(25,27,26,0.045) 1px, transparent 1px);
      background-size: 32px 32px;
      mask-image: radial-gradient(ellipse 70% 60% at 50% 50%, #000 30%, transparent 88%);
      -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 50%, #000 30%, transparent 88%);
      z-index: 0;
    }
    .work-thumb::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(25,27,26,0.12) 1px, transparent 1.4px);
      background-size: 32px 32px;
      background-position: 16px 16px;
      mask-image: radial-gradient(ellipse 50% 50% at 50% 50%, #000 20%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse 50% 50% at 50% 50%, #000 20%, transparent 80%);
      opacity: 0.55;
      z-index: 0;
    }
    .work-thumb-fg {
      position: absolute;
      inset: 0;
      display: grid;
      place-items: center;
      transition: transform 0.6s ease;
      z-index: 2;
    }
    .work-thumb-mockup {
      width: 80%;
      aspect-ratio: 16/10;
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: 0 20px 60px rgba(0,0,0,0.4);
      position: relative;
      overflow: hidden;
    }
    .work-thumb-mockup::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 22px;
      background: var(--surface);
      border-bottom: 1px solid var(--border);
    }
    .work-thumb-mockup::after {
      content: '';
      position: absolute;
      top: 8px; left: 12px;
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--text-faint);
      box-shadow:
        10px 0 0 var(--text-faint),
        20px 0 0 var(--text-faint);
    }
    .work-thumb-content {
      position: absolute;
      top: 32px; left: 12px; right: 12px; bottom: 12px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .skeleton {
      background: var(--surface-2);
      border-radius: 3px;
    }
    /* Tiny tag badge per thumb */
    .work-thumb-tag {
      position: absolute;
      top: 12px; left: 12px;
      padding: 4px 10px;
      background: var(--text);
      color: var(--bg);
      border-radius: 3px;
      font-family: var(--font-mono);
      font-size: 9.5px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      font-weight: 600;
      z-index: 3;
    }
    .work-thumb .bg-glow {
      display: none;
    }
    .work-body { padding: 24px 28px 28px; display: flex; flex-direction: column; gap: 12px; }
    .work-head { display: flex; justify-content: space-between; gap: 16px; align-items: flex-start; }
    .work-card h3 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 20px;
      letter-spacing: -0.005em;
      line-height: 1.4;
    }
    .work-card .year {
      font-family: var(--font-mono);
      font-size: 12px;
      color: var(--text-muted);
      letter-spacing: 0.08em;
      flex-shrink: 0;
      padding-top: 4px;
    }
    .work-card p { font-size: 14px; color: var(--text-dim); line-height: 1.7; }
    .work-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 4px; }
    .work-result {
      display: flex;
      gap: 24px;
      padding-top: 16px;
      margin-top: 4px;
      border-top: 1px solid var(--border);
    }
    .work-result-item .v {
      font-family: var(--font-en);
      font-size: 22px;
      font-weight: 500;
      color: var(--accent);
      letter-spacing: -0.01em;
    }
    .work-result-item .l {
      font-family: var(--font-mono);
      font-size: 10px;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-top: 2px;
    }
    @media (max-width: 800px) {
      .works-grid { grid-template-columns: 1fr; }
      .filters { gap: 6px; padding: 16px 0; margin-bottom: 36px; }
      .filter { font-size: 12px; padding: 6px 12px; }
      .filters-label { margin-right: 8px; }
      .work-body { padding: 20px 22px 22px; }
      .work-card h3 { font-size: 17px; }
      .work-card p { font-size: 13.5px; }
      .work-result { gap: 18px; }
      .work-result-item .v { font-size: 19px; }
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
      <span><strong>{{ strtoupper($page->name) }}</strong> &nbsp;/&nbsp; {{ $page->hero_eyebrow ?? 'ARCHIVE' }}</span>
      <span>SYS // SELECTED {{ str_pad((string) $works->count(), 2, '0', STR_PAD_LEFT) }}</span>
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
      @php
        $currentCat = request()->string('category')->toString();
        $cats = \App\Models\Work::query()->select('category')->distinct()->orderBy('category')->pluck('category');
      @endphp
      <div class="filters">
        <span class="filters-label">Filter</span>
        <a href="{{ route('works.index') }}" class="filter @if($currentCat === '') active @endif">All</a>
        @foreach($cats as $c)
          <a href="{{ route('works.index', ['category' => $c]) }}" class="filter @if($currentCat === $c) active @endif">{{ $c }}</a>
        @endforeach
      </div>

      <div class="works-grid">
        @foreach($works as $i => $work)
          <article class="work-card" @if($i > 0) data-delay="{{ $i }}" @endif>
            <div class="work-thumb">
              <span class="work-thumb-tag">/ {{ strtoupper(\App\Support\WorkUi::shortTag($work->category)) }}</span>
              <div class="work-thumb-fg">
                <div class="work-thumb-mockup">
                  <div class="work-thumb-content">
                    @if($work->image)
                      <img src="{{ \Illuminate\Support\Str::startsWith($work->image, "http") ? $work->image : asset("uploads/" . $work->image) }}" alt="{{ $work->title }}" style="width:100%; height:100%; object-fit: cover;">
                    @else
                      <div class="skeleton" style="width:40%;height:10px;"></div>
                      <div class="skeleton" style="width:70%;height:16px;margin-top:4px;"></div>
                      <div class="skeleton" style="width:55%;height:8px;"></div>
                      <div style="display:flex;gap:6px;margin-top:auto;">
                        <div class="skeleton" style="width:30%;height:28px;background:var(--accent);"></div>
                        <div class="skeleton" style="width:30%;height:28px;"></div>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="work-body">
              <div class="work-head">
                <h3>{{ $work->title }}</h3>
                <span class="year">{{ $work->year }}</span>
              </div>
              @if($work->summary)<p>{{ $work->summary }}</p>@endif
              @if(!empty($work->tags))
                <div class="work-tags">
                  @foreach($work->tags as $ti => $tag)
                    <span class="chip @if($ti === 0) chip-accent @endif">{{ $tag }}</span>
                  @endforeach
                </div>
              @endif
            </div>
          </article>
        @endforeach
      </div>

      <div style="margin-top: 64px; text-align: center;">
        <p class="text-dim" style="font-size: 14px; margin-bottom: 20px;">※ 実績は一部抜粋です。守秘義務によりロゴ・スクリーンショットは非公開。</p>
        <a href="/company#contact" class="btn btn-primary">類似事例の詳細を聞く <span class="arrow">→</span></a>
      </div>
    </div>
  </section>
@endsection

@push("scripts")
<script src="{{ asset("assets/tech-3d.js") }}"></script>
  <script>
    document.querySelectorAll('.filter').forEach(b => {
      b.addEventListener('click', () => {
        document.querySelectorAll('.filter').forEach(x => x.classList.remove('active'));
        b.classList.add('active');
      });
    });
  </script>
@endpush
