<div>
  <x-admin.page-header
    :title="$entry ? '沿革項目を編集' : '沿革項目を追加'"
    :crumbs="'コンテンツ / 沿革 / ' . ($entry ? '編集' : '新規')">
    <x-slot:actions>
      <a href="{{ route('admin.timeline.index') }}" class="btn"><x-admin.icon name="arrow-left" />一覧へ</a>
    </x-slot:actions>
  </x-admin.page-header>

  <form wire:submit.prevent="save" style="max-width: 760px;">
    <div class="admin-card">
      <div class="admin-card__head"><h2>沿革エントリ</h2></div>
      <div class="admin-card__body">
        <div class="form-grid-2">
          <div class="field">
            <label>日付 <span class="field__required">*</span></label>
            <input type="text" wire:model.blur="date" placeholder="2024.06">
            @error('date') <span class="field__error">{{ $message }}</span> @enderror
            <span class="field__help">表示用の文字列。例: 2024.06, 2024年6月</span>
          </div>
          <div class="field">
            <label>タイトル <span class="field__required">*</span></label>
            <input type="text" wire:model.blur="title">
            @error('title') <span class="field__error">{{ $message }}</span> @enderror
          </div>
          <div class="field span-2">
            <label>説明</label>
            <textarea rows="3" wire:model.blur="description"></textarea>
            @error('description') <span class="field__error">{{ $message }}</span> @enderror
          </div>
          <div class="field">
            <label>並び順</label>
            <input type="number" wire:model.blur="position" min="0">
          </div>
        </div>
      </div>
    </div>

    <x-admin.sticky-save-bar
      :cancelUrl="route('admin.timeline.index')"
      :submitLabel="$entry ? '更新する' : '作成する'" />
  </form>
</div>
