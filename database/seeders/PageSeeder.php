<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // ===== HOME =====
        $home = Page::query()->updateOrCreate(['slug' => 'home'], [
            'name' => 'Home',
            'hero_eyebrow' => 'SYS // RENDERING',
            'hero_title' => "Make Agents\nfeel native.",     // 改行で2行
            'hero_sub' => 'Agentを特別な技術ではなく、創るための仲間に。HP制作・Webシステム・業務効率化を、Agent駆動でもっと自由に。Claude Code / Cursor / Gemini をチームメンバーのように使いこなします。',
            'hero_jp_tagline' => '創ることを、もっと身近に。',
            'hero_meta' => [
                ['label' => '// STACK',      'value' => 'Laravel · WordPress · Next'],
                ['label' => '// AI ENGINE',  'value' => 'Claude · Cursor · Gemini'],
                ['label' => '// THROUGHPUT', 'value' => '2.4×'],
                ['label' => '// STATUS',     'value' => 'ACCEPTING — Q3'],
            ],
            'cta_label' => '30分の無料ヒアリングへ',
            'cta_url' => '/company#contact',
            'secondary_cta_label' => 'サービスを見る',
            'secondary_cta_url' => '/services',
            'meta_description' => 'Liberaspace は AI / Agent 駆動でHP制作・Webシステム・業務効率化を提供する1人称のエンジニアリングカンパニーです。',
        ]);

        // index.html の主要セクションをまるごと payload に流し込む。
        // 値は後で管理画面から編集可能。
        $sections = [
            [
                'type' => 'at_a_glance',
                'heading' => 'AT A GLANCE',
                'payload' => [
                    'items' => [
                        ['label' => '01 / Coverage',  'num' => '3', 'unit' => '領域',   'desc' => 'HP制作 / Webシステム開発 / 業務効率化。事業を伸ばす3つの領域を一貫提供。'],
                        ['label' => '02 / Ownership', 'num' => '1', 'unit' => '人称',   'desc' => '企画・設計・実装・分析・運用。分業せず、一人称で責任を持って完走します。'],
                        ['label' => '03 / Velocity',  'num' => 'AI','unit' => '駆動',   'desc' => 'AIをチームメンバーのように使いこなし、高品質と短納期を両立します。'],
                    ],
                ],
            ],
            [
                'type' => 'services_grid',
                'heading' => '事業を伸ばす、3つのサービス領域。',
                'subheading' => '02 — Services',
                'payload' => [
                    'cards' => [
                        ['no' => '01', 'name' => 'HP / Web 制作', 'tag' => 'BRAND × CONVERSION', 'desc' => 'コーポレートサイト、サービスサイト、LPまで。ブランド体験とコンバージョンを両立する設計と実装。', 'tags' => ['コーポレートHP','LP','EFO/CRO']],
                        ['no' => '02', 'name' => 'Webシステム開発', 'tag' => 'PRODUCT × SCALE', 'desc' => '事業の中核になる業務システム / SaaS をゼロから。Laravel / Next.js を中心に堅牢かつ素早く。', 'tags' => ['SaaS','業務システム','API']],
                        ['no' => '03', 'name' => '業務効率化 / DX', 'tag' => 'OPS × AUTOMATION', 'desc' => 'AI / RPA / スクリプトで日次のオペレーションを自動化。手作業を「資産化」する仕組みを設計。', 'tags' => ['自動化','データ整備','AI活用']],
                    ],
                ],
            ],
            [
                'type' => 'ai_dev',
                'heading' => 'AI Native Development.',
                'subheading' => '03 — How we build',
                'payload' => [
                    'desc' => 'Claude Code / Cursor / Gemini を「チームメンバー」として開発の中核に据えています。手作業の半分はエージェントに任せ、人間は意思決定と品質保証に集中する開発スタイル。',
                    'tools' => [
                        ['name' => 'Claude Code',  'role' => 'Lead Engineer'],
                        ['name' => 'Cursor',       'role' => 'Pair Programmer'],
                        ['name' => 'Gemini',       'role' => 'Reviewer / Search'],
                    ],
                    'stats' => [
                        ['v' => '×2',  'l' => '開発速度'],
                        ['v' => '×N',  'l' => '同時並行プロジェクト'],
                        ['v' => '柔軟', 'l' => '見直しと再設計のコスト'],
                    ],
                ],
            ],
            [
                'type' => 'principles',
                'heading' => '4つの原則',
                'subheading' => '04 — Principles',
                'payload' => [
                    'items' => [
                        ['no' => '01', 'letters' => 'In', 'title' => 'Integrity', 'desc' => '誠実さ。出来ること・出来ないことを正直に伝え、関係性を長く育てる。'],
                        ['no' => '02', 'letters' => 'Lo', 'title' => 'Longevity', 'desc' => '永続性。作って終わりではなく、運用・改善まで継続的に伴走する。'],
                        ['no' => '03', 'letters' => 'Di', 'title' => 'Direct',    'desc' => '直接性。窓口を分けず、一人称で意思決定と実装まで完走する。'],
                        ['no' => '04', 'letters' => 'Ex', 'title' => 'Experiment','desc' => '実験性。新しいAIツール・新しい技術を、自社で試して案件に持ち込む。'],
                    ],
                ],
            ],
            [
                'type' => 'how',
                'heading' => '5ステップで進めます。',
                'subheading' => '05 — Method',
                'payload' => [
                    'steps' => [
                        ['no' => '01', 'name' => 'Hearing',    'desc' => '30分の無料ヒアリングで、課題と目的を整理'],
                        ['no' => '02', 'name' => 'Design',     'desc' => '要件定義 / 情報設計 / 画面設計をスピード優先で'],
                        ['no' => '03', 'name' => 'Build',      'desc' => 'AI駆動で実装。毎週レビューしながら短サイクルで'],
                        ['no' => '04', 'name' => 'Launch',     'desc' => '計測・SEO・問い合わせ導線まで整えてリリース'],
                        ['no' => '05', 'name' => 'Operate',    'desc' => '継続改善。データを見て次の打ち手を提案'],
                    ],
                ],
            ],
            [
                'type' => 'works_picks',
                'heading' => 'Selected Works',
                'subheading' => '06 — Works',
                'payload' => [
                    'note' => 'featured フラグが立っている Work を表示します。',
                ],
            ],
            [
                'type' => 'why',
                'heading' => 'Why Liberaspace',
                'subheading' => '07 — Why us',
                'payload' => [
                    'items' => [
                        ['title' => '一人称で完走',   'desc' => '営業 → 設計 → 実装 → 運用までを分業せず1人で。窓口が分散しない安心感。'],
                        ['title' => 'AI を中核に据える', 'desc' => '生成AI・Agent をチームの一員として扱い、品質を保ったまま速度を倍にします。'],
                        ['title' => '事業と技術の両輪', 'desc' => '事業視点の議論ができる技術者です。技術の正しさだけでなく、事業の伸びまで一緒に考えます。'],
                    ],
                ],
            ],
            [
                'type' => 'cta',
                'heading' => "Let's build\nyour next system.",
                'payload' => [
                    'desc' => 'まずは30分の無料ヒアリングから。事業の課題と、AI を使った具体的な解決策をその場で議論します。',
                    'primary' => ['label' => '30分の無料ヒアリングへ', 'url' => '/company#contact'],
                    'secondary' => ['label' => 'サービスを見る', 'url' => '/services'],
                ],
            ],
        ];

        foreach ($sections as $i => $row) {
            Section::query()->updateOrCreate(
                ['page_id' => $home->id, 'type' => $row['type']],
                [
                    'heading' => $row['heading'] ?? null,
                    'subheading' => $row['subheading'] ?? null,
                    'payload' => $row['payload'] ?? [],
                    'position' => $i,
                    'visible' => true,
                ],
            );
        }

        // ===== SERVICES =====
        Page::query()->updateOrCreate(['slug' => 'services'], [
            'name' => 'Services',
            'hero_eyebrow' => 'SERVICES // 2026',
            'hero_title' => "事業を伸ばす、\n3つのサービス領域。",
            'hero_sub' => '個別最適ではなく、事業のゴールから逆算してサービスを組み合わせます。',
            'cta_label' => '30分の無料ヒアリングへ',
            'cta_url' => '/company#contact',
            'meta_description' => 'Liberaspace の提供サービス一覧。HP/Web制作、Webシステム開発、業務効率化/DXの3領域をAI駆動で一気通貫で提供。事業のゴールから逆算した設計と実装で短納期と高品質を両立します。',
            'meta_keywords' => 'HP制作,Webシステム,業務効率化,DX,Laravel,Next.js,AI駆動開発',
        ]);

        // ===== WORKS =====
        Page::query()->updateOrCreate(['slug' => 'works'], [
            'name' => 'Works',
            'hero_eyebrow' => 'WORKS // 2026',
            'hero_title' => "これまで作ってきた、\n事業の「資産」たち。",
            'hero_sub' => 'HP制作・Webシステム・業務効率化の各領域での実績をご紹介します。守秘義務に配慮しつつ、可能な範囲で課題・アプローチ・成果を公開しています。',
            'meta_description' => 'Liberaspace の制作実績一覧。中小企業の自動見積システム、専門商社のコーポレートサイト、サブスクEC、SaaS の SEO改善など、HP/開発/DX 各領域のプロジェクトを公開しています。',
            'meta_keywords' => '実績,制作事例,ポートフォリオ,Laravel,Next.js,DX事例',
        ]);

        // ===== BLOG =====
        Page::query()->updateOrCreate(['slug' => 'blog'], [
            'name' => 'Blog',
            'hero_eyebrow' => 'JOURNAL // 2026',
            'hero_title' => "AIと開発の、\n現場のメモ。",
            'hero_sub' => '実プロジェクトで使った技術スタック・AI活用ノウハウ・運用改善の知見を、なるべく素直に記録しています。',
            'meta_description' => 'Liberaspace のブログ。Claude Code / Cursor / Gemini を実案件で使った知見、Laravel と Livewire の実装ノート、Three.js 演出のレシピなど、技術と事業の交差点で得た学びを発信します。',
            'meta_keywords' => 'ブログ,AI駆動開発,Claude Code,Cursor,Laravel,Livewire,Three.js',
        ]);

        // ===== COMPANY =====
        Page::query()->updateOrCreate(['slug' => 'company'], [
            'name' => 'Company',
            'hero_eyebrow' => 'COMPANY // 2026',
            'hero_title' => "技術と事業を、\n同じ頭で考える。",
            'hero_sub' => 'Liberaspace は AI / Agent 駆動の開発・分析・効率化を一人称で提供する個人事業です。代表自らが企画・設計・実装・運用まで完走します。',
            'cta_label' => '30分の無料ヒアリングへ',
            'cta_url' => '#contact',
            'meta_description' => 'Liberaspace の会社情報。AI / Agent 駆動の開発・分析・効率化を一人称で完走するエンジニアリングカンパニー。沿革、対応技術スタック、無料ヒアリングのお申込みフォームを掲載しています。',
            'meta_keywords' => '会社情報,Liberaspace,フリーランス,フルスタックエンジニア,お問い合わせ',
        ]);
    }
}
