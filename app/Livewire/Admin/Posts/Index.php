<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Posts'])]
#[Title('Posts')]
class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(as: 'state', except: '')]
    public string $state = ''; // '' | 'draft' | 'published'

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingState(): void  { $this->resetPage(); }

    public function delete(int $id): void
    {
        $post = Post::findOrFail($id);
        $post->delete();
        session()->flash('status', '記事「' . $post->title . '」を削除しました。');
    }

    public function toggleFeatured(int $id): void
    {
        $post = Post::findOrFail($id);
        $post->featured = ! $post->featured;
        $post->save();
    }

    public function render()
    {
        $posts = Post::with('category')
            ->when($this->search !== '', fn ($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->state === 'draft',     fn ($q) => $q->whereNull('published_at'))
            ->when($this->state === 'published', fn ($q) => $q->whereNotNull('published_at')->where('published_at', '<=', now()))
            ->latest('published_at')
            ->latest('id')
            ->paginate(20);

        return view('livewire.admin.posts.index', compact('posts'));
    }
}
