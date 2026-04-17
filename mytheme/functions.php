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
    echo '<ul class="header__items">';
    echo '<li class="header__item"><a class="header__link" href="' . esc_url(home_url('/')) . '">News</a></li>';
    echo '<li class="header__item"><a class="header__link" href="' . esc_url(home_url('/')) . '#concept">Concept</a></li>';
    echo '<li class="header__item"><a class="header__link" href="' . esc_url(home_url('/')) . '#price">Price</a></li>';
    echo '</ul>';
}
