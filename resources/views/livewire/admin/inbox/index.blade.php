<div>
  <x-admin.page-header title="問い合わせ" crumbs="Inbox" sub="公開サイトの問い合わせフォームから届いたメッセージ。" />

  <div class="admin-card" style="margin-bottom: 16px;">
    <div class="admin-card__body">
      <div class="field" style="margin: 0; max-width: 240px;">
        <label>フィルタ</label>
        <select wire:model.live="filter">
          <option value="">すべて</option>
          <option value="unread">未読</option>
          <option value="read">既読</option>
        </select>
      </div>
    </div>
  </div>

  <div class="admin-card">
    <div class="admin-card__body admin-card__body--flush">
      @if($submissions->isEmpty())
        <div class="empty">
          <div class="empty__icon"><x-admin.icon name="inbox" /></div>
          <div class="empty__title">該当する問い合わせがありません</div>
          <div class="empty__sub">フォームから届くとここに並びます。</div>
        </div>
      @else
        <table class="admin-table">
          <thead>
            <tr>
              <th style="width: 40px;"></th>
              <th style="width: 150px;">日時</th>
              <th style="width: 180px;">名前</th>
              <th style="width: 180px;">会社</th>
              <th>本文</th>
              <th style="width: 220px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($submissions as $s)
              <tr wire:key="sub-{{ $s->id }}" style="{{ $s->read ? '' : 'background: var(--admin-accent-soft);' }}">
                <td>
                  @if(! $s->read)
                    <span class="badge badge--unread badge--dot"></span>
                  @endif
                </td>
                <td class="col-mono">{{ $s->created_at?->format('Y-m-d H:i') }}</td>
                <td>
                  <div class="row-strong">{{ $s->name }}</div>
                  <div class="row-sub">{{ $s->email }}</div>
                </td>
                <td>{{ $s->company ?: '—' }}</td>
                <td style="color: var(--admin-text-dim);">{{ \Illuminate\Support\Str::limit($s->body, 80) }}</td>
                <td>
                  <div class="actions">
                    <a href="{{ route('admin.inbox.show', $s) }}" class="btn btn-sm"><x-admin.icon name="eye" />詳細</a>
                    @if($s->read)
                      <button class="btn btn-sm" wire:click="markUnread({{ $s->id }})">未読</button>
                    @else
                      <button class="btn btn-sm" wire:click="markRead({{ $s->id }})">既読</button>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div style="margin-top: 16px;">{{ $submissions->links() }}</div>
</div>
