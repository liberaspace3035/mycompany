@extends('layouts.site')

@section('content')
<main style="padding: 160px 0 120px;">
  <article class="container" style="max-width: 880px;">
    <div class="eyebrow">/ {{ strtoupper($work->category) }} · {{ $work->year }}</div>
    <h1 style="font-size: clamp(32px, 5vw, 56px); margin: 16px 0 32px;">{{ $work->title }}</h1>
    <p style="color: var(--text-dim); max-width: 60ch;">{{ $work->summary }}</p>
    @if($work->tags)
      <div style="margin-top: 32px; display: flex; gap: 8px; flex-wrap: wrap;">
        @foreach($work->tags as $tag)
          <span class="chip">{{ $tag }}</span>
        @endforeach
      </div>
    @endif
    @if($work->image)
      <img src="{{ Str::startsWith($work->image, 'http') ? $work->image : asset('uploads/' . $work->image) }}" alt="{{ $work->title }}" style="width: 100%; margin-top: 48px; border: 1px solid var(--border);">
    @endif
    @if($work->url)
      <a href="{{ $work->url }}" target="_blank" rel="noopener" class="btn btn-ghost" style="margin-top: 48px; display: inline-flex;">プロジェクトを見る <span class="arrow">→</span></a>
    @endif
  </article>
</main>
@endsection
