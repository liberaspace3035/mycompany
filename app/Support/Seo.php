<?php

namespace App\Support;

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Work;
use Illuminate\Support\Str;

/**
 * 公開サイトの SEO 値を 1 箇所で組み立てるビルダー / 値オブジェクト。
 *
 * コントローラから `Seo::for*($model)` を呼び、View に `$seo` を渡すと
 * `resources/views/partials/seo.blade.php` がそれを <head> に展開する。
 *
 * - 絶対 URL の起点: config('app.url')
 * - OG 画像のフォールバック: public/og-default.png
 * - JSON-LD の @graph:
 *   - Organization + WebSite を常時同梱
 *   - ページ別に WebPage / CollectionPage / Blog / AboutPage / BlogPosting / CreativeWork を追加
 */
class Seo
{
    public function __construct(
        public string $title,
        public string $description,
        public string $canonical,
        public ?string $keywords = null,
        public ?string $ogImage = null,
        public string $ogType = 'website',
        public string $robots = 'index,follow',
        public array $structuredDataExtra = [],   // forBlogPost 等で追加するスキーマを溜める
        public ?string $publishedAt = null,        // og:article 用 (ISO 8601)
        public ?string $modifiedAt = null,
    ) {
        //
    }

    // ====================================================================
    // Factories
    // ====================================================================

    /**
     * 5 つの公開ページ (home/services/works/blog/company の一覧) 用。
     *
     * $items に Service / Work / Post のコレクションを渡すと、
     * CollectionPage の mainEntity (または Blog.blogPost) として ItemList を埋め込む。
     */
    public static function forPage(Page $page, ?string $titleOverride = null, iterable $items = []): self
    {
        $siteName = static::siteName();
        $titleParts = [
            $titleOverride ?? static::oneLine($page->hero_title ?? $page->name),
            $page->slug === 'home' ? null : $siteName,
        ];
        $title = implode(' — ', array_filter($titleParts));
        if ($page->slug === 'home') {
            $title = $siteName . ' — ' . $title;
        }

        $description = $page->meta_description ?? static::defaultDescription();

        $seo = new self(
            title: $title,
            description: $description,
            canonical: static::canonical(),
            keywords: $page->meta_keywords,
            ogImage: static::resolveOgImage(null),
            ogType: 'website',
        );

        $seo->structuredDataExtra[] = static::pageStructuredData($page, $title, $description, $items);
        $seo->structuredDataExtra[] = static::breadcrumbList(static::pageCrumbs($page));

        return $seo;
    }

    /**
     * /blog/{slug} 用 — og:type=article、BlogPosting JSON-LD を同梱。
     */
    public static function forBlogPost(Post $post): self
    {
        $siteName = static::siteName();
        $description = $post->summary ?: static::truncate(strip_tags($post->body_md ?? ''), 140);
        $ogImage = static::resolveOgImage($post->eyecatch);
        $publishedAt = $post->published_at?->toIso8601String();
        $modifiedAt = $post->updated_at?->toIso8601String();

        $seo = new self(
            title: $post->title . ' — ' . $siteName,
            description: $description,
            canonical: static::canonical(),
            keywords: $post->category?->name,
            ogImage: $ogImage,
            ogType: 'article',
            publishedAt: $publishedAt,
            modifiedAt: $modifiedAt,
        );

        // BlogPosting schema (Schema.org / Google Article rich result 準拠)
        $seo->structuredDataExtra[] = array_filter([
            '@type'         => 'BlogPosting',
            'headline'      => static::truncate($post->title, 110),
            'description'   => $description,
            'image'         => static::imageObject($ogImage),
            'datePublished' => $publishedAt,
            'dateModified'  => $modifiedAt,
            'url'           => $seo->canonical,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id'   => $seo->canonical,
            ],
            // Google は author に name 必須。Organization 著者として明示。
            'author'    => [
                '@type' => 'Organization',
                'name'  => $siteName,
                'url'   => static::appUrl(),
            ],
            'publisher' => static::organizationRef(),
            'articleSection' => $post->category?->name,
            'inLanguage' => 'ja-JP',
        ], static fn ($v) => $v !== null && $v !== '');

        $seo->structuredDataExtra[] = static::breadcrumbList([
            ['name' => 'Top',  'url' => static::appUrl() . '/'],
            ['name' => 'Blog', 'url' => static::appUrl() . '/blog'],
            ['name' => $post->title, 'url' => $seo->canonical],
        ]);

