# Liberaspace — 自社サイト

Laravel 13 + Livewire 4 + フルスクラッチ管理画面で動く、Liberaspace の自社マーケティングサイト。Claude Design で詰めたプロトタイプを本実装としてポートし、各ページのコンテンツを `/admin` から動的に更新できるようにしたもの。

## スタック

| Layer | 採用 |
|---|---|
| Framework | Laravel 13 (PHP 8.3+) |
| Admin UI | Livewire 4 + 既存 D3 デザインに揃えた手書きスタイル |
| Auth | Laravel Breeze (login / forgot-password のみ。register は撤去) |
| DB | ローカル: SQLite / 本番: PostgreSQL (Railway add-on) |
| Storage | ローカル: `public/uploads/` / 本番: Cloudflare R2 (S3互換) を想定 |
| Build | Vite (Breeze 用の最小 CSS/JS のみ。公開側は素の `public/assets/*` を直配信) |
| Hosting | Railway (Nixpacks + `php artisan serve --host 0.0.0.0 --port $PORT`) |

## ディレクトリ

```
.
├── app/
│   ├── Http/Controllers/Site/      公開サイトのコントローラ
│   ├── Http/Controllers/Admin/     /admin ダッシュボード
│   ├── Livewire/Admin/             管理画面の Livewire コンポーネント
│   ├── Models/                     Eloquent モデル (10 個)
│   └── Support/HeroFormatter.php   Hero テキストの装飾 (.shake/.accent/.hi 自動付与)
├── database/
│   ├── migrations/                 スキーマ
│   └── seeders/                    プロトタイプのコピーを投入する初期データ
├── resources/views/
│   ├── layouts/site.blade.php      公開側レイアウト
│   ├── layouts/admin.blade.php     管理画面レイアウト
│   ├── partials/                   nav / footer / loader
│   ├── pages/                      公開ページ (home + services/works/blog/company)
│   └── livewire/admin/             Livewire コンポーネントのテンプレ
├── public/
│   ├── assets/site.{css,js}        D3 デザインの本体 (プロトタイプから流用)
│   ├── assets/tech-3d.js           サブページのミニ3D
│   └── uploads/                    画像 / PDF
├── _legacy-static/                 元プロトタイプの保管 (リポジトリ外)
├── nixpacks.toml                   Railway ビルド設定
└── railway.toml                    Railway デプロイ設定
```

## コンテンツモデル

| Model | 用途 | 編集場所 |
|---|---|---|
| `SiteSetting` (シングルトン) | サイト名・ナビ・フッター | `/admin/settings` |
| `Page` × 5 | 各ページのヒーロー・メタ | `/admin/pages` → 各ページ編集 |
| `Section` | ページ内ブロック (type + payload JSON) | ページ編集画面下部からセクション編集へ |
| `Work` | 実績 | `/admin/works` |
| `Post` + `Category` | ブログ記事 (Markdown 本文) | `/admin/posts` |
| `Service` | サービス領域 + 料金プラン | `/admin/services` |
| `TimelineEntry` | 会社沿革 | `/admin/timeline` |
| `Skill` | スキル一覧 (カテゴリ毎 + レベルバー) | `/admin/skills` |
| `ContactSubmission` | 問い合わせ受信箱 (閲覧専用) | `/admin/inbox` (未読件数バッジ付き) |

## ローカル開発

```bash
# 1. 依存解決
composer install
npm ci

# 2. 環境変数
cp .env.example .env
php artisan key:generate

# 3. DB
# SQLite ファイルを作る (.env で DB_CONNECTION=sqlite)
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# 4. ビルド + サーバ起動
npm run build           # Breeze 用 Vite ビルド
php artisan serve       # http://127.0.0.1:8000
```

初期管理者は `ADMIN_EMAIL` / `ADMIN_PASSWORD` 環境変数で上書き可。デフォルトは `admin@liberaspace.local` / `password`（**本番では必ず変更**）。

## Railway へのデプロイ

