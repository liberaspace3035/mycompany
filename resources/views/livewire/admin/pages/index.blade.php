<div>
  <x-admin.page-header title="ページ" crumbs="コンテンツ / ページ" sub="各公開ページの Hero / メタ / セクションを編集できます。" />

  <div class="admin-card">
    <div class="admin-card__body admin-card__body--flush">
      @if($pages->isEmpty())
        <div class="empty">
          <div class="empty__icon"><x-admin.icon name="file-text" /></div>
          <div class="empty__title">ページがありません</div>
          <div class="empty__sub">シーダーで作成: <code class="kbd">php artisan db:seed --class=PageSeeder</code></div>
        </div>
      @else
        <table class="admin-table">
          <thead>
            <tr>
              <th>ページ</th>
              <th style="width: 180px;">パス</th>
              <th>Hero タイトル</th>
              <th style="width: 110px;">セクション</th>
              <th style="width: 200px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($pages as $p)
              <tr wire:key="page-{{ $p->id }}">
                <td class="row-strong">{{ $p->name }}</td>
                <td><code class="kbd">/{{ $p->slug === 'home' ? '' : $p->slug }}</code></td>
                <td style="color: var(--admin-text-dim); font-size: 13px;">{{ \Illuminate\Support\Str::limit(str_replace("\n", ' ', $p->hero_title), 64) }}</td>
                <td><span class="chip chip--accent">{{ $p->sections_count }} 件</span></td>
                <td>
                  <div class="actions">
                    <a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-sm"><x-admin.icon name="pencil" />編集</a>
                    <a href="{{ url('/' . ($p->slug === 'home' ? '' : $p->slug)) }}" target="_blank" class="btn btn-sm"><x-admin.icon name="external-link" />プレビュー</a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</div>
