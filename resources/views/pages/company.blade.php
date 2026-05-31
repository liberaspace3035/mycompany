@extends("layouts.site")

@push("head")
  <style>
    .intro-grid {
      display: grid;
      grid-template-columns: 1fr 1.4fr;
      gap: 80px;
      padding: 120px 0;
      border-bottom: 1px solid var(--border);
      align-items: start;
    }
    .portrait {
      aspect-ratio: 4/5;
      background: var(--bg-2);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      position: relative;
      overflow: hidden;
      display: grid;
      place-items: center;
      isolation: isolate;
    }
    .portrait::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(to right, rgba(25,27,26,0.05) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(25,27,26,0.05) 1px, transparent 1px);
      background-size: 32px 32px;
      mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, #000 30%, transparent 92%);
      -webkit-mask-image: radial-gradient(ellipse 90% 80% at 50% 50%, #000 30%, transparent 92%);
      z-index: 0;
    }
    .portrait::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(25,27,26,0.13) 1px, transparent 1.4px);
      background-size: 32px 32px;
      background-position: 16px 16px;
      mask-image: radial-gradient(ellipse 60% 60% at 50% 50%, #000 20%, transparent 85%);
      -webkit-mask-image: radial-gradient(ellipse 60% 60% at 50% 50%, #000 20%, transparent 85%);
      opacity: 0.55;
      z-index: 0;
    }
    .portrait canvas {
      position: absolute;
      top: 50%; left: 50%;
      width: 75% !important;
      height: auto !important;
      aspect-ratio: 1;
      transform: translate(-50%, -50%);
      z-index: 1;
      display: block;
    }
    .portrait .placeholder {
      position: relative;
      z-index: 3;
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--text);
      padding: 8px 14px;
      border: 1px solid var(--border-2);
      border-radius: 3px;
      background: var(--bg);
      font-weight: 600;
    }
    /* Corner brackets inside portrait */
    .portrait .pc {
      position: absolute;
      width: 16px; height: 16px;
      border: 1.5px solid var(--text);
      z-index: 2;
      opacity: 0.55;
    }
    .portrait .pc.tl { top: 12px; left: 12px; border-right: 0; border-bottom: 0; }
    .portrait .pc.tr { top: 12px; right: 12px; border-left: 0; border-bottom: 0; }
    .portrait .pc.bl { bottom: 12px; left: 12px; border-right: 0; border-top: 0; }
    .portrait .pc.br { bottom: 12px; right: 12px; border-left: 0; border-top: 0; }

    .intro-content h2 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: clamp(36px, 4vw, 52px);
      letter-spacing: -0.02em;
      line-height: 1.3;
      margin-bottom: 32px;
    }
    .intro-content h2 em { font-style: normal; color: var(--accent); }
    .intro-content p {
      color: var(--text-dim);
      font-size: 16px;
      line-height: 1.95;
      margin-bottom: 20px;
    }
    .intro-content p strong { color: var(--text); font-weight: 500; }

    .profile-table {
      margin-top: 56px;
      width: 100%;
      border-collapse: collapse;
    }
    .profile-table th, .profile-table td {
      padding: 18px 0;
      border-bottom: 1px solid var(--border);
      text-align: left;
      vertical-align: top;
    }
    .profile-table th {
      width: 200px;
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text-muted);
      font-weight: 500;
    }
    .profile-table td {
      font-size: 15px;
      color: var(--text);
      line-height: 1.7;
    }
    .profile-table td .sub { color: var(--text-dim); font-size: 13px; display: block; margin-top: 4px; }

    /* Timeline */
    .timeline-section {
      padding: 140px 0;
      background: var(--bg-2);
      border-bottom: 1px solid var(--border);
    }
    .timeline {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 80px;
    }
    .tl-items { display: flex; flex-direction: column; gap: 4px; }
    .tl-item {
      display: grid;
      grid-template-columns: 100px 1fr;
      gap: 32px;
      padding: 24px 0;
      border-bottom: 1px solid var(--border);
      align-items: start;
    }
    .tl-year {
      font-family: var(--font-en);
      font-weight: 500;
      font-size: 22px;
      letter-spacing: -0.01em;
      color: var(--accent);
    }
    .tl-content h4 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 17px;
      letter-spacing: -0.005em;
      margin-bottom: 6px;
    }
    .tl-content p {
      font-size: 14px;
      color: var(--text-dim);
      line-height: 1.7;
    }

    /* Skills */
    .skills-section {
      padding: 140px 0;
      border-bottom: 1px solid var(--border);
    }
    .skill-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }
    .skill-col {
      padding: 28px 24px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
    }
    .skill-col h4 {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--accent);
      font-weight: 500;
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--border);
    }
    .skill-col ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
    .skill-col li { font-size: 14px; color: var(--text); }
    .skill-col li .lvl {
      display: inline-block;
      width: 6px; height: 6px; border-radius: 50%;
      background: var(--accent);
      margin-right: 10px;
      vertical-align: middle;
    }

    /* Contact */
    .contact-section {
      padding: 160px 0;
      position: relative;
      overflow: hidden;
      background: var(--bg);
    }
    .contact-bg {
      position: absolute; inset: 0; pointer-events: none; z-index: 0;
    }
    .contact-bg .tech-grid {
      position: absolute; inset: 0;
      background-image:
        linear-gradient(to right, rgba(25,27,26,0.04) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(25,27,26,0.04) 1px, transparent 1px);
      background-size: 64px 64px;
      mask-image: radial-gradient(ellipse 100% 75% at 50% 50%, #000 30%, transparent 90%);
      -webkit-mask-image: radial-gradient(ellipse 100% 75% at 50% 50%, #000 30%, transparent 90%);
    }
    .contact-bg .tech-dots {
      position: absolute; inset: 0;
      background-image: radial-gradient(circle, rgba(25,27,26,0.14) 1px, transparent 1.4px);
      background-size: 64px 64px;
      background-position: 32px 32px;
      mask-image: radial-gradient(ellipse 65% 55% at 50% 50%, #000 20%, transparent 80%);
      -webkit-mask-image: radial-gradient(ellipse 65% 55% at 50% 50%, #000 20%, transparent 80%);
      opacity: 0.55;
    }
    .contact-bg .rings {
      position: absolute;
      top: 50%; right: -200px;
      width: 600px; height: 600px;
      transform: translateY(-50%);
      pointer-events: none;
    }
    .contact-bg .rings span {
      position: absolute;
      inset: 0;
      border-radius: 50%;
      border: 1px dashed var(--border-2);
      opacity: 0.5;
      animation: contact-ring-spin 60s linear infinite;
    }
    .contact-bg .rings span:nth-child(2) { transform: scale(0.7); animation-duration: 80s; animation-direction: reverse; }
    .contact-bg .rings span:nth-child(3) { transform: scale(0.45); animation-duration: 100s; border-style: solid; border-color: var(--border); }
    @keyframes contact-ring-spin { to { transform: rotate(360deg); } }
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1.2fr;
      gap: 80px;
      position: relative;
      z-index: 2;
      align-items: start;
    }
    .contact-info h2 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: clamp(40px, 4.4vw, 60px);
      letter-spacing: -0.025em;
      line-height: 1.2;
      margin-bottom: 32px;
    }
    .contact-info h2 em { font-style: normal; color: var(--accent); }
    .contact-info .lead {
      color: var(--text-dim);
      font-size: 16px;
      line-height: 1.95;
      margin-bottom: 40px;
    }
    .contact-meta {
      display: flex;
      flex-direction: column;
      gap: 24px;
      padding-top: 32px;
      border-top: 1px solid var(--border);
    }
    .contact-meta-item {
      display: grid;
      grid-template-columns: 100px 1fr;
      gap: 24px;
      align-items: baseline;
    }
    .contact-meta-item .k {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text-muted);
    }
    .contact-meta-item .v {
      font-size: 15px;
      color: var(--text);
    }
    .contact-meta-item .v a { color: var(--accent); }

    .contact-form {
      padding: 40px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      backdrop-filter: blur(20px);
    }
    .contact-form h3 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 22px;
      letter-spacing: -0.005em;
      margin-bottom: 8px;
    }
    .form-sub {
      color: var(--text-dim);
      font-size: 14px;
      margin-bottom: 28px;
    }
    .form-row { margin-bottom: 18px; }
    .form-row label {
      display: block;
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 8px;
    }
    .form-row label .req { color: var(--accent); }
    .form-row input, .form-row textarea, .form-row select {
      width: 100%;
      padding: 14px 16px;
      background: var(--bg);
      border: 1px solid var(--border-2);
      border-radius: var(--radius);
      color: var(--text);
      font-family: inherit;
      font-size: 14px;
      outline: none;
      transition: border-color 0.2s ease;
      resize: vertical;
    }
    .form-row textarea { min-height: 120px; }
    .form-row input:focus, .form-row textarea:focus, .form-row select:focus {
      border-color: var(--accent);
    }
    .form-row.cols { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-row.cols .form-row { margin-bottom: 0; }

    .checks { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px; }
    .check {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 14px;
      border-radius: 999px;
      border: 1px solid var(--border-2);
      font-size: 12.5px;
      color: var(--text-dim);
      cursor: pointer;
      transition: all 0.2s ease;
      font-family: inherit;
    }
    .check.active {
      border-color: var(--accent);
      color: var(--accent);
      background: var(--accent-soft);
    }

    .form-submit { margin-top: 8px; width: 100%; padding: 16px; }

    @media (max-width: 1080px) {
      .intro-grid, .timeline, .contact-grid { grid-template-columns: 1fr; gap: 48px; }
      .skill-grid { grid-template-columns: 1fr 1fr; }
      .portrait { max-width: 380px; margin: 0 auto; aspect-ratio: 1; }
      .portrait canvas { width: 70% !important; }
    }
    @media (max-width: 720px) {
      .skill-grid { grid-template-columns: 1fr; }
      .tl-item { grid-template-columns: 70px 1fr; gap: 16px; }
      .form-row.cols { grid-template-columns: 1fr; }
      .intro-grid, .timeline-section, .skills-section, .contact-section { padding: 80px 0; }
      .intro-content h2, .timeline-section h2, .skills-section h2, .contact-info h2 {
        font-size: clamp(28px, 6.5vw, 36px);
      }
      .contact-form { padding: 28px 20px; }
      .profile-table th { width: 130px; font-size: 10px; }
      .profile-table th, .profile-table td { padding: 14px 0; font-size: 13.5px; }
      .tl-year { font-size: 18px; }
      .skill-col { padding: 24px 20px; }
      .contact-meta-item { grid-template-columns: 70px 1fr; gap: 16px; }
      .contact-meta-item .k { font-size: 10px; }
      .contact-meta-item .v { font-size: 14px; }
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
      <span><strong>{{ strtoupper($page->name) }}</strong> &nbsp;/&nbsp; {{ $page->hero_eyebrow ?? 'PROFILE' }}</span>
      <span>SYS // OPERATOR.01</span>
    </div>
    <div class="page-hero-3d" aria-hidden="true">
      <canvas data-tech-3d></canvas>
    </div>
    <div class="container">
      <div class="eyebrow"><span class="dot"></span> {{ $page->name }} &amp; Profile</div>
      <h1>{!! nl2br(e($page->hero_title)) !!}</h1>
      @if($page->hero_sub)
        <p class="lead">{{ $page->hero_sub }}</p>
      @endif
    </div>
  </section>

  <!-- Intro / Profile -->
  <section>
    <div class="container intro-grid">
      <div class="portrait" aria-hidden="true">
        <span class="pc tl"></span><span class="pc tr"></span>
        <span class="pc bl"></span><span class="pc br"></span>
        <canvas data-tech-3d></canvas>
        <span class="placeholder" style="position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%);">/ PORTRAIT — 後日アップ</span>
      </div>
      <div class="intro-content" data-delay="1">
        <h2>技術と事業を、<br><em>同じ頭で考える。</em></h2>
        <p>
          <strong>コードが書けるだけでは足りない。戦略が語れるだけでも足りない。</strong>
          両方を同じ頭で考えられて、はじめて事業に効く意思決定ができる。
          そう信じて、フリーランスとして活動しています。
        </p>
        <p>
          得意なのは、HP制作・Webシステム開発・業務効率化の3領域。
          コーポレートサイトから EC、マッチングアプリ、自動見積システムまで、
          ご依頼の幅は広いですが、すべて「事業を前に進める」という一点に絞って取り組んでいます。
        </p>
        <p>
          AIを開発の中核に据えることで、これまでトレードオフだった「品質」と「スピード」を両立。
          設計レビューやドキュメント生成までAIで複線化し、要件変更にも柔軟に追従します。
        </p>

        <table class="profile-table">
          <tr>
            <th>屋号</th>
            <td>Liberaspace（リベラスペース）</td>
          </tr>
          <tr>
            <th>事業内容</th>
            <td>
              HP制作・リニューアル / Webシステム開発 / 業務効率化システム制作
              <span class="sub">関連: AI駆動開発・DX推進支援・SEO / GEO 改善</span>
            </td>
          </tr>
          <tr>
            <th>所在地</th>
            <td>北海道（リモート対応）</td>
          </tr>
          <tr>
            <th>対応エリア</th>
            <td>全国・海外（オンライン）</td>
          </tr>
          <tr>
            <th>稼働形態</th>
            <td>単発開発 / 月額顧問 / スポット相談</td>
          </tr>
          <tr>
            <th>連絡先</th>
            <td><a href="mailto:liberaspace3035@gmail.com" style="color: var(--accent);">liberaspace3035@gmail.com</a></td>
          </tr>
          <tr>
            <th>設立年</th>
            <td>2025</td>
          </tr>
        </table>
      </div>
    </div>
  </section>

  <!-- Timeline -->
  <section class="timeline-section">
    <div class="container">
      <div class="section-head">
        <div>
          <div class="eyebrow" style="margin-bottom: 20px;"><span class="dot"></span> Timeline</div>
          <h2 style="font-family: var(--font-jp); font-weight: 700; font-size: clamp(36px, 4vw, 56px); letter-spacing: -0.02em; line-height: 1.2;">これまでの<br><em style="font-style:normal;color:var(--accent);">歩み</em>。</h2>
        </div>
        <p class="lede">受託開発会社でのキャリアを経て、フリーランスへ。事業会社の中で得た「事業を伸ばす視点」を、開発に持ち込みます。</p>
      </div>

      <div class="tl-items">
        @foreach($timeline as $entry)
          <div class="tl-item">
            <span class="tl-year">{{ $entry->date }}</span>
            <div class="tl-content">
              <h4>{{ $entry->title }}</h4>
              @if($entry->description)<p>{{ $entry->description }}</p>@endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Skills -->
  <section class="skills-section">
    <div class="container">
      <div class="section-head">
        <div>
          <div class="eyebrow" style="margin-bottom: 20px;"><span class="dot"></span> Capabilities</div>
          <h2 style="font-family: var(--font-jp); font-weight: 700; font-size: clamp(36px, 4vw, 56px); letter-spacing: -0.02em; line-height: 1.2;">扱える、<br><em style="font-style:normal;color:var(--accent);">技術と道具</em>。</h2>
        </div>
        <p class="lede">設計・実装・運用・分析まで、幅広くカバーします。特に得意な領域は <strong style="color: var(--text);">Laravel / WordPress / AI駆動開発</strong> です。</p>
      </div>

      <div class="skill-grid">
        @foreach($skills as $category => $items)
          <div class="skill-col" @if($loop->index > 0) data-delay="{{ $loop->index }}" @endif>
            <h4>{{ $category }}</h4>
            <ul>
              @foreach($items as $skill)
                <li><span class="lvl"></span>{{ $skill->name }}</li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section class="contact-section" id="contact">
    <div class="contact-bg" aria-hidden="true">
      <div class="tech-grid"></div>
      <div class="tech-dots"></div>
      <div class="rings"><span></span><span></span><span></span></div>
    </div>
    <div class="container contact-grid">
      <div class="contact-info">
        <div class="eyebrow" style="margin-bottom: 28px;"><span class="dot"></span> Contact</div>
        <h2>一緒に、<br><em>勝てる事業</em>を<br>作りませんか。</h2>
        <p class="lead">
          要件が固まっていない段階のご相談、リニューアルの可否診断、AI活用の壁打ちなど、お気軽にどうぞ。
          まずは <strong style="color: var(--text);">30分の無料ヒアリング</strong> から、現状の課題と数字を整理しましょう。
        </p>
        <div class="contact-meta">
          <div class="contact-meta-item">
            <span class="k">Email</span>
            <span class="v"><a href="mailto:liberaspace3035@gmail.com">liberaspace3035@gmail.com</a></span>
          </div>
          <div class="contact-meta-item">
            <span class="k">Web</span>
            <span class="v">liberaspace.net</span>
          </div>
          <div class="contact-meta-item">
            <span class="k">Hours</span>
            <span class="v">平日 10:00 – 19:00（土日は要相談）</span>
          </div>
          <div class="contact-meta-item">
            <span class="k">Reply</span>
            <span class="v">原則 24時間以内</span>
          </div>
          <div class="contact-meta-item">
            <span class="k">First Step</span>
            <span class="v">30分の無料ヒアリングから</span>
          </div>
        </div>
      </div>

      @if(session('contact_ok'))
        <div class="contact-form" data-delay="1" style="text-align: center; padding: 60px 32px;">
          <div style="font-size: 48px; color: var(--accent); margin-bottom: 16px;">✓</div>
          <h3>送信ありがとうございました。</h3>
          <p class="form-sub" style="margin-top: 12px;">24時間以内にご返信します。</p>
        </div>
      @else
        <form class="contact-form" data-delay="1" method="POST" action="{{ route('contact.store') }}">
          @csrf
          <h3>無料ヒアリングのお申し込み</h3>
          <p class="form-sub">入力は2分ほどで完了します。24時間以内にご返信します。</p>

          <div class="form-row cols">
            <div class="form-row">
              <label>会社名 / 屋号</label>
              <input type="text" name="company" value="{{ old('company') }}" placeholder="株式会社サンプル" />
              @error('company')<span style="color:#b6543a;font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-row">
              <label>お名前 <span class="req">*</span></label>
              <input type="text" name="name" value="{{ old('name') }}" required placeholder="山田 太郎" />
              @error('name')<span style="color:#b6543a;font-size:12px;">{{ $message }}</span>@enderror
            </div>
          </div>

          <div class="form-row">
            <label>メールアドレス <span class="req">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com" />
            @error('email')<span style="color:#b6543a;font-size:12px;">{{ $message }}</span>@enderror
          </div>

          <div class="form-row">
            <label>ご相談内容 <span class="req">*</span></label>
            <textarea name="body" required placeholder="現状の課題や、やりたいこと、気になっていることなど、自由にご記入ください。">{{ old('body') }}</textarea>
            @error('body')<span style="color:#b6543a;font-size:12px;">{{ $message }}</span>@enderror
          </div>

          <button type="submit" class="btn btn-primary form-submit">送信する <span class="arrow">→</span></button>
        </form>
      @endif
    </div>
  </section>
@endsection

@push("scripts")
<script src="{{ asset("assets/tech-3d.js") }}"></script>
@endpush
