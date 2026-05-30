<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Skill;
use App\Models\TimelineEntry;
use App\Models\Work;
use App\Support\Seo;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::with('sections')->where('slug', 'home')->firstOrFail();
        $works = Work::featured()->take(5)->get();

        // home はブランド名先頭の特別な title
        $seo = Seo::forPage($page, Seo::oneLine($page->hero_title ?? 'Make Agents feel native.'));

        return view('pages.home', [
            'page'   => $page,
            'works'  => $works,
            'active' => 'home',
            'seo'    => $seo,
        ]);
    }

    public function services()
    {
        $page = Page::with('sections')->where('slug', 'services')->firstOrFail();
        $services = Service::orderBy('position')->get();

        return view('pages.services', [
            'page'     => $page,
            'services' => $services,
            'active'   => 'services',
            'seo'      => Seo::forPage($page, items: $services),
        ]);
    }

    public function works(Request $request)
    {
        $page = Page::with('sections')->where('slug', 'works')->firstOrFail();
        $works = Work::query()
            ->when($request->string('category')->isNotEmpty(), fn ($q) => $q->where('category', $request->string('category')))
            ->orderBy('position')
            ->get();

        return view('pages.works', [
            'page'   => $page,
            'works'  => $works,
            'active' => 'works',
            'seo'    => Seo::forPage($page, items: $works),
        ]);
    }

    public function workDetail(string $slug)
    {
        $work = Work::where('slug', $slug)->firstOrFail();

        return view('pages.work-detail', [
            'work'   => $work,
            'active' => 'works',
            'seo'    => Seo::forWork($work),
        ]);
    }

    public function blog()
    {
        $page = Page::with('sections')->where('slug', 'blog')->firstOrFail();
        $posts = Post::with('category')->published()->latest('published_at')->get();
        $featured = $posts->firstWhere('featured', true) ?? $posts->first();

        return view('pages.blog', [
            'page'     => $page,
            'posts'    => $posts,
            'featured' => $featured,
            'active'   => 'blog',
            'seo'      => Seo::forPage($page, items: $posts),
        ]);
    }

    public function blogDetail(string $slug)
    {
        $post = Post::with('category')->where('slug', $slug)->published()->firstOrFail();

        return view('pages.blog-detail', [
            'post'   => $post,
            'active' => 'blog',
            'seo'    => Seo::forBlogPost($post),
        ]);
    }

    public function company()
    {
        $page = Page::with('sections')->where('slug', 'company')->firstOrFail();
        $timeline = TimelineEntry::orderBy('position')->get();
        $skills = Skill::orderBy('category')->orderBy('position')->get()->groupBy('category');

        return view('pages.company', [
            'page'     => $page,
            'timeline' => $timeline,
            'skills'   => $skills,
            'active'   => 'company',
            'seo'      => Seo::forPage($page),
        ]);
    }
}
