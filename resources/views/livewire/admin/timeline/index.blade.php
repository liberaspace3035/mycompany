<div>
  <x-admin.page-header title="会社沿革" crumbs="コンテンツ / 沿革">
    <x-slot:actions>
      <a href="{{ route('admin.timeline.create') }}" class="btn btn-accent"><x-admin.icon name="plus" />新規追加</a>
    </x-slot:actions>
  </x-admin.page-header>

  <div class="admin-card">
    <div class="admin-card__body admin-card__body--flush">
      @if($entries->isEmpty())
        <div class="empty">
          <div class="empty__icon"><x-admin.icon name="git-branch" /></div>
          <div class="empty__title">沿革項目がありません</div>
          <a href="{{ route('admin.timeline.create') }}" class="btn btn-accent"><x-admin.icon name="plus" />新規追加</a>
        </div>
      @else
        <table class="admin-table">
          <thead>
            <tr>
              <th style="width: 64px;">順</th>
              <th style="width: 120px;">日付</th>
              <th>タイトル</th>
              <th>説明</th>
              <th style="width: 160px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($entries as $e)
              <tr wire:key="tl-{{ $e->id }}">
                <td class="col-mono">{{ $e->position }}</td>
                <td class="col-mono">{{ $e->date }}</td>
                <td class="row-strong">{{ $e->title }}</td>
                <td style="color: var(--admin-text-dim); font-size: 13px;">{{ \Illuminate\Support\Str::limit($e->description, 70) }}</td>
                <td>
                  <div class="actions">
                    <a href="{{ route('admin.timeline.edit', $e) }}" class="btn btn-sm"><x-admin.icon name="pencil" />編集</a>
                    <button type="button" class="btn btn-sm btn-danger"
                            wire:click="delete({{ $e->id }})"
                            wire:confirm="「{{ $e->title }}」を削除します。よろしいですか？"><x-admin.icon name="trash-2" /></button>
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
