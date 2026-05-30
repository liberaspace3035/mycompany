<div>
  <x-admin.page-header title="ブログ記事" crumbs="コンテンツ / ブログ">
    <x-slot:actions>
      <a href="{{ route('admin.posts.create') }}" class="btn btn-accent">
        <x-admin.icon name="plus" />新規追加
      </a>
    </x-slot:actions>
  </x-admin.page-header>

  <div class="admin-card" style="margin-bottom: 16px;">
    <div class="admin-card__body">
      <div class="form-grid-2">
        <div class="field" style="margin: 0;">
          <label>タイトル検索</label>
          <input type="text" wire:model.live.debounce.300ms="search" placeholder="例：Claude">
        </div>
        <div class="field" style="margin: 0;">
          <label>状態</label>
          <select wire:model.live="state">
            <option value="">すべて</option>
            <option value="published">公開済</option>
            <option value="draft">下書き</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="admin-card">
    <div class="admin-card__body admin-card__body--flush">
      @if($posts->isEmpty())
        <div class="empty">
          <div class="empty__icon"><x-admin.icon name="book-open" /></div>
          <div class="empty__title">該当する記事がありません</div>
          <div class="empty__sub">条件を変えるか、新規追加から作成してください。</div>
          <a href="{{ route('admin.posts.create') }}" class="btn btn-accent"><x-admin.icon name="plus" />新規追加</a>
        </div>
      @else
        <table class="admin-table">
          <thead>
            <tr>
              <th>タイトル</th>
              <th style="width: 140px;">カテゴリ</th>
              <th style="width: 160px;">状態</th>
              <th style="width: 110px;">Featured</th>
              <th style="width: 160px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($posts as $post)
              <tr wire:key="post-{{ $post->id }}">
                <td>
                  <div class="row-strong">{{ $post->title }}</div>
                  <div class="row-sub">{{ \Illuminate\Support\Str::limit($post->summary, 100) }}</div>
                </td>
                <td>
                  @if($post->category)<span class="chip">{{ $post->category->name }}</span>@endif
                </td>
                <td>
                  @if($post->published_at)
                    <span class="badge badge--published">{{ $post->published_at->format('Y-m-d') }}</span>
                  @else
                    <span class="badge badge--draft">下書き</span>
                  @endif
                </td>
                <td>
                  <button type="button" wire:click="toggleFeatured({{ $post->id }})"
                          class="toggle-btn {{ $post->featured ? 'toggle-btn--on' : '' }}">
                    {{ $post->featured ? 'ON' : 'OFF' }}
                  </button>
                </td>
                <td>
                  <div class="actions">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm"><x-admin.icon name="pencil" />編集</a>
                    <button type="button" class="btn btn-sm btn-danger"
                            wire:click="delete({{ $post->id }})"
                            wire:confirm="「{{ $post->title }}」を削除します。よろしいですか？"><x-admin.icon name="trash-2" /></button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div style="margin-top: 16px;">{{ $posts->links() }}</div>
</div>
