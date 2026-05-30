<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>{{ $title ?? 'Admin' }} — {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/admin.css') }}?v={{ filemtime(public_path('assets/admin.css')) }}" />
  <link rel="icon" href="{{ asset('favicon.ico') }}" />
  @livewireStyles
  @stack('head')
</head>
<body>
@php
  $unreadCount    = \App\Models\ContactSubmission::where('read', false)->count();
  $userName       = auth()->user()?->name ?? 'Admin';
  $userInitials   = collect(preg_split('/\s+/', $userName))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('');
  $envLabel       = strtoupper(config('app.env'));
  $appVersion     = '0.1';
  $crumbs         = \App\Support\AdminBreadcrumbs::for(request()->route()?->getName());
@endphp

<div class="admin-shell">
  {{-- ============ SIDEBAR ============ --}}
  <aside class="admin-side">
    <a href="{{ route('admin.dashboard') }}" class="admin-brand">
      <span class="admin-brand__mark">L</span>
      <span>
        <span class="admin-brand__title">Liberaspace</span>
        <span class="admin-brand__env">{{ $envLabel }}</span>
      </span>
    </a>

    <nav class="admin-nav">
      <a href="{{ route('admin.dashboard') }}" class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
        <x-admin.icon name="layout-dashboard" />
        <span class="admin-nav__label">ダッシュボード</span>
      </a>

      <div class="admin-nav__group">Content</div>
      <a href="{{ route('admin.pages.index') }}" class="admin-nav__link {{ request()->routeIs('admin.pages.*') || request()->routeIs('admin.sections.*') ? 'is-active' : '' }}">
        <x-admin.icon name="file-text" />
        <span class="admin-nav__label">ページ</span>
      </a>
      <a href="{{ route('admin.works.index') }}" class="admin-nav__link {{ request()->routeIs('admin.works.*') ? 'is-active' : '' }}">
        <x-admin.icon name="briefcase" />
        <span class="admin-nav__label">実績</span>
      </a>
      <a href="{{ route('admin.posts.index') }}" class="admin-nav__link {{ request()->routeIs('admin.posts.*') ? 'is-active' : '' }}">
        <x-admin.icon name="book-open" />
        <span class="admin-nav__label">ブログ</span>
      </a>
      <a href="{{ route('admin.services.index') }}" class="admin-nav__link {{ request()->routeIs('admin.services.*') ? 'is-active' : '' }}">
        <x-admin.icon name="package" />
        <span class="admin-nav__label">サービス</span>
      </a>
      <a href="{{ route('admin.timeline.index') }}" class="admin-nav__link {{ request()->routeIs('admin.timeline.*') ? 'is-active' : '' }}">
        <x-admin.icon name="git-branch" />
        <span class="admin-nav__label">沿革</span>
      </a>
      <a href="{{ route('admin.skills.index') }}" class="admin-nav__link {{ request()->routeIs('admin.skills.*') ? 'is-active' : '' }}">
        <x-admin.icon name="award" />
        <span class="admin-nav__label">スキル</span>
      </a>

      <div class="admin-nav__group">Inbox</div>
      <a href="{{ route('admin.inbox.index') }}" class="admin-nav__link {{ request()->routeIs('admin.inbox.*') ? 'is-active' : '' }}">
        <x-admin.icon name="inbox" />
        <span class="admin-nav__label">問い合わせ</span>
        @if($unreadCount > 0)
          <span class="admin-nav__count">{{ $unreadCount }}</span>
        @endif
      </a>

      <div class="admin-nav__group">Settings</div>
      <a href="{{ route('admin.settings.edit') }}" class="admin-nav__link {{ request()->routeIs('admin.settings.*') ? 'is-active' : '' }}">
        <x-admin.icon name="settings" />
        <span class="admin-nav__label">サイト設定</span>
      </a>
    </nav>

    <div class="admin-side__foot">
      <a href="{{ url('/') }}" target="_blank" rel="noopener">
        <x-admin.icon name="external-link" />
        <span>公開サイトを開く</span>
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">
          <x-admin.icon name="log-out" />
          <span>ログアウト</span>
        </button>
      </form>
      <div class="admin-side__version">v{{ $appVersion }} · {{ now()->format('Y') }}</div>
    </div>
  </aside>

  {{-- ============ MAIN ============ --}}
  <div class="admin-main">

    {{-- Topbar --}}
    <header class="admin-topbar">
      <nav class="admin-breadcrumb" aria-label="breadcrumb">
        <a href="{{ route('admin.dashboard') }}" aria-label="ダッシュボード">
          <x-admin.icon name="home" />
        </a>
        @foreach($crumbs as $i => $crumb)
          <span class="sep">/</span>
          @if($crumb['url'] ?? null)
            <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
          @else
            <span class="current">{{ $crumb['label'] }}</span>
          @endif
        @endforeach
      </nav>
      <div class="admin-topbar__right">
        <button type="button" class="admin-search" aria-label="検索">
          <x-admin.icon name="search" />
          <span>検索…</span>
          <span class="admin-search__hint kbd">⌘ K</span>
        </button>
        <a href="{{ route('admin.inbox.index') }}" class="admin-iconbtn" aria-label="問い合わせ">
          <x-admin.icon name="bell" />
          @if($unreadCount > 0)
            <span class="admin-iconbtn__dot" aria-hidden="true"></span>
          @endif
        </a>
        <button type="button" class="admin-user" aria-label="ユーザーメニュー">
          <span class="admin-user__avatar">{{ strtoupper($userInitials) }}</span>
          <span class="admin-user__name">{{ $userName }}</span>
          <x-admin.icon name="chevron-down" />
        </button>
      </div>
    </header>

    {{-- Page content --}}
    <main class="admin-main__inner">
      @if (session('status'))
        <div class="flash">
          <x-admin.icon name="check" />
          <span>{{ session('status') }}</span>
        </div>
      @endif
      @yield('content')
      {{ $slot ?? '' }}
    </main>
  </div>
</div>

@livewireScripts
@stack('scripts')
</body>
</html>
