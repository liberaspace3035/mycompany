<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($entries as $e)
  <url>
    <loc>{{ $e['loc'] }}</loc>
    @if(!empty($e['lastmod']))<lastmod>{{ $e['lastmod'] }}</lastmod>@endif
    <changefreq>{{ $e['changefreq'] }}</changefreq>
    <priority>{{ $e['priority'] }}</priority>
  </url>
@endforeach
</urlset>
