@php
    // $seo が渡されなかった場面の安全網
    $seo = $seo ?? \App\Support\Seo::forDefault();
    $siteName = \App\Support\Seo::siteName();
    $jsonLd = json_encode(
        ['@context' => 'https://schema.org', '@graph' => $seo->structuredDataGraph()],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
    );
@endphp

<title>{{ $seo->title }}</title>
<meta name="description" content="{{ $seo->description }}">
@if($seo->keywords)
    <meta name="keywords" content="{{ $seo->keywords }}">
@endif
<meta name="robots" content="{{ $seo->robots }}">
<link rel="canonical" href="{{ $seo->canonical }}">

{{-- Open Graph --}}
<meta property="og:type"        content="{{ $seo->ogType }}">
<meta property="og:title"       content="{{ $seo->title }}">
<meta property="og:description" content="{{ $seo->description }}">
<meta property="og:url"         content="{{ $seo->canonical }}">
<meta property="og:image"       content="{{ $seo->ogImage }}">
<meta property="og:site_name"   content="{{ $siteName }}">
<meta property="og:locale"      content="ja_JP">
@if($seo->publishedAt)
    <meta property="article:published_time" content="{{ $seo->publishedAt }}">
@endif
@if($seo->modifiedAt)
    <meta property="article:modified_time" content="{{ $seo->modifiedAt }}">
@endif

{{-- Twitter Card --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $seo->title }}">
<meta name="twitter:description" content="{{ $seo->description }}">
<meta name="twitter:image"       content="{{ $seo->ogImage }}">

{{-- Icons / theme --}}
<link rel="icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<meta name="theme-color" content="#E8E8E2">

{{-- JSON-LD (Schema.org) --}}
<script type="application/ld+json">
{!! $jsonLd !!}
</script>
