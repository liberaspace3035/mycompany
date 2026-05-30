<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Post 編集'])]
#[Title('Post 編集')]
class Edit extends Component
{
    public ?Post $post = null;

    public string $title = '';
    public string $slug = '';
    public ?int $category_id = null;
    public string $summary = '';
    public string $body_md = '';
    public string $eyecatch = '';
    public bool $featured = false;
    public ?string $published_at = null;   // 'YYYY-MM-DDTHH:MM' (datetime-local 形式)

    public function mount(?Post $post = null): void
    {
        if ($post && $post->exists) {
            $this->post = $post;
            $this->title       = $post->title;
            $this->slug        = $post->slug;
            $this->category_id = $post->category_id;
            $this->summary     = (string) ($post->summary ?? '');
            $this->body_md     = (string) ($post->body_md ?? '');
            $this->eyecatch    = (string) ($post->eyecatch ?? '');
            $this->featured    = (bool) $post->featured;
            $this->published_at = $post->published_at?->format('Y-m-d\TH:i');
        }
    }

    protected function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:200'],
            'slug'         => ['required', 'string', 'max:200', 'regex:/^[a-z0-9-]+$/', Rule::unique('posts', 'slug')->ignore($this->post?->id)],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'summary'      => ['nullable', 'string', 'max:2000'],
            'body_md'      => ['required', 'string'],
            'eyecatch'     => ['nullable', 'string', 'max:255'],
            'featured'     => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function updatedTitle(string $value): void
    {
        if (! $this->post && $this->slug === '') {
            $this->slug = Str::slug($value) ?: Str::lower(Str::random(8));
        }
    }

    public function save()
    {
        $data = $this->validate();

        $payload = [
            'title'        => $data['title'],
            'slug'         => $data['slug'],
            'category_id'  => $data['category_id'] ?: null,
            'summary'      => $data['summary'] ?: null,
            'body_md'      => $data['body_md'],
            'eyecatch'     => $data['eyecatch'] ?: null,
            'featured'     => (bool) $data['featured'],
            'published_at' => $data['published_at'] ?: null,
        ];

        if ($this->post) {
            $this->post->update($payload);
            session()->flash('status', '記事を更新しました。');
        } else {
            Post::create($payload);
            session()->flash('status', '記事を作成しました。');
        }

        return redirect()->route('admin.posts.index');
    }

    public function render()
    {
        return view('livewire.admin.posts.edit', [
            'categories' => Category::orderBy('position')->get(),
        ]);
    }
}
