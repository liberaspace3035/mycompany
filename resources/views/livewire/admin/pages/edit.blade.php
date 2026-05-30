<div>
  <x-admin.page-header
    :title="$page->name . ' ページ'"
    :crumbs="'コンテンツ / ページ / ' . $page->name"
    sub="Hero 文言・データリードアウト・CTA・SEO メタを編集できます。ページ内の各セクションはこのページ下部から個別に開けます。">
    <x-slot:actions>
      <a href="{{ url('/' . ($page->slug === 'home' ? '' : $page->slug)) }}" target="_blank" class="btn">
        <x-admin.icon name="external-link" />プレビュー
      </a>
    </x-slot:actions>
  </x-admin.page-header>

  <form wire:submit.prevent="save" style="max-width: 980px;">

    <div class="admin-card">
      <div class="admin-card__head"><h2>Hero</h2></div>
      <div class="admin-card__body">
        <div class="field">
          <label>ページ名 <span class="field__help">— 管理画面表示用</span></label>
          <input type="text" wire:model.blur="name">
          @error('name') <span class="field__error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
          <label>Eyebrow ラベル</label>
          <input type="text" wire:model.blur="hero_eyebrow" placeholder="SYS // RENDERING">
        </div>
        <div class="field">
          <label>Hero タイトル <span class="field__required">*</span> <span class="field__help">— 改行で行分割</span></label>
          <textarea rows="3" wire:model.blur="hero_title" placeholder="Make Agents&#10;feel native."></textarea>
          @error('hero_title') <span class="field__error">{{ $message }}</span> @enderror
          <span class="field__help">英文末尾は自動でアクセント色に。最初の大文字始まり単語は揺れアニメが当たります。</span>
        </div>
        <div class="field">
          <label>日本語タグライン</label>
          <input type="text" wire:model.blur="hero_jp_tagline" placeholder="創ることを、もっと身近に。">
        </div>
        <div class="field">
          <label>サブ文 <span class="field__help">— Hero 下の説明</span></label>
          <textarea rows="4" wire:model.blur="hero_sub"></textarea>
          @error('hero_sub') <span class="field__error">{{ $message }}</span> @enderror
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head">
        <div>
          <h2>Hero データリードアウト</h2>
          <div class="admin-card__sub">Hero 下部のテック風データセル</div>
        </div>
        <button type="button" class="btn btn-sm" wire:click="addMeta">
          <x-admin.icon name="plus" />セルを追加
        </button>
      </div>
      <div class="admin-card__body">
        @if(empty($hero_meta))
          <div class="empty">
            <div class="empty__sub">データセルがまだありません</div>
          </div>
        @endif
        <div style="display: grid; gap: 8px;">
          @foreach($hero_meta as $i => $meta)
            <div wire:key="meta-{{ $i }}" style="display: grid; grid-template-columns: 1fr 2fr 36px; gap: 8px; align-items: end;">
              <div class="field" style="margin: 0;">
                <label>ラベル</label>
                <input type="text" wire:model.blur="hero_meta.{{ $i }}.label" placeholder="// STACK">
              </div>
              <div class="field" style="margin: 0;">
                <label>値</label>
                <input type="text" wire:model.blur="hero_meta.{{ $i }}.value" placeholder="Laravel · WordPress · Next">
              </div>
              <button type="button" class="btn btn-icon btn-danger" wire:click="removeMeta({{ $i }})"><x-admin.icon name="x" /></button>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head"><h2>CTA</h2></div>
      <div class="admin-card__body">
        <div class="form-grid-2">
          <div class="field">
            <label>プライマリ CTA ラベル</label>
            <input type="text" wire:model.blur="cta_label" placeholder="30分の無料ヒアリングへ">
          </div>
          <div class="field">
            <label>プライマリ CTA URL</label>
            <input type="text" wire:model.blur="cta_url" placeholder="/company#contact">
          </div>
          <div class="field">
            <label>セカンダリ CTA ラベル</label>
            <input type="text" wire:model.blur="secondary_cta_label" placeholder="サービスを見る">
          </div>
          <div class="field">
            <label>セカンダリ CTA URL</label>
            <input type="text" wire:model.blur="secondary_cta_url" placeholder="/services">
          </div>
        </div>
      </div>
    </div>

    <div class="admin-card">
      <div class="admin-card__head"><h2>SEO メタ</h2></div>
      <div class="admin-card__body">
        <div class="field">
          <label>meta description</label>
          <textarea rows="2" wire:model.blur="meta_description"></textarea>
        </div>
        <div class="field">
          <label>meta keywords</label>
          <input type="text" wire:model.blur="meta_keywords">
        </div>
      </div>
    </div>

    <x-admin.sticky-save-bar
      :cancelUrl="route('admin.pages.index')"
      submitLabel="ページを保存する" />
  </form>

  <div class="admin-card" style="margin-top: 28px; max-width: 980px;">
    <div class="admin-card__head">
      <div>
        <h2>ページ内セクション</h2>
        <div class="admin-card__sub">セクションごとの中身は payload (JSON) で持っています。文言や項目数を編集できます。</div>
      </div>
    </div>
    <div class="admin-card__body admin-card__body--flush">
      @if($sections->isEmpty())
        <div class="empty">
          <div class="empty__icon"><x-admin.icon name="file-text" /></div>
          <div class="empty__title">このページにはセクションがありません</div>
        </div>
      @else
        <table class="admin-table">
          <thead>
            <tr>
              <th style="width: 64px;">順</th>
              <th style="width: 160px;">タイプ</th>
              <th>見出し</th>
              <th style="width: 90px;">表示</th>
              <th style="width: 80px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($sections as $s)
              <tr wire:key="sec-{{ $s->id }}">
                <td class="col-mono">{{ $s->position }}</td>
                <td><code class="kbd">{{ $s->type }}</code></td>
                <td>{{ \Illuminate\Support\Str::limit($s->heading, 60) }}</td>
                <td>
                  @if($s->visible)
                    <span class="badge badge--published">表示</span>
                  @else
                    <span class="badge badge--draft">非表示</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('admin.sections.edit', [$page, $s]) }}" class="btn btn-sm"><x-admin.icon name="pencil" />編集</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</div>
