<div>
  <x-admin.page-header
    :title="$service ? 'サービスを編集' : 'サービスを追加'"
    :crumbs="'コンテンツ / サービス / ' . ($service ? '編集' : '新規')">
    <x-slot:actions>
      <a href="{{ route('admin.services.index') }}" class="btn"><x-admin.icon name="arrow-left" />一覧へ</a>
    </x-slot:actions>
  </x-admin.page-header>

  <form wire:submit.prevent="save" style="max-width: 980px;">

    <div class="admin-card">
      <div class="admin-card__head"><h2>基本情報</h2></div>
      <div class="admin-card__body">
        <div class="form-grid-2">
          <div class="field span-2">
            <label>サービス名 <span class="field__required">*</span></label>
            <input type="text" wire:model.blur="name">
            @error('name') <span class="field__error">{{ $message }}</span> @enderror
          </div>
          <div class="field">
            <label>スラッグ <span class="field__required">*</span></label>
            <input type="text" wire:model.blur="slug" placeholder="hp">
            @error('slug') <span class="field__error">{{ $message }}</span> @enderror
          </div>
          <div class="field">
            <label>Eyebrow ラベル</label>
            <input type="text" wire:model.blur="eyebrow" placeholder="SERVICE 01">
          </div>
          <div class="field span-2">
            <label>サマリ</label>
            <textarea rows="3" wire:model.blur="summary"></textarea>
            @error('summary') <span class="field__error">{{ $message }}</span> @enderror
          </div>
          <div class="field">
            <label>並び順</label>
            <input type="number" wire:model.blur="position" min="0">
          </div>
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head">
        <h2>特徴・キーワード</h2>
        <span class="admin-card__sub">公開ページで一覧表示する内訳</span>
      </div>
      <div class="admin-card__body">
        <div class="field">
          <label>提供する機能・領域 <span class="field__help">— 1行1項目</span></label>
          <textarea rows="6" wire:model.blur="featuresRaw" placeholder="コーポレートサイト&#10;ランディングページ&#10;CMS導入"></textarea>
        </div>
        <div class="field">
          <label>キーワード <span class="field__help">— カンマ区切り</span></label>
          <input type="text" wire:model.blur="keywordsRaw" placeholder="WordPress, Next.js, Astro">
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head">
        <h2>料金プラン</h2>
        <button type="button" class="btn btn-sm" wire:click="addPricing">
          <x-admin.icon name="plus" />プランを追加
        </button>
      </div>
      <div class="admin-card__body">
        @if(empty($pricing))
          <div class="empty">
            <div class="empty__sub">料金プランがまだありません。</div>
            <button type="button" class="btn btn-accent btn-sm" wire:click="addPricing">
              <x-admin.icon name="plus" />プランを追加
            </button>
          </div>
        @endif
        @foreach($pricing as $i => $p)
          <div wire:key="price-{{ $i }}" class="repeater">
            <div class="repeater__head">
              <div class="form-grid-2" style="flex: 1; gap: 12px;">
                <div class="field" style="margin: 0;">
                  <label>プラン名</label>
                  <input type="text" wire:model.blur="pricing.{{ $i }}.plan" placeholder="Standard">
                </div>
                <div class="field" style="margin: 0;">
                  <label>価格</label>
                  <input type="text" wire:model.blur="pricing.{{ $i }}.price" placeholder="¥1,400,000〜">
                </div>
              </div>
              <button type="button" class="btn btn-sm btn-danger" wire:click="removePricing({{ $i }})">
                <x-admin.icon name="trash-2" />
              </button>
            </div>
            <div class="repeater__body">
              <div class="field">
                <label>含まれる項目 <span class="field__help">— 1行1項目</span></label>
                <textarea rows="4" wire:model.blur="pricing.{{ $i }}.scopeRaw" placeholder="〜15ページ&#10;オリジナルデザイン"></textarea>
              </div>
              <div class="field--check" style="margin-bottom: 0;">
                <input type="checkbox" wire:model="pricing.{{ $i }}.featured" id="featured-{{ $i }}">
                <label for="featured-{{ $i }}">おすすめプランとして強調</label>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <x-admin.sticky-save-bar
      :cancelUrl="route('admin.services.index')"
      :submitLabel="$service ? '更新する' : '作成する'" />
  </form>
</div>
