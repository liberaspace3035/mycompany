<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col">
        <a href="{{ url('/') }}" class="brand" style="margin-bottom: 20px;">
          <span class="brand-mark"></span>
          {{ $settings->site_name ?? 'Liberaspace' }}
        </a>
        <p style="font-size: 13px; color: var(--text-dim); line-height: 1.8; max-width: 32ch;">
          {{ $settings->footer_tagline ?? '開発・分析・効率化のプロフェッショナル。事業を前に進める「資産」を、一人称で構築します。' }}
        </p>
      </div>
      @foreach($settings->footer_columns ?? [] as $col)
        <div class="footer-col">
          <h4>{{ $col['heading'] }}</h4>
          @foreach($col['links'] ?? [] as $link)
            <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
          @endforeach
        </div>
      @endforeach
    </div>
    <div class="footer-bottom">
      <span>© {{ date('Y') }} {{ strtoupper($settings->site_name ?? 'LIBERASPACE') }} — ALL RIGHTS RESERVED</span>
      <span>BUILT WITH AI · {{ date('Y.m') }}</span>
    </div>
  </div>
</footer>
