<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Services'])]
#[Title('Services')]
class Index extends Component
{
    public function delete(int $id): void
    {
        $s = Service::findOrFail($id);
        $s->delete();
        session()->flash('status', 'サービス「' . $s->name . '」を削除しました。');
    }

    public function render()
    {
        $services = Service::orderBy('position')->get();
        return view('livewire.admin.services.index', compact('services'));
    }
}
