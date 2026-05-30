<?php

namespace Database\Seeders;

use App\Models\TimelineEntry;
use Illuminate\Database\Seeder;

class TimelineSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['date' => '2020.04', 'title' => 'フリーランス開業',     'description' => 'Web制作・開発・運用を一人称で受注開始。'],
            ['date' => '2022.10', 'title' => 'Liberaspace 屋号で活動', 'description' => '3領域（HP/開発/効率化）をワンストップで提供する屋号として再定義。'],
            ['date' => '2024.06', 'title' => 'AI 駆動開発に全面移行', 'description' => 'Claude Code / Cursor を全案件で主軸ツールに採用。'],
            ['date' => '2026.04', 'title' => 'サイトリニューアル',   'description' => 'デザイン / コピーをフル刷新。"Make Agents feel native." を旗印に。'],
        ];

        foreach ($rows as $i => $r) {
            TimelineEntry::query()->updateOrCreate(
                ['date' => $r['date'], 'title' => $r['title']],
                ['description' => $r['description'], 'position' => $i],
            );
        }
    }
}
