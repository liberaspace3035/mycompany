<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:160'],
            'company' => ['nullable', 'string', 'max:160'],
            'body'    => ['required', 'string', 'max:8000'],
        ]);

        ContactSubmission::create([
            ...$data,
            'source_url' => $request->headers->get('referer'),
            'referrer'   => $request->headers->get('referer'),
            'user_agent' => $request->userAgent(),
            'ip'         => $request->ip(),
        ]);

        // TODO: 通知メール送信。MAIL_* が本番で設定されたら mail()->to($settings->contact_email)->send(...) を追加
        return redirect()->back()->with('contact_ok', true)->withFragment('contact');
    }
}
