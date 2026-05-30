<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Work;
use Illuminate\Http\Response;

// 動的 sitemap.xml。固定 5 ページ + 公開済 Post + 全 Work を含む。
class SitemapController extends Controller
{
    public function index(): Response
    {
        $entries = [];

        // 固定ページ
        $staticPages = [
            ['route' => 'home',          'priority' => '1.0', 'changefreq' => 'weekly'],
            ['route' => 'services',      'priority' => '0.8', 'changefreq' => 'monthly'],
            ['route' => 'works.index',   'priority' => '0.8', 'changefreq' => 'weekly'],
            ['route' => 'blog.index',    'priority' => '0.8', 'changefreq' => 'weekly'],
            ['route' => 'company',       'priority' => '0.7', 'changefreq' => 'monthly'],
        ];
        foreach ($staticPages as $p) {
            $entries[] = [
                'loc'        => route($p['route']),
                'lastmod'    => now()->toDateString(),
                'changefreq' => $p['changefreq'],
                'priority'   => $p['priority'],
            ];
        }

        // 公開済の Post
        Post::published()->orderByDesc('published_at')->get()->each(function (Post $post) use (&$entries) {
            $entries[] = [
                'loc'        => route('blog.show', $post->slug),
                'lastmod'    => ($post->updated_at ?? $post->published_at)?->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => '0.6',
            ];
        });

        // 全 Work
        Work::orderBy('position')->get()->each(function (Work $work) use (&$entries) {
            $entries[] = [
                'loc'        => route('works.show', $work->slug),
                'lastmod'    => $work->updated_at?->toDateString(),
                'changefreq' => 'monthly',
                'priority'   => '0.6',
            ];
        });

        return response()
            ->view('sitemap', ['entries' => $entries])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
