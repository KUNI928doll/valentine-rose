<?php
/**
 * Valentine Rose theme functions
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

define('VR_THEME_VERSION', '1.0.0');
define('VR_THEME_DIR', get_template_directory());
define('VR_THEME_URI', get_template_directory_uri());

/**
 * 分割ファイルの読み込み
 */
require_once VR_THEME_DIR . '/inc/acf-fields.php';

/**
 * テーマのセットアップ
 */
function vr_theme_setup(): void
{
    load_theme_textdomain('valentine-rose', VR_THEME_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    register_nav_menus(
        array(
            'primary' => __('ヘッダー（プライマリ）', 'valentine-rose'),
        )
    );
}
add_action('after_setup_theme', 'vr_theme_setup');

/**
 * スタイル・スクリプト
 */
function vr_enqueue_assets(): void
{
    wp_enqueue_style(
        'vr-theme',
        VR_THEME_URI . '/assets/css/theme.css',
        array(),
        VR_THEME_VERSION
    );

    wp_enqueue_script(
        'vr-theme',
        VR_THEME_URI . '/assets/js/main.js',
        array(),
        VR_THEME_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'vr_enqueue_assets');

/**
 * カスタム投稿タイプ: サロン
 */
function vr_register_post_types(): void
{
    register_post_type(
        'salons',
        array(
            'labels'              => array(
                'name'          => __('サロン', 'valentine-rose'),
                'singular_name' => __('サロン', 'valentine-rose'),
            ),
            'public'              => true,
            'has_archive'         => true,
            'rewrite'             => array('slug' => 'salons'),
            'menu_icon'           => 'dashicons-store',
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'        => true,
        )
    );

    // お知らせ: スラッグは運用で変える場合はここと archive/single ファイル名を合わせる
    register_post_type(
        'news',
        array(
            'labels'              => array(
                'name'          => __('お知らせ', 'valentine-rose'),
                'singular_name' => __('お知らせ', 'valentine-rose'),
            ),
            'public'              => true,
            'has_archive'         => true,
            'rewrite'             => array('slug' => 'news'),
            'menu_icon'           => 'dashicons-megaphone',
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'        => true,
        )
    );
}
add_action('init', 'vr_register_post_types');

/**
 * テーマ有効化時にパーマリンクをフラッシュ（CPT 用）
 */
function vr_flush_rewrite_on_switch(): void
{
    vr_register_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'vr_flush_rewrite_on_switch');

/**
 * アイキャッチ画像 URL（未設定・取得失敗時はテーマ内 no-image.jpg）
 *
 * @param int|null $post_id 省略時は現在の投稿。
 * @param string   $size    登録済み画像サイズ名。
 */
function vr_get_thumbnail_url_or_placeholder(?int $post_id = null, string $size = 'large'): string
{
    if ($post_id === null) {
        $post_id = (int) get_the_ID();
    }
    if ($post_id > 0) {
        $url = get_the_post_thumbnail_url($post_id, $size);
        if ($url) {
            return $url;
        }
    }

    return VR_THEME_URI . '/assets/images/common/no-image.jpg';
}

/**
 * メニュー未設定時の簡易フォールバック（管理画面でメニューを割り当てれば非表示）
 */
function vr_nav_fallback(): void
{
    ?>
    <ul class="header__items">
        <li class="header__item">
            <a href="<?php echo esc_url(vr_url('concept')); ?>" class="header__link"<?php echo vr_aria_current('concept'); ?>>Concept</a>
        </li>
        <li class="header__item">
            <a href="<?php echo esc_url(vr_url('price')); ?>" class="header__link"<?php echo vr_aria_current('price'); ?>>Price</a>
        </li>
        <li class="header__item">
            <a href="<?php echo esc_url(vr_url('news')); ?>" class="header__link"<?php echo vr_aria_current('news'); ?>>News</a>
        </li>
        <li class="header__item">
            <a href="<?php echo esc_url(vr_url('reserve')); ?>" class="header__link button"<?php echo vr_aria_current('reserve'); ?>>
                <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                ご予約
            </a>
        </li>
    </ul>
    <?php
}

/**
 * サイト内リンクの解決
 *
 * 静的 HTML の ./xxx.html を WordPress の URL に一元変換する。
 * 固定ページのスラッグ・CPT アーカイブの差異をここだけで吸収する。
 *
 * @param string $key home|concept|price|reserve|news|salons|feature|faq
 */
function vr_url(string $key): string
{
    switch ($key) {
        case 'home':
            return home_url('/');
        case 'news':
        case 'salons':
            $link = get_post_type_archive_link($key);
            return $link ? $link : home_url('/');
        case 'feature':
        case 'faq':
            // TOP ページ内アンカー（下層からでも TOP に戻れるよう絶対 URL で出す）
            return home_url('/#' . $key);
        default:
            $page = get_page_by_path($key);
            return $page ? get_permalink($page) : home_url('/');
    }
}

/**
 * body クラスの付与
 *
 * 静的 HTML は各ページの <body> に page-xxx を持っており、SCSS がそれに依存している
 * （scss/pages/*.scss の .page-concept / .page-news-single 等）。
 * body_class() だけでは同じクラスが付かないため、ここで静的版と同じものを補う。
 * TOP（index.html）は静的版も無クラスなので何も足さない。
 */
function vr_body_class(array $classes): array
{
    $extra = '';

    if (is_front_page()) {
        $extra = '';
    } elseif (is_singular('news')) {
        $extra = 'page-news-single';
    } elseif (is_post_type_archive('news') || is_tax(get_object_taxonomies('news'))) {
        $extra = 'page-news';
    } elseif (is_singular('salons')) {
        $extra = 'page-salon-single';
    } elseif (is_post_type_archive('salons')) {
        $extra = 'page-salons';
    } elseif (is_page()) {
        // 固定ページはテンプレート優先、無ければスラッグで判定
        $template = get_page_template_slug();
        $reserve_templates = array('page-reserve.php', 'page-reserve-confirm.php', 'page-reserve-thanks.php');
        if (in_array($template, $reserve_templates, true)) {
            $extra = 'page-reserve';
        } else {
            $slug = get_post_field('post_name', get_queried_object_id());
            $map  = array(
                'concept'         => 'page-concept',
                'price'           => 'page-price',
                'reserve'         => 'page-reserve',
                'reserve-confirm' => 'page-reserve',
                'reserve-thanks'  => 'page-reserve',
            );
            $extra = isset($map[$slug]) ? $map[$slug] : '';
        }
    }

    if ($extra !== '') {
        $classes[] = $extra;
    }

    return $classes;
}
add_filter('body_class', 'vr_body_class');

/**
 * 現在ページのナビ項目に aria-current="page" を出す
 *
 * 静的 HTML はヘッダー / ドロワー / フッターの現在ページに aria-current="page" を付けている。
 * ただし付け方がページごとに不統一（salons はドロワーのみ、news-single は無し等）だったため、
 * ここでは全ナビで一貫して出す。SCSS 側でこの属性に当たるスタイルは
 * breadcrumb と記事カテゴリのみで、ナビには無いので見た目は変わらない。
 *
 * @param string $key vr_url() と同じキー
 */
function vr_aria_current(string $key): string
{
    $is_current = false;

    switch ($key) {
        case 'home':
            $is_current = is_front_page();
            break;
        case 'news':
            $is_current = is_post_type_archive('news') || is_singular('news');
            break;
        case 'salons':
            $is_current = is_post_type_archive('salons') || is_singular('salons');
            break;
        case 'reserve':
            $is_current = is_page(array('reserve', 'reserve-confirm', 'reserve-thanks'))
                || in_array(get_page_template_slug(), array('page-reserve-confirm.php', 'page-reserve-thanks.php'), true);
            break;
        case 'feature':
        case 'faq':
            // TOP 内アンカーなので現在ページ扱いにしない
            $is_current = false;
            break;
        default:
            $is_current = is_page($key);
            break;
    }

    return $is_current ? ' aria-current="page"' : '';
}
