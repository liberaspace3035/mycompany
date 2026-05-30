@extends("layouts.site")

@push("head")
  <style>
    .svc-deep {
      padding: 120px 0;
      border-bottom: 1px solid var(--border);
    }
    .svc-deep:nth-child(even) { background: var(--bg-2); }
    .svc-deep-inner {
      display: grid;
      grid-template-columns: 0.9fr 1.3fr;
      gap: 80px;
      align-items: start;
    }
    .svc-meta {
      position: sticky;
      top: calc(var(--nav-h) + 40px);
    }
    .svc-num-big {
      font-family: var(--font-en);
      font-size: 120px;
      font-weight: 500;
      letter-spacing: -0.04em;
      line-height: 1;
      color: var(--text);
      margin-bottom: 24px;
    }
    .svc-num-big .slash { color: var(--accent); }
    .svc-tag-line {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 32px;
    }
    .svc-deep h2 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: clamp(36px, 4vw, 56px);
      letter-spacing: -0.02em;
      line-height: 1.2;
      margin-bottom: 24px;
    }
    .svc-deep .lead {
      color: var(--text-dim);
      font-size: 17px;
      line-height: 1.9;
      margin-bottom: 36px;
    }
    .svc-deep .outcome {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      padding: 10px 18px;
      border: 1px solid var(--accent);
      border-radius: 999px;
      color: var(--accent);
      font-family: var(--font-mono);
      font-size: 12px;
      letter-spacing: 0.1em;
    }
    .sub-items {
      display: grid;
      gap: 24px;
    }
    .sub-item {
      padding: 32px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      transition: all 0.3s ease;
    }
    .sub-item:hover { border-color: var(--border-bright); }
    .sub-item-head {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 20px;
      gap: 16px;
    }
    .sub-letter {
      font-family: var(--font-en);
      font-weight: 600;
      font-size: 14px;
      color: var(--accent-ink);
      background: var(--accent);
      width: 28px; height: 28px;
      display: grid; place-items: center;
      border-radius: 6px;
      flex-shrink: 0;
    }
    .sub-item h3 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 22px;
      letter-spacing: -0.01em;
      flex: 1;
    }
    .sub-item h3 .en {
      display: block;
      font-family: var(--font-en);
      font-size: 12px;
      font-weight: 500;
      color: var(--text-muted);
      letter-spacing: 0.16em;
      text-transform: uppercase;
      margin-bottom: 8px;
    }
    .sub-item p { color: var(--text-dim); font-size: 14.5px; line-height: 1.85; margin-bottom: 16px; }
    .sub-tags { display: flex; gap: 6px; flex-wrap: wrap; }

    .price-section {
      padding: 140px 0;
      background: var(--bg-2);
      border-top: 1px solid var(--border);
    }
    .price-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 64px;
    }
    .price-card {
      padding: 36px 32px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      display: flex;
      flex-direction: column;
      gap: 16px;
      min-height: 360px;
    }
    .price-card.featured {
      border-color: var(--accent);
      background: var(--surface);
      position: relative;
    }
    .price-card.featured::before {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 3px;
      background: var(--accent);
      border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }
    .price-card .kind {
      font-family: var(--font-mono);
      font-size: 11px;
      letter-spacing: 0.18em;
      color: var(--text-muted);
      text-transform: uppercase;
    }
    .price-card .featured-tag {
      color: var(--accent);
    }
    .price-card h3 {
      font-family: var(--font-jp);
      font-weight: 700;
      font-size: 26px;
      letter-spacing: -0.01em;
    }
    .price-card .price {
      font-family: var(--font-en);
      font-size: 40px;
      font-weight: 500;
      letter-spacing: -0.02em;
      line-height: 1;
      margin: 8px 0;
    }
    .price-card .price .unit { font-size: 14px; color: var(--text-dim); margin-left: 4px; }
    .price-card .price .from { font-size: 13px; color: var(--text-muted); display: block; margin-bottom: 4px; }
    .price-card ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
    .price-card li { font-size: 14px; color: var(--text-dim); padding-left: 20px; position: relative; }
    .price-card li::before {
      content: '';
      position: absolute;
      left: 0; top: 8px;
      width: 12px; height: 1px; background: var(--accent);
    }
    .price-card .btn { margin-top: auto; }

    @media (max-width: 1080px) {
      .svc-deep-inner { grid-template-columns: 1fr; gap: 48px; }
      .svc-meta { position: static; }
      .price-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 720px) {
      .svc-deep { padding: 80px 0; }
      .svc-deep h2 { font-size: clamp(28px, 6.5vw, 38px); }
      .svc-num-big { font-size: 80px; margin-bottom: 16px; }
      .sub-item { padding: 24px 22px; }
      .sub-item h3 { font-size: 19px; }
      .sub-item p { font-size: 14px; }
      .price-section { padding: 80px 0; }
      .price-card { padding: 28px 24px; }
      .price-card .price { font-size: 32px; }
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
      <span><strong>{{ strtoupper($page->name) }}</strong> &nbsp;/&nbsp; {{ $page->hero_eyebrow ?? 'DECK' }}</span>
      <span>SYS // {{ $services->count() }} DOMAINS</span>
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

  <!-- Service 01: HP -->
  <section class="svc-deep" id="web">
    <div class="container svc-deep-inner">
      <div class="svc-meta">
        <div class="svc-tag-line">PART 01 — WEB &amp; SEO</div>
        <div class="svc-num-big">01<span class="slash">.</span></div>
        <h2>HP制作・<br>リニューアル</h2>
        <p class="lead">
          単にデザインを整えるだけでなく、ビジネスの成果（コンバージョン）を逆算したサイト構築を行います。
        </p>
        <span class="outcome">→ 成果につながるサイト</span>
      </div>
      <div class="sub-items">
        <div class="sub-item">
          <div class="sub-item-head">
            <span class="sub-letter">A</span>
            <h3>
              <span class="en">WordPress / Custom Theme</span>
              HPリニューアル・新規作成
            </h3>
          </div>
          <p>
            WordPressを用いた完全オリジナルテーマの制作。既存テンプレートでは不可能な、
            高速で自由度の高いサイトを実現。ブランドを表現し、検索でも勝てるオリジナルサイトを作ります。
          </p>
          <div class="sub-tags">
            <span class="chip chip-accent">WordPress</span>
            <span class="chip">Custom Theme</span>
            <span class="chip">高速化</span>
            <span class="chip">レスポンシブ</span>
          </div>
        </div>
        <div class="sub-item" data-delay="1">
          <div class="sub-item-head">
            <span class="sub-letter">B</span>
            <h3>
              <span class="en">SEO / SGO</span>
              検索流入の最適化
            </h3>
          </div>
          <p>
            検索エンジン（SEO）と生成AI検索（SGO）の両面からアプローチし、ターゲット層に
            確実に届く導線を設計。狙う顧客を、確実にサイトへ誘導する集客構造をつくります。
          </p>
          <div class="sub-tags">
            <span class="chip chip-accent">SEO</span>
            <span class="chip">SGO / GEO</span>
            <span class="chip">コンテンツ設計</span>
            <span class="chip">内部最適化</span>
          </div>
        </div>
        <div class="sub-item" data-delay="2">
          <div class="sub-item-head">
            <span class="sub-letter">C</span>
            <h3>
              <span class="en">GA4 / Search Console</span>
              データに基づく改善提案
            </h3>
          </div>
          <p>
            GA4やSearch Consoleを活用し、現状のHPの弱点を数値で特定。根拠のあるリニューアル案を提示します。
            感覚ではなく数字で、勝率を高める改善案を提案します。
          </p>
          <div class="sub-tags">
            <span class="chip chip-accent">GA4</span>
            <span class="chip">Search Console</span>
            <span class="chip">CVR改善</span>
            <span class="chip">A/Bテスト</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Service 02: Development -->
  <section class="svc-deep" id="dev">
    <div class="container svc-deep-inner">
      <div class="svc-meta">
        <div class="svc-tag-line">PART 02 — GROWTH</div>
        <div class="svc-num-big">02<span class="slash">.</span></div>
        <h2>Webシステム<br>開発</h2>
        <p class="lead">
          HPに「稼ぐ力」や「独自のサービス」を組み込み、付加価値を高めます。
          複雑なロジックを必要とするプラットフォームを、AI駆動で構築します。
        </p>
        <span class="outcome">→ 収益化 × 機能拡張</span>
      </div>
      <div class="sub-items">
        <div class="sub-item">
          <div class="sub-item-head">
            <span class="sub-letter">A</span>
            <h3>
              <span class="en">Commerce / Stripe</span>
              ECサイト構築
            </h3>
          </div>
          <p>
            外部決済システムと連携した、安全でスムーズな購買体験を提供するオンラインストアの構築。
            サブスクリプションや一括決済、定期購入など、商品形態に応じた最適な仕組みを設計します。
          </p>
          <div class="sub-tags">
            <span class="chip chip-accent">Stripe</span>
            <span class="chip">外部決済API</span>
            <span class="chip">サブスクリプション</span>
            <span class="chip">在庫管理</span>
          </div>
        </div>
        <div class="sub-item" data-delay="1">
          <div class="sub-item-head">
            <span class="sub-letter">B</span>
            <h3>
              <span class="en">Platform / Laravel</span>
              Webアプリケーション制作
            </h3>
          </div>
          <p>
            マッチングアプリや独自のサービスサイトなど、複雑なロジックを必要とするプラットフォームの開発。
            スケールに耐える設計と、運用しやすい管理画面の両方を提供します。
          </p>
          <div class="sub-tags">
            <span class="chip chip-accent">Laravel</span>
            <span class="chip">AWS</span>
            <span class="chip">Vue / React</span>
            <span class="chip">API設計</span>
          </div>
        </div>
        <div class="sub-item" data-delay="2">
          <div class="sub-item-head">
            <span class="sub-letter">C</span>
            <h3>
              <span class="en">AI Native Development</span>
              AI活用開発
            </h3>
          </div>
          <p>
            最新のAI技術を開発プロセスに導入し、高機能なシステムを圧倒的なスピード感で提供します。
            設計レビューやドキュメント生成までAIで複線化することで、品質と速度を両立します。
          </p>
          <div class="sub-tags">
            <span class="chip chip-accent">Claude Code</span>
            <span class="chip">Cursor</span>
            <span class="chip">Gemini</span>
            <span class="chip">AI Agent</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Service 03: Operations -->
  <section class="svc-deep" id="ops">
    <div class="container svc-deep-inner">
      <div class="svc-meta">
        <div class="svc-tag-line">PART 03 — OPERATIONS</div>
        <div class="svc-num-big">03<span class="slash">.</span></div>
        <h2>業務効率化<br>システム</h2>
        <p class="lead">
          HPや管理画面を通じて、クライアントのバックオフィス業務を劇的に軽くします。
          仕組み化で、利益率を継続的に底上げします。
        </p>
        <span class="outcome">→ 利益率の向上</span>
      </div>
      <div class="sub-items">
        <div class="sub-item">
          <div class="sub-item-head">
            <span class="sub-letter">i</span>
            <h3>
              <span class="en">Quotation &amp; Management</span>
              自動見積・管理システム制作
            </h3>
          </div>
          <p>
            手作業で行っていた見積りやデータ管理をシステム化し、ヒューマンエラーの削減と
            時間創出に貢献します。営業現場で実際に使い続けてもらえる、シンプルなUIを設計します。
          </p>
          <div class="sub-tags">
            <span class="chip chip-accent">自動見積</span>
            <span class="chip">管理画面</span>
            <span class="chip">CSV連携</span>
            <span class="chip">権限管理</span>
          </div>
        </div>
        <div class="sub-item" data-delay="1">
          <div class="sub-item-head">
            <span class="sub-letter">ii</span>
            <h3>
              <span class="en">DX Initiative</span>
              DX推進支援
            </h3>
          </div>
          <p>
            IT技術を駆使して「現場の不便」を「自動化された資産」へと変換し、利益率を継続的に底上げします。
            ヒアリングから業務フロー設計、ツール選定、実装までを一気通貫でサポートします。
          </p>
          <div class="sub-tags">
            <span class="chip chip-accent">業務分析</span>
            <span class="chip">自動化</span>
            <span class="chip">SaaS連携</span>
            <span class="chip">運用設計</span>
          </div>
        </div>
        <div class="sub-item" data-delay="2">
          <div class="sub-item-head">
            <span class="sub-letter">iii</span>
            <h3>
              <span class="en">Expected Outcome</span>
              数字で見る効果
            </h3>
          </div>
          <p>
            手作業の削減とヒューマンエラー低減で、利益率を底上げします。
            人的コスト（手作業 / 二重入力 / 確認工数）を下げ、処理スピードと利益率を上げます。
            売上はそのまま、利益が残ります。
          </p>
          <div class="sub-tags">
            <span class="chip">↓ 人的コスト</span>
            <span class="chip">↑ 処理スピード</span>
            <span class="chip chip-accent">↑ 利益率</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section class="price-section">
    <div class="container">
      <div class="section-head">
        <div>
          <div class="eyebrow" style="margin-bottom: 20px;"><span class="dot"></span> Engagement</div>
          <h2 style="font-family: var(--font-jp); font-weight: 700;">関わり方は、<br><em style="font-style:normal;color:var(--accent);">3つ</em>から選べます。</h2>
        </div>
        <p class="lede">
          単発のプロジェクトから、月額顧問、スポット相談まで、課題と予算に合わせて柔軟に設計します。
          まずは無料ヒアリングで、最適な進め方を一緒に決めましょう。
        </p>
      </div>

      <div class="price-grid">
        <div class="price-card">
          <span class="kind">Spot</span>
          <h3>スポット相談</h3>
          <span class="price"><span class="from">FROM</span>¥0<span class="unit"> / 30min</span></span>
          <ul>
            <li>30分の無料ヒアリング</li>
            <li>現状の課題整理</li>
            <li>リニューアル可否診断</li>
            <li>AI活用の壁打ち</li>
          </ul>
          <a href="/company#contact" class="btn btn-ghost">予約する <span class="arrow">→</span></a>
        </div>
        <div class="price-card featured" data-delay="1">
          <span class="kind featured-tag">★ Project / Most Popular</span>
          <h3>単発開発</h3>
          <span class="price"><span class="from">FROM</span>¥500K<span class="unit"> 〜</span></span>
          <ul>
            <li>要件定義から運用まで一貫対応</li>
            <li>AI駆動の高速実装</li>
            <li>納品後3ヶ月の改善伴走</li>
            <li>GA4等の計測整備</li>
          </ul>
          <a href="/company#contact" class="btn btn-primary">相談する <span class="arrow">→</span></a>
        </div>
        <div class="price-card" data-delay="2">
          <span class="kind">Retainer</span>
          <h3>月額顧問</h3>
          <span class="price"><span class="from">FROM</span>¥150K<span class="unit"> / month</span></span>
          <ul>
            <li>継続的な分析・改善</li>
            <li>定例ミーティング</li>
            <li>小規模開発・更新</li>
            <li>技術相談・壁打ち</li>
          </ul>
          <a href="/company#contact" class="btn btn-ghost">相談する <span class="arrow">→</span></a>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA strip -->
  <section style="padding: 100px 0; text-align: center;">
    <div class="container">
      <h2 style="font-family: var(--font-jp); font-weight: 700; max-width: 24ch; margin: 0 auto;">
        どのサービスが合うか、<br>30分で整理しませんか。
      </h2>
      <div style="margin-top: 36px;">
        <a href="/company#contact" class="btn btn-primary">無料ヒアリングへ <span class="arrow">→</span></a>
      </div>
    </div>
  </section>

@endsection

@push("scripts")
<script src="{{ asset("assets/tech-3d.js") }}"></script>
@endpush
