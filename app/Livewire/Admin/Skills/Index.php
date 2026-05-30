<?php

namespace App\Livewire\Admin\Skills;

use App\Models\Skill;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Skills'])]
#[Title('Skills')]
class Index extends Component
{
    public function delete(int $id): void
    {
        $s = Skill::findOrFail($id);
        $s->delete();
        session()->flash('status', 'スキル「' . $s->name . '」を削除しました。');
    }

    public function render()
    {
        $skills = Skill::orderBy('category')->orderBy('position')->get()->groupBy('category');
        return view('livewire.admin.skills.index', compact('skills'));
    }
}
