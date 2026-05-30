<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'slug' => 'hp',
                'name' => 'HP / Web 制作',
                'eyebrow' => 'SERVICE 01',
                'summary' => 'コーポレートサイト、サービスサイト、LP までブランドと CV の両立を設計から実装まで一貫提供。',
                'features' => [
                    'コーポレート / サービスサイト',
                    'ランディングページ (LP)',
                    'リブランディング・刷新',
                    'EFO / CRO 改善',
                    'GA4 / Search Console 計測整備',
                ],
                'keywords' => ['WordPress', 'Next.js', 'Astro', 'Tailwind'],
                'pricing' => [
                    ['plan' => 'Light',   'price' => '¥600,000〜',  'scope' => ['〜5ページ', '既製テンプレベース', 'スマホ対応', '基本SEO']],
                    ['plan' => 'Standard','price' => '¥1,400,000〜','scope' => ['〜15ページ', 'オリジナルデザイン', 'CMS導入', 'GA4 計測'], 'featured' => true],
                    ['plan' => 'Custom',  'price' => '¥3,000,000〜','scope' => ['ブランド設計', '3Dアニメ等の演出', '多言語/会員機能', '半年伴走']],
                ],
                'position' => 1,
            ],
            [
                'slug' => 'web',
                'name' => 'Webシステム開発',
                'eyebrow' => 'SERVICE 02',
                'summary' => '業務システム / SaaS / 社内ツールを Laravel / Next.js 中心にゼロから。AI 駆動で短サイクル開発。',
                'features' => [
                    '業務系 SaaS / 社内システム',
                    '管理画面 / 顧客管理',
                    'API 連携・自動化',
                    '既存システムの保守 / 引取',
                ],
                'keywords' => ['Laravel', 'Next.js', 'TypeScript', 'PostgreSQL'],
                'pricing' => [
                    ['plan' => 'PoC',      'price' => '¥800,000〜',   'scope' => ['2〜4週', '最小機能の検証', '使う・使わないの判断材料']],
                    ['plan' => 'MVP',      'price' => '¥2,500,000〜', 'scope' => ['8〜12週', '本番運用可能な最小プロダクト', 'ユーザー認証/管理画面/CI'], 'featured' => true],
                    ['plan' => 'Scale',    'price' => '¥要相談',       'scope' => ['長期伴走', '機能拡張 / 性能改善', '保守 / SLA']],
                ],
                'position' => 2,
            ],
            [
                'slug' => 'dx',
                'name' => '業務効率化 / DX',
                'eyebrow' => 'SERVICE 03',
                'summary' => '日次オペレーションを AI / RPA / スクリプトで自動化。手作業を「資産」に変える仕組みを設計。',
                'features' => [
                    'AI を使った自動化 (Claude / Gemini)',
                    'ノーコード / ローコード化',
                    'データ整備 / ETL',
                    '業務マニュアル化と教育',
                ],
                'keywords' => ['Claude', 'GAS', 'Python', 'Zapier'],
                'pricing' => [
                    ['plan' => 'Diagnosis', 'price' => '¥200,000〜', 'scope' => ['業務棚卸し', '自動化ロードマップ', 'ROI 試算']],
                    ['plan' => 'Sprint',    'price' => '¥800,000〜', 'scope' => ['2〜4週', '1〜2業務を自動化', '運用引き継ぎまで'], 'featured' => true],
                    ['plan' => 'Retainer',  'price' => '¥150,000/月〜','scope' => ['月次の継続改善', '小ロットで自動化を積み増し']],
                ],
                'position' => 3,
            ],
        ];

        foreach ($rows as $row) {
            Service::query()->updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
