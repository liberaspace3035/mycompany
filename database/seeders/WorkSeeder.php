<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    public function run(): void
    {
        // 既に実績が登録されていれば再投入しない（デプロイ等での上書き・復活を防ぐ）。
        if (Work::query()->exists()) {
            return;
        }

        $rows = [
            [
                'slug' => 'auto-quote-system',
                'title' => '中小企業向け 自動見積システム',
                'category' => 'DX / Operations',
                'year' => '2026',
                'tags' => ['DX', 'Laravel', 'AWS'],
                'summary' => '営業担当が手入力していた見積書を完全システム化。条件選択だけで PDF が即時生成される仕組みに。',
                'featured' => true,
                'position' => 1,
            ],
            [
                'slug' => 'specialty-trading-renewal',
                'title' => '専門商社のコーポレートサイトリニューアル',
                'category' => 'HP / Web',
                'year' => '2026',
                'tags' => ['Web', 'WordPress', 'SEO'],
                'summary' => '10年以上更新されていなかった会社サイトを全面刷新。SEO・GA4 計測まで整備し、問い合わせ導線を再設計。',
                'featured' => true,
                'position' => 2,
            ],
            [
                'slug' => 'subscription-ec',
                'title' => 'サブスクリプション型 EC プラットフォーム',
                'category' => 'Development',
                'year' => '2025',
                'tags' => ['EC', 'Stripe', 'Next.js'],
                'summary' => 'Stripe Billing と連携した定期購入 EC を構築。配送頻度の切替やスキップ機能まで作り込み、解約率を低減。',
                'featured' => true,
                'position' => 3,
            ],
            [
                'slug' => 'skill-matching-app',
                'title' => 'スキルマッチング Web アプリケーション',
                'category' => 'Development',
                'year' => '2025',
                'tags' => ['App', 'Laravel', 'Vue'],
                'summary' => 'フリーランスと発注企業をつなぐマッチングプラットフォームをゼロから構築。スコアリングと提案機能を内製。',
                'featured' => true,
                'position' => 4,
            ],
            [
                'slug' => 'saas-seo-geo',
                'title' => 'SaaS 企業の SEO / GEO 改善プロジェクト',
                'category' => 'SEO / Growth',
                'year' => '2025',
                'tags' => ['SEO', 'GEO', 'GA4'],
                'summary' => 'GA4 と Search Console のデータから流入経路を再分析。生成AI検索（GEO）に対応したコンテンツ設計まで実施。',
                'featured' => false,
                'position' => 5,
            ],
            [
                'slug' => 'legal-document-generator',
                'title' => '士業向け 顧客管理 + 申請書自動生成ツール',
                'category' => 'DX / Operations',
                'year' => '2025',
                'tags' => ['DX', 'Laravel', 'PDF'],
                'summary' => '顧客情報の入力から申請書 PDF 生成までを一気通貫化。月次の事務作業を大幅に短縮し、顧問業務に時間を回せる体制へ。',
                'featured' => false,
                'position' => 6,
            ],
        ];

        foreach ($rows as $row) {
            Work::query()->updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
