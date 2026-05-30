@extends('layouts.site')

@section('content')
<main style="padding: 160px 0 120px;">
  <article class="container" style="max-width: 720px;">
    <div class="eyebrow">{{ $post->published_at?->format('Y.m.d') }} · {{ $post->category?->name }}</div>
    <h1 style="font-size: clamp(28px, 4.5vw, 48px); margin: 16px 0 32px; line-height: 1.3;">{{ $post->title }}</h1>
    @if($post->summary)
      <p style="color: var(--text-dim); border-left: 2px solid var(--accent); padding-left: 16px; margin-bottom: 48px;">{{ $post->summary }}</p>
    @endif
    <div style="line-height: 1.9; font-size: 16px;">
      {!! $post->body_html !!}
    </div>
  </article>
</main>
@endsection
