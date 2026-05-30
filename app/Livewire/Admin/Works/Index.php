<?php

namespace App\Livewire\Admin\Works;

use App\Models\Work;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Works'])]
#[Title('Works')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(as: 'cat', except: '')]
    public string $category = '';

    public function updatingSearch(): void   { $this->resetPage(); }
    public function updatingCategory(): void { $this->resetPage(); }

    public function delete(int $id): void
    {
        $work = Work::findOrFail($id);
        $work->delete();
        session()->flash('status', '実績「' . $work->title . '」を削除しました。');
    }

    public function toggleFeatured(int $id): void
    {
        $work = Work::findOrFail($id);
        $work->featured = ! $work->featured;
        $work->save();
    }

    public function render()
    {
        $works = Work::query()
            ->when($this->search !== '', fn ($q) => $q->where('title', 'like', '%'.$this->search.'%'))
            ->when($this->category !== '', fn ($q) => $q->where('category', $this->category))
            ->orderBy('position')
            ->orderByDesc('id')
            ->paginate(20);

        $categories = Work::query()->select('category')->distinct()->pluck('category');

        return view('livewire.admin.works.index', compact('works', 'categories'));
    }
}
