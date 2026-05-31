<div>
  <x-admin.page-header
    :title="$work ? '実績を編集' : '実績を追加'"
    :crumbs="'コンテンツ / 実績 / ' . ($work ? '編集' : '新規')">
    <x-slot:actions>
      <a href="{{ route('admin.works.index') }}" class="btn"><x-admin.icon name="arrow-left" />一覧へ</a>
    </x-slot:actions>
  </x-admin.page-header>

  <form wire:submit.prevent="save" style="max-width: 920px;">

    <div class="admin-card">
      <div class="admin-card__head"><h2>基本情報</h2></div>
      <div class="admin-card__body">
        <div class="form-grid-2">
          <div class="field span-2">
            <label>タイトル <span class="field__required">*</span></label>
            <input type="text" wire:model.blur="title" autofocus>
            @error('title') <span class="field__error">{{ $message }}</span> @enderror
          </div>

          <div class="field">
            <label>スラッグ <span class="field__required">*</span></label>
            <input type="text" wire:model.blur="slug" placeholder="auto-quote-system">
            @error('slug') <span class="field__error">{{ $message }}</span> @enderror
          </div>

          <div class="field">
            <label>カテゴリ <span class="field__required">*</span></label>
            <input type="text" wire:model.blur="category" placeholder="例: HP / Web">
            @error('category') <span class="field__error">{{ $message }}</span> @enderror
          </div>

          <div class="field">
            <label>年 / 期間</label>
            <input type="text" wire:model.blur="year" placeholder="2026 / 2024-2025">
            @error('year') <span class="field__error">{{ $message }}</span> @enderror
          </div>

          <div class="field">
            <label>並び順</label>
            <input type="number" wire:model.blur="position" min="0">
            @error('position') <span class="field__error">{{ $message }}</span> @enderror
          </div>

          <div class="field span-2">
            <label>サマリ</label>
            <textarea rows="3" wire:model.blur="summary"></textarea>
            @error('summary') <span class="field__error">{{ $message }}</span> @enderror
          </div>

          <div class="field span-2">
            <label>タグ <span class="field__help">— カンマ区切り</span></label>
            <input type="text" wire:model.blur="tagsRaw" placeholder="Laravel, AWS, DX">
            @error('tagsRaw') <span class="field__error">{{ $message }}</span> @enderror
          </div>
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head"><h2>メディアと外部リンク</h2></div>
      <div class="admin-card__body">
        <div class="field span-2">
          <label>画像をアップロード <span class="field__help">— JPG / PNG / WebP（最大8MB）</span></label>
          <input type="file" wire:model="imageUpload" accept="image/*">
          <div wire:loading wire:target="imageUpload" class="field__help">アップロード中…</div>
          @error('imageUpload') <span class="field__error">{{ $message }}</span> @enderror

          {{-- プレビュー：選択中のファイル → 既存の保存済み画像 の順に表示 --}}
          @if ($imageUpload)
            <img src="{{ $imageUpload->temporaryUrl() }}" alt="プレビュー"
                 style="margin-top:10px;max-width:280px;border-radius:8px;border:1px solid var(--border);">
          @elseif ($image)
            <img src="{{ \Illuminate\Support\Str::startsWith($image, 'http') ? $image : asset('uploads/'.$image) }}" alt="現在の画像"
                 style="margin-top:10px;max-width:280px;border-radius:8px;border:1px solid var(--border);">
          @endif
        </div>

        <div class="form-grid-2" style="margin-top:16px;">
          <div class="field">
            <label>画像パス / URL <span class="field__help">— 通常は自動入力。手動指定も可</span></label>
            <input type="text" wire:model.blur="image" placeholder="works/auto-quote.png">
            @error('image') <span class="field__error">{{ $message }}</span> @enderror
          </div>
          <div class="field">
            <label>外部リンク <span class="field__help">— カードのクリックで開くURL</span></label>
            <input type="text" wire:model.blur="url" placeholder="https://...">
            @error('url') <span class="field__error">{{ $message }}</span> @enderror
          </div>
        </div>
        <div class="field--check">
          <input type="checkbox" wire:model="featured" id="work-featured">
          <label for="work-featured">トップの "Selected Works" に表示する</label>
        </div>
      </div>
    </div>

    <x-admin.sticky-save-bar
      :cancelUrl="route('admin.works.index')"
      :submitLabel="$work ? '更新する' : '作成する'" />
  </form>
</div>
