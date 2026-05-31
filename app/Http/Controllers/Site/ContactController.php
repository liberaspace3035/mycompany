<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\ContactSubmissionReceived;
use App\Models\ContactSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $submission = ContactSubmission::create([
            ...$data,
            'source_url' => $request->headers->get('referer'),
            'referrer'   => $request->headers->get('referer'),
            'user_agent' => $request->userAgent(),
            'ip'         => $request->ip(),
        ]);

        // 通知メール送信。失敗してもユーザーの送信完了は妨げない（受信は管理画面に残る）。
        try {
            Mail::to(config('mail.contact_to'))
                ->send(new ContactSubmissionReceived($submission));
        } catch (\Throwable $e) {
            Log::error('Contact notification mail failed', [
                'submission_id' => $submission->id,
                'error'         => $e->getMessage(),
            ]);
        }

        return redirect()->back()->with('contact_ok', true)->withFragment('contact');
    }
}
