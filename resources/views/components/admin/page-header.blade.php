@props([
    'title' => '',
    'crumbs' => null,    // string like 'Content / Posts' or null
    'sub'   => null,
])

<header class="page-header">
  <div>
    @if($crumbs)
      <div class="page-header__crumbs">{{ $crumbs }}</div>
    @endif
    <h1 class="page-header__title">{{ $title }}</h1>
    @if($sub)
      <p class="page-header__sub">{{ $sub }}</p>
    @endif
  </div>
  @if($actions ?? false)
    <div class="page-header__actions">{{ $actions }}</div>
  @endif
</header>
