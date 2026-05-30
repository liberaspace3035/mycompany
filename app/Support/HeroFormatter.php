<?php

namespace App\Support;

// プロトタイプ時代の手書きスパン (.shake, .accent, .hi) を、
// プレーンテキストから自動付与するためのヘルパ。
// 管理画面では生のテキストを入力すれば、装飾は自動で付く。
class HeroFormatter
{
    /**
     * 見出し1行を整形。'feel native.' のような行は
     * 末尾の単語 (=最後の半角空白以降) を .accent でラップ、
     * 最初に出てくる主役単語 ('Agents' などの大文字始まりの単語1つ) を .shake でラップ。
     */
    public static function renderHeadlineRow(string $row): string
    {
        $row = trim($row);
        if ($row === '') {
            return '';
        }

        // 末尾の "native." のような単語をアクセント色に
        $row = preg_replace_callback('/(\s)([^\s]+)$/u', function ($m) {
            // 終端記号 (。.) と単語を分離してアクセント
            if (preg_match('/^(.*?)([。\.!?！？]?)$/u', $m[2], $mm)) {
                $word = $mm[1];
                $punct = $mm[2] ?? '';
                return $m[1] . '<span class="accent">' . e($word) . '</span>' . e($punct);
            }
            return $m[1] . '<span class="accent">' . e($m[2]) . '</span>';
        }, e($row), 1);

        // 最初に出てくる主役単語 (大文字始まり + アルファベット連続) を .shake で揺らす
        $row = preg_replace_callback('/(?<![\w])([A-Z][A-Za-z]+)(?![\w])/', function ($m) {
            return '<span class="word shake">' . $m[1] . '</span>';
        }, $row, 1);

        return $row;
    }

    /**
     * Hero のサブ段落。最初の1文を <strong>、本文中の「。」を含む短いフレーズ単位で
     * 1つだけ .hi マーカーを付ける素朴な装飾。複雑な装飾が必要なら HTML を直接入れて
     * このメソッドを通さずに表示する運用に切り替える。
     */
    public static function renderSub(?string $text): string
    {
        if (! $text) {
            return '';
        }
        $text = trim($text);
        $sentences = preg_split('/(?<=。)/u', $text);
        $sentences = array_values(array_filter($sentences, fn ($s) => trim($s) !== ''));

        $html = '';
        foreach ($sentences as $i => $s) {
            $s = e($s);
            if ($i === 0) {
                $html .= '<strong>' . $s . '</strong> ';
            } elseif ($i === 1) {
                $html .= '<span class="hi">' . $s . '</span> ';
            } else {
                $html .= $s . ' ';
            }
        }

        return trim($html);
    }
}
