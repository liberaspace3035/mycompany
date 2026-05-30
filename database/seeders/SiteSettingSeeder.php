<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->updateOrCreate(['id' => 1], [
            'site_name' => 'Liberaspace',
            'contact_email' => 'hello@liberaspace.net',
            'nav_items' => [
                ['label' => 'Services', 'url' => '/services'],
                ['label' => 'Works',    'url' => '/works'],
                ['label' => 'Blog',     'url' => '/blog'],
                ['label' => 'Company',  'url' => '/company'],
            ],
            'footer_tagline' => 'Make Agents feel native. / 創ることを、もっと身近に。',
            'footer_columns' => [
                [
                    'heading' => 'Services',
                    'links' => [
                        ['label' => 'HP制作',          'url' => '/services#hp'],
                        ['label' => 'Webシステム開発',  'url' => '/services#web'],
                        ['label' => '業務効率化 / DX',  'url' => '/services#dx'],
                    ],
                ],
                [
                    'heading' => 'Company',
                    'links' => [
                        ['label' => '会社情報',        'url' => '/company'],
                        ['label' => '実績',            'url' => '/works'],
                        ['label' => 'ブログ',          'url' => '/blog'],
                    ],
                ],
                [
                    'heading' => 'Contact',
                    'links' => [
                        ['label' => '30分の無料ヒアリング', 'url' => '/company#contact'],
                    ],
                ],
            ],
        ]);
    }
}
