<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $cats = Category::all()->keyBy('slug');

        $posts = [
            [
                'slug' => 'claude-code-real-projects',
                'title' => 'Claude Code を実案件で1年使ってわかった、向き/不向き',
                'category' => 'ai',
                'summary' => 'Claude Code を15案件で実運用した結果、強いタスクと弱いタスクが見えてきました。実例ベースで整理します。',
                'body_md' => <<<MD
# はじめに

2025年以降、Claude Code を主要な開発ツールとして15以上の案件で使ってきました。本記事では、実プロジェクトで「強かったタスク」と「向いていなかったタスク」を実例ベースで整理します。

## 向いているタスク

- **既存コードベースの理解と改修** — `Read` / `Glob` / `Grep` を駆使した探索が圧倒的に速い
- **API クライアントの生成** — OpenAPI / GraphQL からの自動生成と境界実装
- **テストコードの追加** — 既存実装からテストを逆算するのが得意

## 向いていないタスク

- **設計の意思決定** — 制約条件が曖昧なとき、選択肢は出るが意思決定はできない
- **長期間にわたるリファクタ** — コンテキストを跨ぐと一貫性が落ちる

…
MD,
                'featured' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'slug' => 'laravel-13-livewire-4',
                'title' => 'Laravel 13 + Livewire 4 で管理画面を作る最短手順',
                'category' => 'tech',
                'summary' => 'Filament を使わずフルスクラッチで管理画面を作るときの、最小構成の手順をまとめました。',
                'body_md' => <<<MD
# 概要

Livewire 4 のコンポーネントだけで、認証付きの管理画面をゼロから組み立てます。

## ステップ

1. `composer require livewire/livewire`
2. `php artisan make:livewire Admin/Works/Index`
3. Blade 側でリスト/フィルタを書く
4. ルートを `routes/web.php` でグループ化

…
MD,
                'featured' => false,
                'published_at' => now()->subDays(10),
            ],
            [
                'slug' => 'three-js-hero-without-bundler',
                'title' => 'バンドラなしで Three.js のヒーロー演出を組む',
                'category' => 'design',
                'summary' => 'CDN から直接 Three.js を読み、Vite を経由せずヒーローセクションに 3D アニメーションを載せる構成例。',
                'body_md' => <<<MD
# モチベーション

マーケティングサイトでは、SPA フレームワーク不要なケースがほとんど。バンドラなしで Three.js を導入できれば、ビルド設定を捨てて速い。

## 構成

```html
<script src="https://unpkg.com/three@0.160.0/build/three.min.js"></script>
<canvas id="hero3d"></canvas>
```

あとは `THREE.WebGLRenderer({ canvas })` を素のスクリプトで初期化するだけです。

…
MD,
                'featured' => false,
                'published_at' => now()->subDays(20),
            ],
        ];

        foreach ($posts as $p) {
            Post::query()->updateOrCreate(['slug' => $p['slug']], [
                'title' => $p['title'],
                'category_id' => $cats[$p['category']]->id ?? null,
                'summary' => $p['summary'],
                'body_md' => $p['body_md'],
                'featured' => $p['featured'],
                'published_at' => $p['published_at'],
            ]);
        }
    }
}
