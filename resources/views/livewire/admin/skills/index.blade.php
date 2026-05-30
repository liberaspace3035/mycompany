<div>
  <x-admin.page-header title="スキル" crumbs="コンテンツ / スキル">
    <x-slot:actions>
      <a href="{{ route('admin.skills.create') }}" class="btn btn-accent"><x-admin.icon name="plus" />新規追加</a>
    </x-slot:actions>
  </x-admin.page-header>

  @if($skills->isEmpty())
    <div class="admin-card"><div class="admin-card__body">
      <div class="empty">
        <div class="empty__icon"><x-admin.icon name="award" /></div>
        <div class="empty__title">スキルがまだありません</div>
        <a href="{{ route('admin.skills.create') }}" class="btn btn-accent"><x-admin.icon name="plus" />新規追加</a>
      </div>
    </div></div>
  @else
    @foreach($skills as $category => $items)
      <div class="admin-card" style="margin-bottom: 16px;">
        <div class="admin-card__head">
          <h2>{{ $category }}</h2>
          <span class="admin-card__sub">{{ $items->count() }} 件</span>
        </div>
        <div class="admin-card__body admin-card__body--flush">
          <table class="admin-table">
            <thead>
              <tr>
                <th style="width: 64px;">順</th>
                <th>スキル名</th>
                <th style="width: 240px;">レベル</th>
                <th style="width: 160px;"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $s)
                <tr wire:key="sk-{{ $s->id }}">
                  <td class="col-mono">{{ $s->position }}</td>
                  <td class="row-strong">{{ $s->name }}</td>
                  <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                      <div style="position: relative; height: 4px; background: var(--admin-border); flex: 1; border-radius: 999px; overflow: hidden;">
                        <div style="position: absolute; left: 0; top: 0; bottom: 0; background: var(--admin-accent); width: {{ $s->level }}%;"></div>
                      </div>
                      <span class="col-mono" style="width: 32px; text-align: right;">{{ $s->level }}</span>
                    </div>
                  </td>
                  <td>
                    <div class="actions">
                      <a href="{{ route('admin.skills.edit', $s) }}" class="btn btn-sm"><x-admin.icon name="pencil" />編集</a>
                      <button type="button" class="btn btn-sm btn-danger"
                              wire:click="delete({{ $s->id }})"
                              wire:confirm="「{{ $s->name }}」を削除します。よろしいですか？"><x-admin.icon name="trash-2" /></button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endforeach
  @endif
</div>
