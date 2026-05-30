<?php

namespace App\Livewire\Admin\Skills;

use App\Models\Skill;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'スキル編集'])]
#[Title('スキル編集')]
class Edit extends Component
{
    public ?Skill $skill = null;

    public string $category = '';
    public string $name = '';
    public int $level = 80;
    public int $position = 0;

    public function mount(?Skill $skill = null): void
    {
        if ($skill && $skill->exists) {
            $this->skill    = $skill;
            $this->category = $skill->category;
            $this->name     = $skill->name;
            $this->level    = (int) $skill->level;
            $this->position = (int) $skill->position;
        } else {
            $this->position = (Skill::max('position') ?? 0) + 1;
        }
    }

    protected function rules(): array
    {
        return [
            'category' => ['required', 'string', 'max:64'],
            'name'     => ['required', 'string', 'max:60'],
            'level'    => ['integer', 'min:0', 'max:100'],
            'position' => ['integer', 'min:0'],
        ];
    }

    public function save()
    {
        $data = $this->validate();

        if ($this->skill) {
            $this->skill->update($data);
            session()->flash('status', 'スキルを更新しました。');
        } else {
            Skill::create($data);
            session()->flash('status', 'スキルを作成しました。');
        }

        return redirect()->route('admin.skills.index');
    }

    public function render()
    {
        // 候補 (categoryの datalist 用)
        $categories = Skill::query()->select('category')->distinct()->orderBy('category')->pluck('category');
        return view('livewire.admin.skills.edit', compact('categories'));
    }
}