### 初回セットアップ

```bash
# 1. Railway プロジェクトを作る
railway login
railway init        # ← 既存プロジェクトにリンクするなら link

# 2. PostgreSQL プラグインを追加 (ダッシュボード or CLI)
railway add postgresql   # DATABASE_URL が自動 inject される

# 3. 必須環境変数を投入
railway variables set \
  APP_KEY=$(php artisan key:generate --show) \
  APP_NAME=Liberaspace \
  APP_ENV=production \
  APP_DEBUG=false \
  APP_URL=https://liberaspace.up.railway.app \
  APP_LOCALE=ja \
  DB_CONNECTION=pgsql \
  ADMIN_EMAIL=YOUR_ADMIN@example.com \
  ADMIN_PASSWORD=$(openssl rand -hex 16) \
  SESSION_DRIVER=database \
  QUEUE_CONNECTION=database \
  CACHE_STORE=database

# 4. デプロイ
railway up
```

### 初回データ投入

migrations は `[start]` で毎回流れるが、seeder は安全のため毎回は流さない。初回のみ手動で:

```bash
railway run php artisan db:seed --force
```

これで初期コンテンツと admin ユーザーが入る。

### Cloudflare R2 連携 (画像アップロード)

Railway のコンテナは ephemeral なので、`public/uploads/` への書き込みは再デプロイで消える。本番では R2 / S3 を使う。

```bash
railway variables set \
  FILESYSTEM_DISK=r2 \
  AWS_ACCESS_KEY_ID=... \
  AWS_SECRET_ACCESS_KEY=... \
  AWS_BUCKET=liberaspace-media \
  AWS_ENDPOINT=https://<accountid>.r2.cloudflarestorage.com \
  AWS_URL=https://media.example.com \
  AWS_DEFAULT_REGION=auto \
  AWS_USE_PATH_STYLE_ENDPOINT=true
```

`config/filesystems.php` に `r2` ディスクを追加する必要あり（次フェーズで実装予定）。

## 現状の実装範囲

✅ 完成:
- Laravel 13 scaffold + Livewire 4 + Breeze (login のみ・register は撤去)
- 10 モデル + マイグレーション + シーダー (プロトタイプの全コピーを投入済)
- 公開側 5 ページすべて D3 デザインでフル Blade 化、Hero/実績/ブログ/沿革/スキル を DB 駆動
- 問い合わせフォーム受信 → `ContactSubmission` に保存 → 管理画面で未読バッジ + 既読/削除
- カテゴリ別フィルタ付き Works 一覧 (`/works?category=...`)
- 管理画面 9 種類の CRUD:
  - `Pages` (Hero + メタ + Sections への入口)
  - `Sections` (JSON payload 編集)
  - `Works` (検索 / カテゴリ絞込 / Featured トグル / 削除)
  - `Posts` (Markdown 本文 / 下書き&公開 / カテゴリ / Featured)
  - `Services` (料金プラン / 特徴 / キーワード)
  - `Timeline` (沿革)
  - `Skills` (カテゴリ毎 / レベルバー)
  - `SiteSettings` (サイト名 / ナビ / フッター列 / フッターリンク群)
  - `Inbox` (問い合わせ閲覧 / 既読管理 / mailto: リンク)
- Railway デプロイ設定 (Nixpacks + railway.toml)

⏳ 次フェーズ候補:
- 画像アップロード (Livewire `WithFileUploads` → Cloudflare R2 配信)
- メール通知 (新規問い合わせ受信時に `$settings->contact_email` へ自動送信)
- ブログのドラッグ&ドロップ並び替え (Sortable.js)
- フルテキスト検索 (Scout + Meilisearch)
- OGP 画像自動生成
- Cloudflare R2 配信のための `config/filesystems.php` の `r2` ディスク追加
- 管理画面のセクション payload を type 別の構造化フォームに昇格 (今は JSON textarea)

## ライセンス

Liberaspace の自社プロジェクト。
