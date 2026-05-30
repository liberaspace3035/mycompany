<div>
  <x-admin.page-header title="サービス" crumbs="コンテンツ / サービス">
    <x-slot:actions>
      <a href="{{ route('admin.services.create') }}" class="btn btn-accent"><x-admin.icon name="plus" />新規追加</a>
    </x-slot:actions>
  </x-admin.page-header>

  <div class="admin-card">
    <div class="admin-card__body admin-card__body--flush">
      @if($services->isEmpty())
        <div class="empty">
          <div class="empty__icon"><x-admin.icon name="package" /></div>
          <div class="empty__title">サービスがまだありません</div>
          <a href="{{ route('admin.services.create') }}" class="btn btn-accent"><x-admin.icon name="plus" />新規追加</a>
        </div>
      @else
        <table class="admin-table">
          <thead>
            <tr>
              <th style="width: 64px;">順</th>
              <th>サービス</th>
              <th>サマリ</th>
              <th style="width: 110px;">料金プラン</th>
              <th style="width: 160px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($services as $s)
              <tr wire:key="svc-{{ $s->id }}">
                <td class="col-mono">{{ $s->position }}</td>
                <td>
                  <div class="row-sub" style="margin-bottom: 4px;">{{ $s->eyebrow }}</div>
                  <div class="row-strong">{{ $s->name }}</div>
                </td>
                <td style="color: var(--admin-text-dim); font-size: 13px;">{{ \Illuminate\Support\Str::limit($s->summary, 90) }}</td>
                <td><span class="chip chip--accent">{{ count($s->pricing ?? []) }} プラン</span></td>
                <td>
                  <div class="actions">
                    <a href="{{ route('admin.services.edit', $s) }}" class="btn btn-sm"><x-admin.icon name="pencil" />編集</a>
                    <button type="button" class="btn btn-sm btn-danger"
                            wire:click="delete({{ $s->id }})"
                            wire:confirm="「{{ $s->name }}」を削除します。よろしいですか？"><x-admin.icon name="trash-2" /></button>
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
