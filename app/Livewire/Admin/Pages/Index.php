<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Pages'])]
#[Title('Pages')]
class Index extends Component
{
    public function render()
    {
        $pages = Page::withCount('sections')->orderBy('id')->get();
        return view('livewire.admin.pages.index', compact('pages'));
    }
}
