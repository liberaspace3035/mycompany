<?php

namespace App\Support;

// 実績カードのプレゼンテーション補助。
// カテゴリ名 ("HP / Web", "DX / Operations") をサムネ右上の短いタグ
// ("WEB", "DX") に圧縮する。
class WorkUi
{
    public static function shortTag(?string $category): string
    {
        $category = $category ?? '';
        $map = [
            'HP / Web'        => 'web',
            'Development'     => 'dev',
            'DX / Operations' => 'dx',
            'SEO / Growth'    => 'seo',
            'EC / Commerce'   => 'ec',
            'App'             => 'app',
        ];
        if (isset($map[$category])) {
            return $map[$category];
        }

        // フォールバック: 最初の単語 (英語) / 全角は最初の2文字
        if (preg_match('/^([A-Za-z]+)/', $category, $m)) {
            return strtolower($m[1]);
        }
        return mb_substr($category, 0, 2);
    }
}