        return $seo;
    }

    /**
     * /works/{slug} 用 — og:type=article、CreativeWork JSON-LD を同梱。
     */
    public static function forWork(Work $work): self
    {
        $siteName = static::siteName();
        $description = $work->summary ?: $siteName . ' の実績「' . $work->title . '」（' . $work->category . '）';
        $ogImage = static::resolveOgImage($work->image);

        $seo = new self(
            title: $work->title . ' — Works — ' . $siteName,
            description: $description,
            canonical: static::canonical(),
            keywords: $work->category . ($work->tags ? ',' . implode(',', $work->tags) : ''),
            ogImage: $ogImage,
            ogType: 'article',
            modifiedAt: $work->updated_at?->toIso8601String(),
        );

        $seo->structuredDataExtra[] = array_filter([
            '@type'        => 'CreativeWork',
            'name'         => $work->title,
            'description'  => $description,
            'image'        => static::imageObject($ogImage),
            'url'          => $seo->canonical,
            'genre'        => $work->category,
            'dateCreated'  => $work->year,
            'keywords'     => $work->tags ? implode(',', $work->tags) : null,
            'creator'      => static::organizationRef(),
            'inLanguage'   => 'ja-JP',
        ], static fn ($v) => $v !== null && $v !== '');

        $seo->structuredDataExtra[] = static::breadcrumbList([
            ['name' => 'Top',   'url' => static::appUrl() . '/'],
            ['name' => 'Works', 'url' => static::appUrl() . '/works'],
            ['name' => $work->title, 'url' => $seo->canonical],
        ]);

        return $seo;
    }

    /**
     * $seo が view に渡されない時の安全網。
     */
    public static function forDefault(): self
    {
        $siteName = static::siteName();
        return new self(
            title: $siteName,
            description: static::defaultDescription(),
            canonical: static::canonical(),
            ogImage: static::resolveOgImage(null),
        );
    }

    // ====================================================================
    // Structured data
    // ====================================================================

    /**
     * Schema.org のページ型 (WebPage / CollectionPage / Blog / AboutPage) を slug ごとに組み立てる。
     */
    protected static function pageStructuredData(Page $page, string $title, string $description, iterable $items): array
    {
        $appUrl = static::appUrl();
        $canonical = static::canonical();

        $base = [
            '@id'         => $canonical . '#webpage',
            'url'         => $canonical,
            'name'        => $title,
            'description' => $description,
            'inLanguage'  => 'ja-JP',
            'isPartOf'    => ['@id' => $appUrl . '#website'],
            'primaryImageOfPage' => [
                '@type' => 'ImageObject',
                'url'   => static::resolveOgImage(null),
            ],
        ];

        return match ($page->slug) {
            'services' => [
                '@type' => 'CollectionPage',
                ...$base,
                'about'      => static::organizationRef(),
                'mainEntity' => static::itemList(
                    collect($items)->map(fn (Service $s) => static::serviceItem($s))->all()
                ),
            ],
            'works' => [
                '@type' => 'CollectionPage',
                ...$base,
                'about'      => static::organizationRef(),
                'mainEntity' => static::itemList(
                    collect($items)->map(fn (Work $w) => static::creativeWorkItem($w))->all()
                ),
            ],
            'blog' => [
                '@type' => 'Blog',
                ...$base,
                'publisher' => static::organizationRef(),
                'blogPost'  => collect($items)->map(fn (Post $p) => static::blogPostingItem($p))->all(),
            ],
            'company' => [
                '@type' => 'AboutPage',
                ...$base,
                'about'      => static::organizationRef(),
                'mainEntity' => static::organizationRef(),
            ],
            default => [
                '@type' => 'WebPage',
                ...$base,
                'about' => static::organizationRef(),
            ],
        };
    }

    /** ItemList ラッパー: [item, item, ...] → {@type: ItemList, itemListElement: [ListItem...]} */
    protected static function itemList(array $items): array
    {
        $elements = [];
        foreach (array_values($items) as $i => $item) {
            $elements[] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'item'     => $item,
            ];
        }
        return [
            '@type'           => 'ItemList',
            'numberOfItems'   => count($elements),
            'itemListElement' => $elements,
        ];
    }

    protected static function serviceItem(Service $service): array
    {
        return array_filter([
            '@type'       => 'Service',
            'name'        => $service->name,
            'description' => static::oneLine($service->summary),
            'serviceType' => $service->eyebrow,
            'provider'    => static::organizationRef(),
            'keywords'    => is_array($service->keywords) ? implode(',', $service->keywords) : null,
        ], static fn ($v) => $v !== null && $v !== '');
    }

    protected static function creativeWorkItem(Work $work): array
    {
        return array_filter([
            '@type'       => 'CreativeWork',
            'name'        => $work->title,
            'description' => static::oneLine($work->summary),
            'url'         => route('works.show', ['slug' => $work->slug]),
            'image'       => $work->image ? static::imageObject(static::resolveOgImage($work->image)) : null,
            'genre'       => $work->category,
            'dateCreated' => $work->year,
            'keywords'    => is_array($work->tags) && $work->tags ? implode(',', $work->tags) : null,
            'creator'     => static::organizationRef(),
        ], static fn ($v) => $v !== null && $v !== '');
    }

    protected static function blogPostingItem(Post $post): array
    {
        $siteName = static::siteName();
        return array_filter([
            '@type'         => 'BlogPosting',
            'headline'      => static::truncate($post->title, 110),
            'description'   => static::oneLine($post->summary ?: static::truncate(strip_tags($post->body_md ?? ''), 140)),
            'url'           => route('blog.show', ['slug' => $post->slug]),
            'image'         => $post->eyecatch ? static::imageObject(static::resolveOgImage($post->eyecatch)) : null,
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified'  => $post->updated_at?->toIso8601String(),
            'articleSection' => $post->category?->name,
            'author'        => [
                '@type' => 'Organization',
                'name'  => $siteName,
                'url'   => static::appUrl(),
            ],
            'publisher'     => static::organizationRef(),
        ], static fn ($v) => $v !== null && $v !== '');
    }

    /**
     * <script type="application/ld+json"> に流す Schema.org @graph 配列。
     * Organization + WebSite を常に同梱し、ファクトリで追加された extra (WebPage / BlogPosting / BreadcrumbList 等) を末尾に。
     */
    public function structuredDataGraph(): array
    {
        $appUrl = static::appUrl();
        $siteName = static::siteName();

        $website = [
            '@type'       => 'WebSite',
            '@id'         => $appUrl . '#website',
            'url'         => $appUrl,
            'name'        => $siteName,
            'inLanguage'  => 'ja-JP',
            'publisher'   => ['@id' => $appUrl . '#organization'],
        ];

        return array_merge([static::organization(), $website], $this->structuredDataExtra);
    }

    /**
     * Schema.org Organization を組み立てる。
     * SiteSetting.payload から以下を任意で読み取り:
     *   - logo_url / logo_width / logo_height : 揃っていれば ImageObject 化
     *   - same_as[] : SNS / 公式プロフィール URL の配列
     *   - address : { streetAddress, addressLocality, addressRegion, postalCode, addressCountry }
     *   - telephone
     */
    public static function organization(): array
    {
        $appUrl = static::appUrl();
        $siteName = static::siteName();
        $settings = SiteSetting::current();
        $payload  = (array) ($settings->payload ?? []);

        $contactPoint = $settings->contact_email
            ? array_filter([
                '@type'             => 'ContactPoint',
                'email'             => $settings->contact_email,
                'telephone'         => $payload['telephone'] ?? null,
                'contactType'       => 'customer support',
                'areaServed'        => 'JP',
                'availableLanguage' => ['Japanese', 'English'],
            ], static fn ($v) => $v !== null && $v !== '')
            : null;

        $address = is_array($payload['address'] ?? null) && $payload['address']
            ? array_merge(['@type' => 'PostalAddress'], $payload['address'])
            : null;

        $sameAs = is_array($payload['same_as'] ?? null)
            ? array_values(array_filter($payload['same_as'], static fn ($v) => is_string($v) && $v !== ''))
            : [];

        return array_filter([
            '@type'        => 'Organization',
            '@id'          => $appUrl . '#organization',
            'name'         => $siteName,
            'url'          => $appUrl,
            'logo'         => static::organizationLogo($payload),
            'email'        => $settings->contact_email,
            'telephone'    => $payload['telephone'] ?? null,
            'sameAs'       => $sameAs ?: null,
            'contactPoint' => $contactPoint,
            'address'      => $address,
        ], static fn ($v) => $v !== null && $v !== '' && $v !== []);
    }

    /**
     * publisher.logo として使えるよう、可能なら ImageObject 化する。
     * payload に logo_url + logo_width + logo_height が揃わない場合は文字列 URL のまま返す。
     */
    protected static function organizationLogo(array $payload): array|string
    {
        $url    = $payload['logo_url'] ?? null;
        $width  = (int) ($payload['logo_width']  ?? 0);
        $height = (int) ($payload['logo_height'] ?? 0);

        if ($url && $width > 0 && $height > 0) {
            return [
                '@type'  => 'ImageObject',
                'url'    => $url,
                'width'  => $width,
                'height' => $height,
            ];
        }

        return $url ?: static::resolveOgImage(null);
    }

    /**
     * BreadcrumbList を組み立てる。Google は各 ListItem に position / name / item URL を要求。
     *
     * @param array<int, array{name:string, url:string}> $crumbs
     */
    protected static function breadcrumbList(array $crumbs): array
    {
        $elements = [];
        foreach (array_values($crumbs) as $i => $crumb) {
            $elements[] = array_filter([
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $crumb['name'] ?? null,
                'item'     => $crumb['url']  ?? null,
            ], static fn ($v) => $v !== null && $v !== '');
        }
        return [
            '@type'           => 'BreadcrumbList',
            '@id'             => static::canonical() . '#breadcrumb',
            'itemListElement' => $elements,
        ];
    }

    /**
     * 一覧/静的ページ用のパンくず階層。
     *
     * @return array<int, array{name:string, url:string}>
     */
    protected static function pageCrumbs(Page $page): array
    {
        $appUrl = static::appUrl();
        if ($page->slug === 'home') {
            return [
                ['name' => 'Top', 'url' => $appUrl . '/'],
            ];
        }
        return [
            ['name' => 'Top', 'url' => $appUrl . '/'],
            ['name' => static::pageLabel($page), 'url' => static::canonical()],
        ];
    }

    protected static function pageLabel(Page $page): string
    {
        return match ($page->slug) {
            'services' => 'Services',
            'works'    => 'Works',
            'blog'     => 'Blog',
            'company'  => 'Company',
            default    => $page->name ?: Str::headline($page->slug),
        };
    }

    /** Schema.org ImageObject (寸法不明なら URL のみ)。null 入力は null を返す。 */
    protected static function imageObject(?string $url): ?array
    {
        if (! $url) {
            return null;
        }
        return ['@type' => 'ImageObject', 'url' => $url];
    }

    // ====================================================================
    // Helpers
    // ====================================================================

    /** 環境からブランド名を取得 (SiteSetting > config) */
    public static function siteName(): string
    {
        return optional(SiteSetting::current())->site_name ?: config('app.name', 'Liberaspace');
    }

    public static function defaultDescription(): string
    {
        return '開発・分析・効率化のプロフェッショナル。AIを開発の中核に据え、HP制作・Webシステム開発・業務効率化を一気通貫で提供します。';
    }

    public static function appUrl(): string
    {
        return rtrim(config('app.url') ?: url('/'), '/');
    }

    /** クエリパラメータを捨てた現在 URL。重複コンテンツを避けるため。 */
    public static function canonical(): string
    {
        return url()->current();
    }

    /**
     * OG 画像パスを絶対 URL に解決:
     *  - http(s):// 始まりはそのまま
     *  - 相対パスは uploads/ に存在すれば asset() で絶対化
     *  - null や空は public/og-default.png にフォールバック
     */
    public static function resolveOgImage(?string $pathOrUrl): string
    {
        if ($pathOrUrl && (Str::startsWith($pathOrUrl, 'http://') || Str::startsWith($pathOrUrl, 'https://'))) {
            return $pathOrUrl;
        }

        if ($pathOrUrl) {
            // 既存 Work.image / Post.eyecatch は uploads/ 配下のパス想定
            $path = ltrim($pathOrUrl, '/');
            return static::appUrl() . '/uploads/' . ltrim(Str::after($path, 'uploads/'), '/');
        }

        return static::appUrl() . '/og-default.png';
    }

    /** "Make Agents\nfeel native." → "Make Agents feel native." */
    public static function oneLine(?string $text): string
    {
        return trim(preg_replace('/\s+/', ' ', (string) $text));
    }

    public static function truncate(string $text, int $len): string
    {
        $text = static::oneLine($text);
        return mb_strlen($text) > $len ? mb_substr($text, 0, $len) . '…' : $text;
    }

    /** JSON-LD で @id 参照される Organization を返す */
    public static function organizationRef(): array
    {
        return ['@id' => static::appUrl() . '#organization'];
    }
}
