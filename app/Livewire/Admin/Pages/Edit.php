<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Page 編集'])]
#[Title('Page 編集')]
class Edit extends Component
{
    public Page $page;

    public string $name = '';
    public string $hero_eyebrow = '';
    public string $hero_title = '';
    public string $hero_sub = '';
    public string $hero_jp_tagline = '';
    public array $hero_meta = [];      // [['label'=>'','value'=>'']]
    public string $cta_label = '';
    public string $cta_url = '';
    public string $secondary_cta_label = '';
    public string $secondary_cta_url = '';
    public string $meta_description = '';
    public string $meta_keywords = '';

    public function mount(Page $page): void
    {
        $this->page                = $page;
        $this->name                = (string) $page->name;
        $this->hero_eyebrow        = (string) ($page->hero_eyebrow ?? '');
        $this->hero_title          = (string) ($page->hero_title ?? '');
        $this->hero_sub            = (string) ($page->hero_sub ?? '');
        $this->hero_jp_tagline     = (string) ($page->hero_jp_tagline ?? '');
        $this->hero_meta           = $page->hero_meta ?? [];
        $this->cta_label           = (string) ($page->cta_label ?? '');
        $this->cta_url             = (string) ($page->cta_url ?? '');
        $this->secondary_cta_label = (string) ($page->secondary_cta_label ?? '');
        $this->secondary_cta_url   = (string) ($page->secondary_cta_url ?? '');
        $this->meta_description    = (string) ($page->meta_description ?? '');
        $this->meta_keywords       = (string) ($page->meta_keywords ?? '');
    }

    public function addMeta(): void
    {
        $this->hero_meta[] = ['label' => '', 'value' => ''];
    }

    public function removeMeta(int $i): void
    {
        unset($this->hero_meta[$i]);
        $this->hero_meta = array_values($this->hero_meta);
    }

    protected function rules(): array
    {
        return [
            'name'                => ['required', 'string', 'max:60'],
            'hero_eyebrow'        => ['nullable', 'string', 'max:80'],
            'hero_title'          => ['required', 'string', 'max:240'],
            'hero_sub'            => ['nullable', 'string', 'max:2000'],
            'hero_jp_tagline'     => ['nullable', 'string', 'max:120'],
            'hero_meta.*.label'   => ['required_with:hero_meta.*.value', 'nullable', 'string', 'max:60'],
            'hero_meta.*.value'   => ['required_with:hero_meta.*.label', 'nullable', 'string', 'max:120'],
            'cta_label'           => ['nullable', 'string', 'max:60'],
            'cta_url'             => ['nullable', 'string', 'max:240'],
            'secondary_cta_label' => ['nullable', 'string', 'max:60'],
            'secondary_cta_url'   => ['nullable', 'string', 'max:240'],
            'meta_description'    => ['nullable', 'string', 'max:240'],
            'meta_keywords'       => ['nullable', 'string', 'max:240'],
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $this->page->update([
            'name'                => $data['name'],
            'hero_eyebrow'        => $data['hero_eyebrow'] ?: null,
            'hero_title'          => $data['hero_title'],
            'hero_sub'            => $data['hero_sub'] ?: null,
            'hero_jp_tagline'     => $data['hero_jp_tagline'] ?: null,
            'hero_meta'           => collect($this->hero_meta)->filter(fn ($m) => trim($m['label'] ?? '') !== '')->values()->all(),
            'cta_label'           => $data['cta_label'] ?: null,
            'cta_url'             => $data['cta_url'] ?: null,
            'secondary_cta_label' => $data['secondary_cta_label'] ?: null,
            'secondary_cta_url'   => $data['secondary_cta_url'] ?: null,
            'meta_description'    => $data['meta_description'] ?: null,
            'meta_keywords'       => $data['meta_keywords'] ?: null,
        ]);

        session()->flash('status', 'ページを更新しました。');
    }

    public function render()
    {
        return view('livewire.admin.pages.edit', [
            'sections' => $this->page->sections()->orderBy('position')->get(),
        ]);
    }
}
