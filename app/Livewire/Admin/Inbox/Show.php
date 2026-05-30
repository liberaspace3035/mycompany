<?php

namespace App\Livewire\Admin\Inbox;

use App\Models\ContactSubmission;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => '問い合わせ詳細'])]
#[Title('問い合わせ詳細')]
class Show extends Component
{
    public ContactSubmission $submission;

    public function mount(ContactSubmission $submission): void
    {
        $this->submission = $submission;
        if (! $submission->read) {
            $submission->update(['read' => true]);
        }
    }

    public function delete()
    {
        $this->submission->delete();
        session()->flash('status', '問い合わせを削除しました。');
        return redirect()->route('admin.inbox.index');
    }

    public function render()
    {
        return view('livewire.admin.inbox.show');
    }
}
