@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
  @php
      $dow = ['日','月','火','水','木','金','土'][now()->dayOfWeek];
      $greeting = 'こんにちは、' . (auth()->user()?->name ?? 'Admin') . ' さん';
      $subline = now()->format('Y年n月j日') . '（' . $dow . '）— 公開サイトと管理状況の概要';
  @endphp
  <x-admin.page-header
    :title="$greeting"
    crumbs="ダッシュボード"
    :sub="$subline"
  />

  <div class="stat-grid">
    <a href="{{ route('admin.works.index') }}" class="stat-card" style="text-decoration: none; color: inherit;">
      <div class="stat-card__head">
        <span class="stat-card__label">Works</span>
        <span class="stat-card__icon"><x-admin.icon name="briefcase" /></span>
      </div>
      <div class="stat-card__value">{{ $works_count }}<span class="stat-card__unit">件</span></div>
      <div class="stat-card__delta">うち featured: <strong style="color: var(--admin-text); font-weight: 600;">{{ $featured_count }}</strong></div>
    </a>

    <a href="{{ route('admin.posts.index') }}" class="stat-card" style="text-decoration: none; color: inherit;">
      <div class="stat-card__head">
        <span class="stat-card__label">Posts</span>
        <span class="stat-card__icon"><x-admin.icon name="book-open" /></span>
      </div>
      <div class="stat-card__value">{{ $posts_count }}<span class="stat-card__unit">件</span></div>
      <div class="stat-card__delta">ブログ記事の合計</div>
    </a>

    <a href="{{ route('admin.inbox.index') }}" class="stat-card" style="text-decoration: none; color: inherit;">
      <div class="stat-card__head">
        <span class="stat-card__label">Inbox</span>
        <span class="stat-card__icon" style="background: {{ $unread_count > 0 ? 'var(--admin-danger-soft)' : 'var(--admin-accent-soft)' }}; color: {{ $unread_count > 0 ? 'var(--admin-danger)' : 'var(--admin-accent)' }};">
          <x-admin.icon name="inbox" />
        </span>
      </div>
      <div class="stat-card__value">{{ $unread_count }}<span class="stat-card__unit">未読</span></div>
      <div class="stat-card__delta">@if($unread_count > 0)未対応の問い合わせがあります@else新着なし — 全て既読です@endif</div>
    </a>

    <a href="{{ url('/') }}" target="_blank" class="stat-card" style="text-decoration: none; color: inherit;">
      <div class="stat-card__head">
        <span class="stat-card__label">公開サイト</span>
        <span class="stat-card__icon"><x-admin.icon name="external-link" /></span>
      </div>
      <div class="stat-card__value" style="font-size: 22px;">View</div>
      <div class="stat-card__delta">公開トップを新タブで開く</div>
    </a>
  </div>

  <div style="display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: 16px; align-items: start;">

    <div class="admin-card">
      <div class="admin-card__head">
        <div>
          <h2>最近の問い合わせ</h2>
          <div class="admin-card__sub">公開フォームから届いたメッセージ・最新5件</div>
        </div>
        <a href="{{ route('admin.inbox.index') }}" class="btn btn-sm">すべて表示<x-admin.icon name="arrow-right" /></a>
      </div>
      <div class="admin-card__body admin-card__body--flush">
        @if($recent_inbox->isEmpty())
          <div class="empty">
            <div class="empty__icon"><x-admin.icon name="inbox" /></div>
            <div class="empty__title">まだ問い合わせはありません</div>
            <div class="empty__sub">フォーム送信があると、ここに表示されます。</div>
          </div>
        @else
          <table class="admin-table">
            <thead>
              <tr>
                <th style="width: 130px;">日時</th>
                <th style="width: 160px;">名前</th>
                <th>本文</th>
                <th style="width: 64px;"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($recent_inbox as $i)
                <tr wire:key="recent-{{ $i->id }}">
                  <td class="col-mono">{{ $i->created_at?->format('m-d H:i') }}</td>
                  <td>
                    <div class="row-strong">{{ $i->name }}</div>
                    <div class="row-sub">{{ $i->company ?: $i->email }}</div>
                  </td>
                  <td style="color: var(--admin-text-dim); font-size: 13px;">{{ \Illuminate\Support\Str::limit($i->body, 70) }}</td>
                  <td><a href="{{ route('admin.inbox.show', $i) }}" class="btn btn-sm btn-icon"><x-admin.icon name="arrow-right" /></a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head"><h2>よく使う</h2></div>
      <div class="admin-card__body" style="display: grid; gap: 8px;">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-row--start" style="justify-content: flex-start; width: 100%;">
          <x-admin.icon name="plus" />新しいブログ記事
        </a>
        <a href="{{ route('admin.works.create') }}" class="btn" style="justify-content: flex-start; width: 100%;">
          <x-admin.icon name="plus" />新しい実績を追加
        </a>
        <a href="{{ route('admin.pages.index') }}" class="btn" style="justify-content: flex-start; width: 100%;">
          <x-admin.icon name="file-text" />ページのHeroを編集
        </a>
        <a href="{{ route('admin.settings.edit') }}" class="btn" style="justify-content: flex-start; width: 100%;">
          <x-admin.icon name="settings" />サイト設定
        </a>
      </div>
    </div>
  </div>
@endsection
