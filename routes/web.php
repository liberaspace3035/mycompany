<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Site\PageController;
use Illuminate\Support\Facades\Route;

// ===== 公開サイト =====
Route::get('/',         [PageController::class, 'home'])->name('home');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/works',    [PageController::class, 'works'])->name('works.index');
Route::get('/works/{slug}', [PageController::class, 'workDetail'])->name('works.show');
Route::get('/blog',     [PageController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [PageController::class, 'blogDetail'])->name('blog.show');
Route::get('/company',  [PageController::class, 'company'])->name('company');

// 公開フォームの受信
Route::post('/contact', [\App\Http\Controllers\Site\ContactController::class, 'store'])
    ->name('contact.store');

// SEO 用エンドポイント
Route::get('/sitemap.xml', [\App\Http\Controllers\Site\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    // APP_URL から sitemap への絶対 URL を組み立てる
    $body = "User-agent: *\nDisallow:\n\nSitemap: " . url('/sitemap.xml') . "\n";
    return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
});

// ===== 管理画面 =====
// /admin/ 以下は auth 必須。Livewire コンポーネントを各 CRUD として直接ルートに割り当て。
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/works',              \App\Livewire\Admin\Works\Index::class)->name('works.index');
    Route::get('/works/create',       \App\Livewire\Admin\Works\Edit::class)->name('works.create');
    Route::get('/works/{work}/edit',  \App\Livewire\Admin\Works\Edit::class)->name('works.edit');

    Route::get('/posts',              \App\Livewire\Admin\Posts\Index::class)->name('posts.index');
    Route::get('/posts/create',       \App\Livewire\Admin\Posts\Edit::class)->name('posts.create');
    Route::get('/posts/{post}/edit',  \App\Livewire\Admin\Posts\Edit::class)->name('posts.edit');

    Route::get('/services',                    \App\Livewire\Admin\Services\Index::class)->name('services.index');
    Route::get('/services/create',             \App\Livewire\Admin\Services\Edit::class)->name('services.create');
    Route::get('/services/{service}/edit',     \App\Livewire\Admin\Services\Edit::class)->name('services.edit');

    Route::get('/timeline',                 \App\Livewire\Admin\Timeline\Index::class)->name('timeline.index');
    Route::get('/timeline/create',          \App\Livewire\Admin\Timeline\Edit::class)->name('timeline.create');
    Route::get('/timeline/{entry}/edit',    \App\Livewire\Admin\Timeline\Edit::class)->name('timeline.edit');

    Route::get('/skills',               \App\Livewire\Admin\Skills\Index::class)->name('skills.index');
    Route::get('/skills/create',        \App\Livewire\Admin\Skills\Edit::class)->name('skills.create');
    Route::get('/skills/{skill}/edit',  \App\Livewire\Admin\Skills\Edit::class)->name('skills.edit');

    Route::get('/pages',              \App\Livewire\Admin\Pages\Index::class)->name('pages.index');
    Route::get('/pages/{page}/edit',  \App\Livewire\Admin\Pages\Edit::class)->name('pages.edit');

    Route::get('/pages/{page}/sections/{section}/edit', \App\Livewire\Admin\Sections\Edit::class)->name('sections.edit');

    Route::get('/inbox',               \App\Livewire\Admin\Inbox\Index::class)->name('inbox.index');
    Route::get('/inbox/{submission}',  \App\Livewire\Admin\Inbox\Show::class)->name('inbox.show');

    Route::get('/settings',  \App\Livewire\Admin\SiteSettings\Edit::class)->name('settings.edit');
});

// Breeze 由来。ログイン後のプロフィール編集。
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
