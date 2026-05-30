<?php

namespace App\Livewire\Admin\Timeline;

use App\Models\TimelineEntry;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Timeline'])]
#[Title('Timeline')]
class Index extends Component
{
    public function delete(int $id): void
    {
        $e = TimelineEntry::findOrFail($id);
        $e->delete();
        session()->flash('status', '沿革項目「' . $e->title . '」を削除しました。');
    }

    public function render()
    {
        $entries = TimelineEntry::orderBy('position')->get();
        return view('livewire.admin.timeline.index', compact('entries'));
    }
}
