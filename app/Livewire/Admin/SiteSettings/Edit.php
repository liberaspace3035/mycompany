<?php

namespace App\Livewire\Admin\SiteSettings;

use App\Models\SiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'サイト設定'])]
#[Title('サイト設定')]
class Edit extends Component
{
    public SiteSetting $settings;

    public string $site_name = '';
    public string $contact_email = '';
    public string $footer_tagline = '';
    public array $nav_items = [];        // [['label' => '', 'url' => '']]
    public array $footer_columns = [];   // [['heading' => '', 'links' => [['label'=>'','url'=>'']]]]

    public function mount(): void
    {
        $this->settings       = SiteSetting::current();
        $this->site_name      = (string) $this->settings->site_name;
        $this->contact_email  = (string) $this->settings->contact_email;
        $this->footer_tagline = (string) $this->settings->footer_tagline;
        $this->nav_items      = $this->settings->nav_items ?? [];
        $this->footer_columns = $this->settings->footer_columns ?? [];
    }

    public function addNavItem(): void
    {
        $this->nav_items[] = ['label' => '', 'url' => ''];
    }

    public function removeNavItem(int $i): void
    {
        unset($this->nav_items[$i]);
        $this->nav_items = array_values($this->nav_items);
    }

    public function addFooterCol(): void
    {
        $this->footer_columns[] = ['heading' => '', 'links' => [['label' => '', 'url' => '']]];
    }

    public function removeFooterCol(int $i): void
    {
        unset($this->footer_columns[$i]);
        $this->footer_columns = array_values($this->footer_columns);
    }

    public function addFooterLink(int $col): void
    {
        $this->footer_columns[$col]['links'][] = ['label' => '', 'url' => ''];
    }

    public function removeFooterLink(int $col, int $link): void
    {
        unset($this->footer_columns[$col]['links'][$link]);
        $this->footer_columns[$col]['links'] = array_values($this->footer_columns[$col]['links']);
    }

    protected function rules(): array
    {
        return [
            'site_name'      => ['required', 'string', 'max:120'],
            'contact_email'  => ['nullable', 'email', 'max:160'],
            'footer_tagline' => ['nullable', 'string', 'max:240'],
            'nav_items.*.label'              => ['required_with:nav_items.*.url', 'nullable', 'string', 'max:60'],
            'nav_items.*.url'                => ['required_with:nav_items.*.label', 'nullable', 'string', 'max:240'],
            'footer_columns.*.heading'       => ['required', 'string', 'max:60'],
            'footer_columns.*.links.*.label' => ['required', 'string', 'max:60'],
            'footer_columns.*.links.*.url'   => ['required', 'string', 'max:240'],
        ];
    }

    public function save()
    {
        $data = $this->validate();

        $this->settings->update([
            'site_name'      => $data['site_name'],
            'contact_email'  => $data['contact_email'] ?: null,
            'footer_tagline' => $data['footer_tagline'] ?: null,
            'nav_items'      => collect($this->nav_items)->filter(fn ($i) => trim($i['label'] ?? '') !== '')->values()->all(),
            'footer_columns' => $this->footer_columns,
        ]);

        session()->flash('status', 'サイト設定を更新しました。');
    }

    public function render()
    {
        return view('livewire.admin.site-settings.edit');
    }
}
