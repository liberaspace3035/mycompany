<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Service 編集'])]
#[Title('Service 編集')]
class Edit extends Component
{
    public ?Service $service = null;

    public string $name = '';
    public string $slug = '';
    public string $eyebrow = '';
    public string $summary = '';
    public int $position = 0;
    public string $featuresRaw = '';     // 改行区切り
    public string $keywordsRaw = '';     // カンマ区切り
    public array $pricing = [];          // [['plan'=>'','price'=>'','scope'=>['','',...],'featured'=>false]]

    public function mount(?Service $service = null): void
    {
        if ($service && $service->exists) {
            $this->service     = $service;
            $this->name        = $service->name;
            $this->slug        = $service->slug;
            $this->eyebrow     = (string) ($service->eyebrow ?? '');
            $this->summary     = (string) ($service->summary ?? '');
            $this->position    = (int) $service->position;
            $this->featuresRaw = collect($service->features ?? [])->implode("\n");
            $this->keywordsRaw = collect($service->keywords ?? [])->implode(', ');
            $this->pricing     = collect($service->pricing ?? [])
                ->map(fn ($p) => [
                    'plan'     => $p['plan'] ?? '',
                    'price'    => $p['price'] ?? '',
                    'scope'    => $p['scope'] ?? [],
                    'featured' => (bool) ($p['featured'] ?? false),
                    'scopeRaw' => collect($p['scope'] ?? [])->implode("\n"),
                ])
                ->all();
        } else {
            $this->position = (Service::max('position') ?? 0) + 1;
        }
    }

    public function addPricing(): void
    {
        $this->pricing[] = ['plan' => '', 'price' => '', 'scope' => [], 'featured' => false, 'scopeRaw' => ''];
    }

    public function removePricing(int $i): void
    {
        unset($this->pricing[$i]);
        $this->pricing = array_values($this->pricing);
    }

    protected function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:120'],
            'slug'        => ['required', 'string', 'max:120', 'regex:/^[a-z0-9-]+$/', Rule::unique('services', 'slug')->ignore($this->service?->id)],
            'eyebrow'     => ['nullable', 'string', 'max:60'],
            'summary'     => ['nullable', 'string', 'max:2000'],
            'position'    => ['integer', 'min:0'],
            'featuresRaw' => ['nullable', 'string', 'max:2000'],
            'keywordsRaw' => ['nullable', 'string', 'max:255'],
            'pricing.*.plan'     => ['required_with:pricing.*.price', 'nullable', 'string', 'max:60'],
            'pricing.*.price'    => ['required_with:pricing.*.plan', 'nullable', 'string', 'max:60'],
            'pricing.*.scopeRaw' => ['nullable', 'string', 'max:2000'],
            'pricing.*.featured' => ['boolean'],
        ];
    }

    public function updatedName(string $value): void
    {
        if (! $this->service && $this->slug === '') {
            $this->slug = Str::slug($value) ?: Str::lower(Str::random(8));
        }
    }

    public function save()
    {
        $data = $this->validate();

        $payload = [
            'name'     => $data['name'],
            'slug'     => $data['slug'],
            'eyebrow'  => $data['eyebrow'] ?: null,
            'summary'  => $data['summary'] ?: null,
            'position' => (int) $data['position'],
            'features' => collect(preg_split('/\r?\n/', $data['featuresRaw'] ?? ''))->map('trim')->filter()->values()->all(),
            'keywords' => collect(explode(',', $data['keywordsRaw'] ?? ''))->map('trim')->filter()->values()->all(),
            'pricing'  => collect($this->pricing)->map(fn ($p) => [
                'plan'     => trim($p['plan'] ?? ''),
                'price'    => trim($p['price'] ?? ''),
                'scope'    => collect(preg_split('/\r?\n/', $p['scopeRaw'] ?? ''))->map('trim')->filter()->values()->all(),
                'featured' => (bool) ($p['featured'] ?? false),
            ])->filter(fn ($p) => $p['plan'] !== '' || $p['price'] !== '')->values()->all(),
        ];

        if ($this->service) {
            $this->service->update($payload);
            session()->flash('status', 'サービスを更新しました。');
        } else {
            Service::create($payload);
            session()->flash('status', 'サービスを作成しました。');
        }

        return redirect()->route('admin.services.index');
    }

    public function render()
    {
        return view('livewire.admin.services.edit');
    }
}
