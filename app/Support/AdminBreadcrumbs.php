<?php

namespace App\Support;

// 管理画面のトップバー用パンくず生成。
// ルート名 → [['label' => '...', 'url' => '...'], ...]
//
// 追加ルートはここに 1 行足すだけ。url を null にすると "現在地" (リンクなし) になる。
class AdminBreadcrumbs
{
    /**
     * @return array<int, array{label: string, url: ?string}>
     */
    public static function for(?string $routeName): array
    {
        if (! $routeName || ! str_starts_with($routeName, 'admin.')) {
            return [];
        }

        return match ($routeName) {
            'admin.dashboard' => [
                ['label' => 'ダッシュボード', 'url' => null],
            ],

            'admin.pages.index' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'ページ',     'url' => null],
            ],
            'admin.pages.edit' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'ページ',     'url' => route('admin.pages.index')],
                ['label' => '編集',       'url' => null],
            ],
            'admin.sections.edit' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'ページ',     'url' => route('admin.pages.index')],
                ['label' => 'セクション', 'url' => null],
            ],

            'admin.works.index' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => '実績',       'url' => null],
            ],
            'admin.works.create' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => '実績',       'url' => route('admin.works.index')],
                ['label' => '新規作成',   'url' => null],
            ],
            'admin.works.edit' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => '実績',       'url' => route('admin.works.index')],
                ['label' => '編集',       'url' => null],
            ],

            'admin.posts.index' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'ブログ',     'url' => null],
            ],
            'admin.posts.create' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'ブログ',     'url' => route('admin.posts.index')],
                ['label' => '新規作成',   'url' => null],
            ],
            'admin.posts.edit' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'ブログ',     'url' => route('admin.posts.index')],
                ['label' => '編集',       'url' => null],
            ],

            'admin.services.index' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'サービス',   'url' => null],
            ],
            'admin.services.create' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'サービス',   'url' => route('admin.services.index')],
                ['label' => '新規作成',   'url' => null],
            ],
            'admin.services.edit' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'サービス',   'url' => route('admin.services.index')],
                ['label' => '編集',       'url' => null],
            ],

            'admin.timeline.index' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => '沿革',       'url' => null],
            ],
            'admin.timeline.create' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => '沿革',       'url' => route('admin.timeline.index')],
                ['label' => '新規作成',   'url' => null],
            ],
            'admin.timeline.edit' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => '沿革',       'url' => route('admin.timeline.index')],
                ['label' => '編集',       'url' => null],
            ],

            'admin.skills.index' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'スキル',     'url' => null],
            ],
            'admin.skills.create' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'スキル',     'url' => route('admin.skills.index')],
                ['label' => '新規作成',   'url' => null],
            ],
            'admin.skills.edit' => [
                ['label' => 'コンテンツ', 'url' => null],
                ['label' => 'スキル',     'url' => route('admin.skills.index')],
                ['label' => '編集',       'url' => null],
            ],

            'admin.inbox.index' => [
                ['label' => '問い合わせ', 'url' => null],
            ],
            'admin.inbox.show' => [
                ['label' => '問い合わせ', 'url' => route('admin.inbox.index')],
                ['label' => '詳細',       'url' => null],
            ],

            'admin.settings.edit' => [
                ['label' => '設定',       'url' => null],
                ['label' => 'サイト設定', 'url' => null],
            ],

            default => [
                ['label' => '管理画面', 'url' => null],
            ],
        };
    }
}
