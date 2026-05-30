@php
    $gaId = config('services.google_analytics.id');
@endphp

@if($gaId)
  {{-- Google tag (gtag.js) — GA4 --}}
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', @json($gaId));
  </script>
@endif
