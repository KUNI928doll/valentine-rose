<?php
/**
 * ACF フィールド定義（無料版の範囲のみ）
 *
 * リピーター・柔軟コンテンツは ACF PRO 限定機能のため使用しない。
 * 可変長の入力は以下で代替している:
 *   - NEWS 本文 / 店舗紹介文 → ブロックエディタ（the_content()）
 *   - 施術の流れ             → inc/salon-flow-metabox.php（自前のリピータブル入力欄）
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * ACF が有効なときだけ定義する。
 * 無効環境でも致命的エラーにならないよう関数存在チェックを挟む。
 */
function vr_register_acf_fields(): void
{
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    /************************************************************************
    * サロン（CPT: salons）
    * 紹介文は本文（ブロックエディタ）、施術の流れは専用メタボックスが担当する。
    ************************************************************************/
    acf_add_local_field_group(
        array(
            'key'      => 'group_vr_salon',
            'title'    => '店舗情報',
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'salons',
                    ),
                ),
            ),
            'fields'   => array(
                array(
                    'key'           => 'field_vr_salon_hero_sp',
                    'label'         => 'トップ画像（スマホ用）',
                    'name'          => 'salon_hero_sp',
                    'type'          => 'image',
                    'instructions'  => '任意。未設定ならアイキャッチ画像をPC・スマホ共通で使います。',
                    'return_format' => 'array',
                    'preview_size'  => 'medium',
                ),
                array(
                    'key'           => 'field_vr_salon_staff_photo',
                    'label'         => 'スタッフ写真',
                    'name'          => 'salon_staff_photo',
                    'type'          => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'medium',
                ),
                array(
                    'key'       => 'field_vr_salon_staff_bio',
                    'label'     => 'スタッフ紹介文',
                    'name'      => 'salon_staff_bio',
                    'type'      => 'textarea',
                    'rows'      => 4,
                    'new_lines' => '',
                ),
                array(
                    'key'   => 'field_vr_salon_staff_name',
                    'label' => 'スタッフ名',
                    'name'  => 'salon_staff_name',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_vr_salon_address',
                    'label' => '住所',
                    'name'  => 'salon_address',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_vr_salon_access',
                    'label' => 'アクセス',
                    'name'  => 'salon_access',
                    'type'  => 'text',
                ),
                array(
                    'key'   => 'field_vr_salon_tel',
                    'label' => '電話番号',
                    'name'  => 'salon_tel',
                    'type'  => 'text',
                ),
                array(
                    'key'          => 'field_vr_salon_tel_note',
                    'label'        => '電話番号の補足',
                    'name'         => 'salon_tel_note',
                    'type'         => 'text',
                    'instructions' => '例: 受付 10:00〜19:00',
                ),
                array(
                    'key'   => 'field_vr_salon_hours',
                    'label' => '営業時間',
                    'name'  => 'salon_hours',
                    'type'  => 'text',
                ),
                array(
                    'key'          => 'field_vr_salon_map',
                    'label'        => '地図の埋め込みコード',
                    'name'         => 'salon_map',
                    'type'         => 'textarea',
                    'instructions' => 'Google マップの「地図を埋め込む」で取得した iframe を貼り付けてください。',
                    'rows'         => 4,
                    'new_lines'    => '',
                ),
                array(
                    'key'          => 'field_vr_salon_name_en',
                    'label'        => '店舗名（英語表記）',
                    'name'         => 'salon_name_en',
                    'type'         => 'text',
                    'instructions' => '店舗一覧カードの見出しに使います（例: SHIBUYA）。未入力なら店舗名をそのまま表示します。',
                ),
                array(
                    'key'          => 'field_vr_salon_region',
                    'label'        => '地域',
                    'name'         => 'salon_region',
                    'type'         => 'text',
                    'instructions' => '店舗一覧ページでのグループ分けに使用します（例: 東京都、神奈川県）。',
                ),
            ),
        )
    );

    /************************************************************************
    * お知らせ（CPT: news）
    * 本文は本文欄（ブロックエディタ）が担当するため、ラベルのみ。
    ************************************************************************/
    acf_add_local_field_group(
        array(
            'key'      => 'group_vr_news',
            'title'    => 'お知らせ設定',
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'news',
                    ),
                ),
            ),
            'fields'   => array(
                array(
                    'key'          => 'field_vr_news_label',
                    'label'        => 'ラベル',
                    'name'         => 'news_label',
                    'type'         => 'text',
                    'instructions' => '記事種別の英字ラベル（例: Column、News）。一覧ページの絞り込みにも使われます。',
                ),
            ),
        )
    );
}
add_action('acf/init', 'vr_register_acf_fields');

/**
 * ACF が無い場合に管理画面で知らせる
 * （PRO は不要。無料版で足りる）
 */
function vr_acf_admin_notice(): void
{
    if (function_exists('acf_add_local_field_group')) {
        return;
    }
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if ($screen && ! in_array($screen->post_type, array('salons', 'news'), true)) {
        return;
    }
    echo '<div class="notice notice-warning"><p>';
    echo esc_html('Valentine Rose テーマ: 店舗情報とお知らせラベルの入力欄には Advanced Custom Fields（無料版で可）が必要です。');
    echo '</p></div>';
}
add_action('admin_notices', 'vr_acf_admin_notice');
