@props([
    'cancelUrl' => null,
    'cancelLabel' => 'キャンセル',
    'submitLabel' => '保存する',
    'submittingLabel' => '処理中…',
    'message' => null,
])

<div class="sticky-save-bar">
  <div class="sticky-save-bar__msg">
    @if($message)
      {{ $message }}
    @else
      <span wire:dirty.class="">未保存の変更があります</span>
    @endif
  </div>
  <div class="btn-row">
    @if($cancelUrl)
      <a href="{{ $cancelUrl }}" class="btn">{{ $cancelLabel }}</a>
    @endif
    <button type="submit" class="btn btn-accent">
      <x-admin.icon name="save" />
      <span wire:loading.remove>{{ $submitLabel }}</span>
      <span wire:loading>{{ $submittingLabel }}</span>
    </button>
  </div>
</div>
