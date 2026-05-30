<?php

namespace App\Livewire\Admin\Works;

use App\Models\Work;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Edit Work'])]
#[Title('Work 編集')]
class Edit extends Component
{
    public ?Work $work = null;

    public string $title = '';
    public string $slug = '';
    public string $category = '';
    public string $year = '';
    public string $summary = '';
    public string $url = '';
    public string $image = '';
    public string $tagsRaw = '';        // カンマ区切り (フォーム表示用)
    public bool $featured = false;
    public int $position = 0;

    public function mount(?Work $work = null): void
    {
        if ($work && $work->exists) {
            $this->work = $work;
            $this->title    = $work->title;
            $this->slug     = $work->slug;
            $this->category = $work->category;
            $this->year     = (string) ($work->year ?? '');
            $this->summary  = (string) ($work->summary ?? '');
            $this->url      = (string) ($work->url ?? '');
            $this->image    = (string) ($work->image ?? '');
            $this->tagsRaw  = collect($work->tags ?? [])->implode(', ');
            $this->featured = (bool) $work->featured;
            $this->position = (int) $work->position;
        } else {
            $this->position = (Work::max('position') ?? 0) + 1;
        }
    }

    protected function rules(): array
    {
        return [
            'title'    => ['required', 'string', 'max:160'],
            'slug'     => ['required', 'string', 'max:160', 'regex:/^[a-z0-9-]+$/', Rule::unique('works', 'slug')->ignore($this->work?->id)],
            'category' => ['required', 'string', 'max:64'],
            'year'     => ['nullable', 'string', 'max:16'],
            'summary'  => ['nullable', 'string', 'max:2000'],
            'url'      => ['nullable', 'url', 'max:255'],
            'image'    => ['nullable', 'string', 'max:255'],
            'tagsRaw'  => ['nullable', 'string', 'max:255'],
            'featured' => ['boolean'],
            'position' => ['integer', 'min:0'],
        ];
    }

    // タイトル入力時にスラッグを自動補完 (新規時のみ)
    public function updatedTitle(string $value): void
    {
        if (! $this->work && $this->slug === '') {
            $this->slug = Str::slug($value) ?: Str::lower(Str::random(8));
        }
    }

    public function save()
    {
        $data = $this->validate();

        $payload = [
            'title'    => $data['title'],
            'slug'     => $data['slug'],
            'category' => $data['category'],
            'year'     => $data['year'] ?: null,
            'summary'  => $data['summary'] ?: null,
            'url'      => $data['url'] ?: null,
            'image'    => $data['image'] ?: null,
            'tags'     => collect(explode(',', $data['tagsRaw'] ?? ''))
                ->map(fn ($t) => trim($t))
                ->filter()
                ->values()
                ->all(),
            'featured' => (bool) $data['featured'],
            'position' => (int) $data['position'],
        ];

        if ($this->work) {
            $this->work->update($payload);
            session()->flash('status', '実績を更新しました。');
        } else {
            Work::create($payload);
            session()->flash('status', '実績を作成しました。');
        }

        return redirect()->route('admin.works.index');
    }

    public function render()
    {
        return view('livewire.admin.works.edit');
    }
}
