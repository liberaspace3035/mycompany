<?php

namespace App\Livewire\Admin\Sections;

use App\Models\Page;
use App\Models\Section;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Section 編集'])]
#[Title('Section 編集')]
class Edit extends Component
{
    public Page $page;
    public Section $section;

    public string $heading = '';
    public string $subheading = '';
    public bool $visible = true;
    public int $position = 0;
    public string $payloadJson = '';  // JSON 編集用

    public function mount(Page $page, Section $section): void
    {
        abort_unless($section->page_id === $page->id, 404);

        $this->page       = $page;
        $this->section    = $section;
        $this->heading    = (string) ($section->heading ?? '');
        $this->subheading = (string) ($section->subheading ?? '');
        $this->visible    = (bool) $section->visible;
        $this->position   = (int) $section->position;
        $this->payloadJson = json_encode($section->payload ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function save()
    {
        $data = $this->validate([
            'heading'    => ['nullable', 'string', 'max:240'],
            'subheading' => ['nullable', 'string', 'max:240'],
            'visible'    => ['boolean'],
            'position'   => ['integer', 'min:0'],
            'payloadJson' => ['nullable', 'string'],
        ]);

        $payload = json_decode($data['payloadJson'] ?? '[]', true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->addError('payloadJson', '不正な JSON です: ' . json_last_error_msg());
            return;
        }

        $this->section->update([
            'heading'    => $data['heading'] ?: null,
            'subheading' => $data['subheading'] ?: null,
            'visible'    => (bool) $data['visible'],
            'position'   => (int) $data['position'],
            'payload'    => $payload,
        ]);

        session()->flash('status', 'セクションを更新しました。');
        return redirect()->route('admin.pages.edit', $this->page);
    }

    public function render()
    {
        return view('livewire.admin.sections.edit');
    }
}
