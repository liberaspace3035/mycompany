<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Post;
use App\Models\Work;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'works_count' => Work::count(),
            'featured_count' => Work::where('featured', true)->count(),
            'posts_count' => Post::count(),
            'unread_count' => ContactSubmission::where('read', false)->count(),
            'recent_inbox' => ContactSubmission::latest()->limit(5)->get(),
        ]);
    }
}
