<div>
  <x-admin.page-header
    title="サイト設定"
    crumbs="設定 / サイト設定"
    sub="サイト名・連絡先・グローバルナビ・フッターのリンク列。保存すると公開側に即時反映されます。" />

  <form wire:submit.prevent="save" style="max-width: 980px;">

    <div class="admin-card">
      <div class="admin-card__head"><h2>基本情報</h2></div>
      <div class="admin-card__body">
        <div class="field">
          <label>サイト名 <span class="field__required">*</span></label>
          <input type="text" wire:model.blur="site_name">
          @error('site_name') <span class="field__error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
          <label>連絡先メールアドレス</label>
          <input type="email" wire:model.blur="contact_email" placeholder="hello@liberaspace.net">
          @error('contact_email') <span class="field__error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
          <label>フッターのキャッチコピー</label>
          <input type="text" wire:model.blur="footer_tagline" placeholder="Make Agents feel native. / 創ることを、もっと身近に。">
          @error('footer_tagline') <span class="field__error">{{ $message }}</span> @enderror
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head">
        <div>
          <h2>グローバルナビゲーション</h2>
          <div class="admin-card__sub">ヘッダー右側に並ぶリンク。Topリンクは自動で先頭に固定。</div>
        </div>
        <button type="button" class="btn btn-sm" wire:click="addNavItem"><x-admin.icon name="plus" />追加</button>
      </div>
      <div class="admin-card__body">
        <div style="display: grid; gap: 8px;">
          @foreach($nav_items as $i => $item)
            <div wire:key="nav-{{ $i }}" style="display: grid; grid-template-columns: 1fr 1.5fr 36px; gap: 8px; align-items: end;">
              <div class="field" style="margin: 0;">
                <label>ラベル</label>
                <input type="text" wire:model.blur="nav_items.{{ $i }}.label" placeholder="Services">
              </div>
              <div class="field" style="margin: 0;">
                <label>URL</label>
                <input type="text" wire:model.blur="nav_items.{{ $i }}.url" placeholder="/services">
              </div>
              <button type="button" class="btn btn-icon btn-danger" wire:click="removeNavItem({{ $i }})"><x-admin.icon name="x" /></button>
            </div>
          @endforeach
          @if(empty($nav_items))
            <div class="empty" style="padding: 32px;">
              <div class="empty__sub">ナビ項目がまだありません</div>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head">
        <div>
          <h2>フッターのリンク列</h2>
          <div class="admin-card__sub">各列に見出しとリンクをまとめます。</div>
        </div>
        <button type="button" class="btn btn-sm" wire:click="addFooterCol"><x-admin.icon name="plus" />列を追加</button>
      </div>
      <div class="admin-card__body">
        @foreach($footer_columns as $ci => $col)
          <div wire:key="col-{{ $ci }}" class="repeater">
            <div class="repeater__head">
              <div class="field" style="margin: 0; flex: 1;">
                <label>列の見出し</label>
                <input type="text" wire:model.blur="footer_columns.{{ $ci }}.heading">
                @error("footer_columns.$ci.heading") <span class="field__error">{{ $message }}</span> @enderror
              </div>
              <button type="button" class="btn btn-sm btn-danger" wire:click="removeFooterCol({{ $ci }})"><x-admin.icon name="trash-2" />列を削除</button>
            </div>
            <div class="repeater__body" style="display: grid; gap: 8px;">
              @foreach($col['links'] ?? [] as $li => $link)
                <div wire:key="col-{{ $ci }}-link-{{ $li }}" style="display: grid; grid-template-columns: 1fr 1.5fr 36px; gap: 8px;">
                  <input type="text" wire:model.blur="footer_columns.{{ $ci }}.links.{{ $li }}.label" placeholder="ラベル">
                  <input type="text" wire:model.blur="footer_columns.{{ $ci }}.links.{{ $li }}.url" placeholder="/path">
                  <button type="button" class="btn btn-icon btn-danger" wire:click="removeFooterLink({{ $ci }}, {{ $li }})"><x-admin.icon name="x" /></button>
                </div>
              @endforeach
              <button type="button" class="btn btn-sm" style="justify-self: start; margin-top: 4px;" wire:click="addFooterLink({{ $ci }})"><x-admin.icon name="plus" />リンクを追加</button>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <x-admin.sticky-save-bar submitLabel="サイト設定を保存する" />
  </form>
</div>
