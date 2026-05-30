<?php

namespace App\Livewire\Admin\Timeline;

use App\Models\TimelineEntry;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => '沿革編集'])]
#[Title('沿革編集')]
class Edit extends Component
{
    public ?TimelineEntry $entry = null;

    public string $date = '';
    public string $title = '';
    public string $description = '';
    public int $position = 0;

    public function mount(?TimelineEntry $entry = null): void
    {
        if ($entry && $entry->exists) {
            $this->entry = $entry;
            $this->date        = $entry->date;
            $this->title       = $entry->title;
            $this->description = (string) ($entry->description ?? '');
            $this->position    = (int) $entry->position;
        } else {
            $this->position = (TimelineEntry::max('position') ?? 0) + 1;
        }
    }

    protected function rules(): array
    {
        return [
            'date'        => ['required', 'string', 'max:32'],
            'title'       => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:2000'],
            'position'    => ['integer', 'min:0'],
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $payload = [
            'date'        => $data['date'],
            'title'       => $data['title'],
            'description' => $data['description'] ?: null,
            'position'    => (int) $data['position'],
        ];

        if ($this->entry) {
            $this->entry->update($payload);
            session()->flash('status', '沿革項目を更新しました。');
        } else {
            TimelineEntry::create($payload);
            session()->flash('status', '沿革項目を作成しました。');
        }

        return redirect()->route('admin.timeline.index');
    }

    public function render()
    {
        return view('livewire.admin.timeline.edit');
    }
}
