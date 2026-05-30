<div>
  <x-admin.page-header title="実績" crumbs="コンテンツ / 実績" sub="トップの Selected Works とサブページの一覧に表示される実績データ。">
    <x-slot:actions>
      <a href="{{ route('admin.works.create') }}" class="btn btn-accent">
        <x-admin.icon name="plus" />
        新規追加
      </a>
    </x-slot:actions>
  </x-admin.page-header>

  <div class="admin-card" style="margin-bottom: 16px;">
    <div class="admin-card__body">
      <div class="form-grid-2">
        <div class="field" style="margin: 0;">
          <label>タイトル検索</label>
          <input type="text" wire:model.live.debounce.300ms="search" placeholder="例：自動見積">
        </div>
        <div class="field" style="margin: 0;">
          <label>カテゴリ</label>
          <select wire:model.live="category">
            <option value="">すべて</option>
            @foreach($categories as $c)
              <option value="{{ $c }}">{{ $c }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="admin-card">
    <div class="admin-card__body admin-card__body--flush">
      @if($works->isEmpty())
        <div class="empty">
          <div class="empty__icon"><x-admin.icon name="briefcase" /></div>
          <div class="empty__title">該当する実績がありません</div>
          <div class="empty__sub">条件を変えるか、新規追加から作成してください。</div>
          <a href="{{ route('admin.works.create') }}" class="btn btn-accent"><x-admin.icon name="plus" />新規追加</a>
        </div>
      @else
        <table class="admin-table">
          <thead>
            <tr>
              <th style="width: 64px;">順</th>
              <th>タイトル</th>
              <th style="width: 160px;">カテゴリ</th>
              <th style="width: 80px;">年</th>
              <th style="width: 110px;">Featured</th>
              <th style="width: 160px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($works as $work)
              <tr wire:key="work-{{ $work->id }}">
                <td class="col-mono">{{ $work->position }}</td>
                <td>
                  <div class="row-strong">{{ $work->title }}</div>
                  <div class="row-sub">{{ \Illuminate\Support\Str::limit($work->summary, 90) }}</div>
                </td>
                <td><span class="chip">{{ $work->category }}</span></td>
                <td class="col-mono">{{ $work->year }}</td>
                <td>
                  <button type="button" wire:click="toggleFeatured({{ $work->id }})"
                          class="toggle-btn {{ $work->featured ? 'toggle-btn--on' : '' }}">
                    {{ $work->featured ? 'ON' : 'OFF' }}
                  </button>
                </td>
                <td>
                  <div class="actions">
                    <a href="{{ route('admin.works.edit', $work) }}" class="btn btn-sm"><x-admin.icon name="pencil" />編集</a>
                    <button type="button" class="btn btn-sm btn-danger"
                            wire:click="delete({{ $work->id }})"
                            wire:confirm="「{{ $work->title }}」を削除します。よろしいですか？"><x-admin.icon name="trash-2" /></button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div style="margin-top: 16px;">{{ $works->links() }}</div>
</div>
