<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせ</title>
</head>
<body style="margin:0;padding:24px;background:#f5f5f4;font-family:-apple-system,BlinkMacSystemFont,'Hiragino Sans','Noto Sans JP',sans-serif;color:#1c1917;">
  <div style="max-width:600px;margin:0 auto;background:#ffffff;border:1px solid #e7e5e4;border-radius:12px;overflow:hidden;">
    <div style="padding:20px 28px;border-bottom:1px solid #e7e5e4;">
      <div style="font-size:13px;letter-spacing:.08em;color:#78716c;">CONTACT</div>
      <div style="font-size:18px;font-weight:700;margin-top:4px;">サイトからお問い合わせが届きました</div>
    </div>
    <table role="presentation" style="width:100%;border-collapse:collapse;">
      <tr>
        <th style="text-align:left;width:120px;padding:14px 28px;vertical-align:top;color:#78716c;font-weight:600;border-bottom:1px solid #f5f5f4;">お名前</th>
        <td style="padding:14px 28px;border-bottom:1px solid #f5f5f4;">{{ $submission->name }}</td>
      </tr>
      <tr>
        <th style="text-align:left;padding:14px 28px;vertical-align:top;color:#78716c;font-weight:600;border-bottom:1px solid #f5f5f4;">会社名</th>
        <td style="padding:14px 28px;border-bottom:1px solid #f5f5f4;">{{ $submission->company ?: '—' }}</td>
      </tr>
      <tr>
        <th style="text-align:left;padding:14px 28px;vertical-align:top;color:#78716c;font-weight:600;border-bottom:1px solid #f5f5f4;">メール</th>
        <td style="padding:14px 28px;border-bottom:1px solid #f5f5f4;"><a href="mailto:{{ $submission->email }}" style="color:#b6543a;">{{ $submission->email }}</a></td>
      </tr>
      <tr>
        <th style="text-align:left;padding:14px 28px;vertical-align:top;color:#78716c;font-weight:600;">本文</th>
        <td style="padding:14px 28px;white-space:pre-wrap;line-height:1.7;">{{ $submission->body }}</td>
      </tr>
    </table>
    <div style="padding:16px 28px;border-top:1px solid #e7e5e4;font-size:12px;color:#a8a29e;">
      受信日時: {{ $submission->created_at?->format('Y-m-d H:i') }}
      @if($submission->source_url)<br>送信元ページ: {{ $submission->source_url }}@endif
      @if($submission->ip)<br>IP: {{ $submission->ip }}@endif
    </div>
  </div>
  <p style="max-width:600px;margin:16px auto 0;font-size:12px;color:#a8a29e;text-align:center;">
    このメールに返信すると、お問い合わせ者（{{ $submission->email }}）に直接届きます。
  </p>
</body>
</html>
