<div>
  <x-admin.page-header
    :title="'セクション編集'"
    :crumbs="'コンテンツ / ページ / ' . $page->name . ' / セクション'"
    :sub="'Type: ' . $section->type">
    <x-slot:actions>
      <a href="{{ route('admin.pages.edit', $page) }}" class="btn"><x-admin.icon name="arrow-left" />ページに戻る</a>
    </x-slot:actions>
  </x-admin.page-header>

  <form wire:submit.prevent="save" style="max-width: 980px;">

    <div class="admin-card">
      <div class="admin-card__head"><h2>表示設定</h2></div>
      <div class="admin-card__body">
        <div class="form-grid-2">
          <div class="field">
            <label>見出し</label>
            <input type="text" wire:model.blur="heading">
            @error('heading') <span class="field__error">{{ $message }}</span> @enderror
          </div>
          <div class="field">
            <label>サブ見出し / Eyebrow</label>
            <input type="text" wire:model.blur="subheading">
            @error('subheading') <span class="field__error">{{ $message }}</span> @enderror
          </div>
          <div class="field">
            <label>並び順</label>
            <input type="number" wire:model.blur="position" min="0">
          </div>
          <div class="field--check">
            <input type="checkbox" wire:model="visible" id="section-visible">
            <label for="section-visible">公開ページに表示する</label>
          </div>
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head">
        <div>
          <h2>Payload (JSON)</h2>
          <div class="admin-card__sub">セクションタイプ毎の構造に合わせて編集。シーダーで投入された形を踏襲してください。</div>
        </div>
      </div>
      <div class="admin-card__body">
        <div class="field" style="margin: 0;">
          <textarea rows="22" wire:model.blur="payloadJson" style="font-family: var(--admin-font-mono); font-size: 13px; line-height: 1.6;"></textarea>
          @error('payloadJson') <span class="field__error">{{ $message }}</span> @enderror
        </div>
      </div>
    </div>

    <x-admin.sticky-save-bar
      :cancelUrl="route('admin.pages.edit', $page)"
      submitLabel="セクションを保存する" />
  </form>
</div>
