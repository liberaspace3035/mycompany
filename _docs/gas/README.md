# お問い合わせフォーム（Google Apps Script）

サイトの `/contact/` から送信された内容を、Google Apps Script で受け付けます。

## 構成（2026-11-16 設置）

| 項目 | 内容 |
|---|---|
| Googleアカウント | liberaspace3035@gmail.com |
| Apps Script | LiberaSpace お問い合わせフォーム（スタンドアロン） |
| 記録先 | スプレッドシート「LiberaSpace お問い合わせ」のシート「お問い合わせ一覧」 |
| デプロイ | ウェブアプリ／実行：自分／アクセス：全員 |
| URL | https://script.google.com/macros/s/AKfycbwnoHbY90DUtcg11p_Z4Widy8JgxgzssNQCZPH_Tg4_kjJJrtRCWWRwFEbvnj-N2uRziA/exec |
| コード | `contact-form.gs`（Apps Script 上のコードと同じ内容） |

送信されると次の3つが行われます。

1. スプレッドシートに1行記録（対応状況は「未対応」）
2. liberaspace3035@gmail.com へ通知（返信すると送信者に届く）
3. 送信者へ受付確認メールを自動返信

## コードを変更するとき

1. Apps Script のエディタで修正し、このフォルダの `contact-form.gs` も同じ内容に更新する
2. 「デプロイ → デプロイを管理 → 編集（鉛筆）→ バージョン：新バージョン → デプロイ」
   - この手順なら URL は変わらない。「新しいデプロイ」を作ると URL が変わるので注意

## 仕様メモ

- ブラウザからは Content-Type を付けずに JSON 文字列を送る（`application/json` にすると CORS のプリフライトで失敗する）
- いたずら送信対策：画面外の `website` 欄（埋まっていれば破棄）、送信元オリジンの制限（`ALLOWED_ORIGINS`）、同一アドレスの60秒以内の再送信をブロック
- フォームのURLに `?type=資料請求` などを付けると、お問い合わせの種類が選ばれた状態で開く
- Gmail の送信数には1日あたりの上限がある（無料アカウントで100通程度）。1件につき2通送る
