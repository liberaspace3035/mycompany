<div>
  <x-admin.page-header
    :title="$skill ? 'スキルを編集' : 'スキルを追加'"
    :crumbs="'コンテンツ / スキル / ' . ($skill ? '編集' : '新規')">
    <x-slot:actions>
      <a href="{{ route('admin.skills.index') }}" class="btn"><x-admin.icon name="arrow-left" />一覧へ</a>
    </x-slot:actions>
  </x-admin.page-header>

  <form wire:submit.prevent="save" style="max-width: 640px;">
    <div class="admin-card">
      <div class="admin-card__head"><h2>スキル</h2></div>
      <div class="admin-card__body">
        <div class="field">
          <label>カテゴリ <span class="field__required">*</span></label>
          <input type="text" wire:model.blur="category" list="cats" placeholder="Frontend / Backend / AI / Infra">
          <datalist id="cats">
            @foreach($categories as $c)
              <option value="{{ $c }}">
            @endforeach
          </datalist>
          @error('category') <span class="field__error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
          <label>スキル名 <span class="field__required">*</span></label>
          <input type="text" wire:model.blur="name" placeholder="Laravel">
          @error('name') <span class="field__error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
          <label>レベル <span class="field__help">— <span class="col-mono" style="color: var(--admin-accent);">{{ $level }}</span> / 100</span></label>
          <input type="range" wire:model.live="level" min="0" max="100" step="1">
          @error('level') <span class="field__error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
          <label>並び順</label>
          <input type="number" wire:model.blur="position" min="0">
        </div>
      </div>
    </div>

    <x-admin.sticky-save-bar
      :cancelUrl="route('admin.skills.index')"
      :submitLabel="$skill ? '更新する' : '作成する'" />
  </form>
</div>
