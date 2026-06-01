<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  @include('partials.seo')
  <link rel="stylesheet" href="{{ asset('assets/site.css') }}?v={{ @filemtime(public_path('assets/site.css')) ?: '1' }}" />
  @include('partials.analytics')
  @stack('head')
</head>
<body>

  @include('partials.loader')

  @include('partials.nav', ['active' => $active ?? null])

  {{ $slot ?? '' }}
  @yield('content')

  @include('partials.footer')

  <script src="{{ asset('assets/site.js') }}?v={{ @filemtime(public_path('assets/site.js')) ?: '1' }}"></script>
  <script src="https://unpkg.com/three@0.160.0/build/three.min.js"></script>
  @stack('scripts')
</body>
</html>
