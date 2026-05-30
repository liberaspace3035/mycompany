<nav class="nav">
  <div class="nav-inner">
    <a href="{{ url('/') }}" class="brand">
      <span class="brand-mark"></span>
      {{ $settings->site_name ?? 'Liberaspace' }}
    </a>
    <div class="nav-links">
      <a class="nav-link {{ ($active ?? '') === 'home' ? 'active' : '' }}" href="{{ url('/') }}">Top</a>
      @foreach($settings->nav_items ?? [] as $item)
        @php
          $slug = ltrim($item['url'] ?? '/', '/') ?: 'home';
        @endphp
        <a class="nav-link {{ ($active ?? '') === $slug ? 'active' : '' }}" href="{{ $item['url'] }}">{{ $item['label'] }}</a>
      @endforeach
    </div>
    <a href="/company#contact" class="nav-cta magnet">
      無料相談 <span aria-hidden="true">→</span>
    </a>
  </div>
</nav>
