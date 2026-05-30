<div>
  <x-admin.page-header
    :title="$post ? '記事を編集' : '記事を作成'"
    :crumbs="'コンテンツ / ブログ / ' . ($post ? '編集' : '新規')">
    <x-slot:actions>
      <a href="{{ route('admin.posts.index') }}" class="btn"><x-admin.icon name="arrow-left" />一覧へ</a>
    </x-slot:actions>
  </x-admin.page-header>

  <form wire:submit.prevent="save">
    <div style="display: grid; grid-template-columns: minmax(0, 2.2fr) minmax(0, 1fr); gap: 16px; align-items: start;">

      {{-- Main column --}}
      <div class="admin-card">
        <div class="admin-card__head"><h2>本文</h2></div>
        <div class="admin-card__body">
          <div class="field">
            <label>タイトル <span class="field__required">*</span></label>
            <input type="text" wire:model.blur="title" autofocus>
            @error('title') <span class="field__error">{{ $message }}</span> @enderror
          </div>

          <div class="field">
            <label>スラッグ <span class="field__required">*</span></label>
            <input type="text" wire:model.blur="slug" placeholder="claude-code-real-projects">
            @error('slug') <span class="field__error">{{ $message }}</span> @enderror
          </div>

          <div class="field">
            <label>サマリ <span class="field__help">— 一覧で表示される短い紹介</span></label>
            <textarea rows="3" wire:model.blur="summary"></textarea>
            @error('summary') <span class="field__error">{{ $message }}</span> @enderror
          </div>

          <div class="field">
            <label>本文 (Markdown) <span class="field__required">*</span></label>
            <textarea rows="24" wire:model.blur="body_md" style="font-family: var(--admin-font-mono); font-size: 13px; line-height: 1.7;"></textarea>
            @error('body_md') <span class="field__error">{{ $message }}</span> @enderror
            <span class="field__help">GitHub Flavored Markdown 対応。コードブロック / リスト / 表 / リンクが使えます。</span>
          </div>
        </div>
      </div>

      {{-- Sidebar column --}}
      <aside style="position: sticky; top: calc(var(--admin-topbar-h) + 16px); display: grid; gap: 16px;">
        <div class="admin-card">
          <div class="admin-card__head"><h2>公開設定</h2></div>
          <div class="admin-card__body">
            <div class="field">
              <label>カテゴリ</label>
              <select wire:model="category_id">
                <option value="">— 未分類 —</option>
                @foreach($categories as $c)
                  <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="field">
              <label>公開日時 <span class="field__help">— 空欄 = 下書き</span></label>
              <input type="datetime-local" wire:model.blur="published_at">
              @error('published_at') <span class="field__error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
              <label>アイキャッチ画像 <span class="field__help">— パス or URL</span></label>
              <input type="text" wire:model.blur="eyecatch" placeholder="posts/claude.jpg">
              @error('eyecatch') <span class="field__error">{{ $message }}</span> @enderror
            </div>

            <div class="field--check" style="margin-bottom: 0;">
              <input type="checkbox" wire:model="featured" id="post-featured">
              <label for="post-featured">トップのフィーチャー枠に表示</label>
            </div>
          </div>
        </div>
      </aside>
    </div>

    <x-admin.sticky-save-bar
      :cancelUrl="route('admin.posts.index')"
      :submitLabel="$post ? '更新する' : '作成する'" />
  </form>
</div>
