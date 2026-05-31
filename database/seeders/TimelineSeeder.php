<?php

namespace Database\Seeders;

use App\Models\TimelineEntry;
use Illuminate\Database\Seeder;

class TimelineSeeder extends Seeder
{
    public function run(): void
    {
        // 既にタイムラインが登録されていれば再投入しない（毎回の全消去・上書きを防ぐ）。
        if (TimelineEntry::query()->exists()) {
            return;
        }

        $rows = [
            ['date' => '2025.08', 'title' => 'フリーランス開業',     'description' => 'Web制作・開発・運用を一人称で受注開始。'],
            ['date' => '2025.10', 'title' => 'Liberaspace 屋号で活動', 'description' => '3領域（HP/開発/効率化）をワンストップで提供する屋号として再定義。'],
            ['date' => '2025.11', 'title' => 'AI 駆動開発に全面移行', 'description' => 'Claude Code / Cursor を全案件で主軸ツールに採用。'],
            ['date' => '2026.04', 'title' => 'サイトリニューアル',   'description' => 'デザイン / コピーをフル刷新。"Make Agents feel native." を旗印に。'],
        ];

        TimelineEntry::query()->delete();

        foreach ($rows as $i => $r) {
            TimelineEntry::query()->create([
                'date' => $r['date'],
                'title' => $r['title'],
                'description' => $r['description'],
                'position' => $i,
            ]);
        }
    }
}
