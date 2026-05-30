<div>
  <x-admin.page-header
    :title="$submission->name . ' さんから'"
    crumbs="Inbox / 詳細">
    <x-slot:actions>
      <a href="{{ route('admin.inbox.index') }}" class="btn"><x-admin.icon name="arrow-left" />一覧へ</a>
    </x-slot:actions>
  </x-admin.page-header>

  <div class="admin-card" style="max-width: 800px;">
    <div class="admin-card__body">
      <dl style="display: grid; grid-template-columns: 100px 1fr; gap: 12px 24px; margin: 0; font-size: 13px;">
        <dt style="font-family: var(--admin-font-mono); font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: var(--admin-text-muted);">日時</dt>
        <dd class="col-mono" style="font-size: 13px;">{{ $submission->created_at?->format('Y年m月d日 H:i') }}</dd>

        <dt style="font-family: var(--admin-font-mono); font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: var(--admin-text-muted);">名前</dt>
        <dd>{{ $submission->name }}</dd>

        <dt style="font-family: var(--admin-font-mono); font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: var(--admin-text-muted);">メール</dt>
        <dd><a href="mailto:{{ $submission->email }}" style="color: var(--admin-accent);">{{ $submission->email }}</a></dd>

        @if($submission->company)
          <dt style="font-family: var(--admin-font-mono); font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: var(--admin-text-muted);">会社</dt>
          <dd>{{ $submission->company }}</dd>
        @endif

        @if($submission->source_url)
          <dt style="font-family: var(--admin-font-mono); font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: var(--admin-text-muted);">送信元</dt>
          <dd class="row-sub">{{ $submission->source_url }}</dd>
        @endif
      </dl>
    </div>

    <div class="admin-card__head" style="border-top: 1px solid var(--admin-border); border-bottom: 0;">
      <h3>本文</h3>
    </div>
    <div class="admin-card__body">
      <div style="white-space: pre-wrap; line-height: 1.85; font-size: 14px; color: var(--admin-text);">{{ $submission->body }}</div>

      <div class="btn-row btn-row--between" style="margin-top: 32px;">
        <a href="mailto:{{ $submission->email }}?subject=Re:%20Liberaspace への問い合わせ" class="btn btn-accent">
          <x-admin.icon name="mail" />
          メールで返信
        </a>
        <button class="btn btn-danger" wire:click="delete"
                wire:confirm="この問い合わせを削除します。よろしいですか？">
          <x-admin.icon name="trash-2" />
          削除
        </button>
      </div>
    </div>
  </div>
</div>
