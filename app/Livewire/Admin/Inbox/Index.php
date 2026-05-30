<?php

namespace App\Livewire\Admin\Inbox;

use App\Models\ContactSubmission;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => '問い合わせ'])]
#[Title('Inbox')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'filter', except: '')]
    public string $filter = ''; // '' | 'unread' | 'read'

    public function updatingFilter(): void { $this->resetPage(); }

    public function markRead(int $id): void
    {
        ContactSubmission::where('id', $id)->update(['read' => true]);
    }

    public function markUnread(int $id): void
    {
        ContactSubmission::where('id', $id)->update(['read' => false]);
    }

    public function delete(int $id): void
    {
        ContactSubmission::destroy($id);
        session()->flash('status', '問い合わせを削除しました。');
    }

    public function render()
    {
        $submissions = ContactSubmission::query()
            ->when($this->filter === 'unread', fn ($q) => $q->where('read', false))
            ->when($this->filter === 'read',   fn ($q) => $q->where('read', true))
            ->latest()
            ->paginate(20);

        return view('livewire.admin.inbox.index', compact('submissions'));
    }
}
