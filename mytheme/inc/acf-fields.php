<?php
/**
 * ACF フィールド定義（コード側で定義し、管理画面での再設定を不要にする）
 *
 * 指示書の要件:
 *  - 店舗詳細「施術の流れ」= 店舗ごとにステップ数が違うため任意数ループ
 *  - NEWS 詳細の本文 = 任意に段落を追加できるループ
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * ACF（PRO）が有効なときだけ定義する。
 * 無効環境でも致命的エラーにならないよう関数存在チェックを挟む。
 */
function vr_register_acf_fields(): void
{
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    /************************************************************************
    * サロン（CPT: salons）
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
                    'key'          => 'field_vr_salon_intro',
                    'label'        => '店舗紹介文',
                    'name'         => 'salon_intro',
                    'type'         => 'repeater',
                    'instructions' => '段落ごとに1行追加してください。',
                    'layout'       => 'block',
                    'button_label' => '段落を追加',
                    'sub_fields'   => array(
                        array(
                            'key'   => 'field_vr_salon_intro_text',
                            'label' => '本文',
                            'name'  => 'text',
                            'type'  => 'textarea',
                            'rows'  => 4,
                            'new_lines' => '',
                        ),
                    ),
                ),
                array(
                    'key'          => 'field_vr_salon_flow',
                    'label'        => '施術の流れ',
                    'name'         => 'salon_flow',
                    'type'         => 'repeater',
                    'instructions' => 'ステップ数は店舗ごとに自由に増減できます。並び順はドラッグで変更できます。番号は自動採番されます。',
                    'layout'       => 'block',
                    'button_label' => 'ステップを追加',
                    'sub_fields'   => array(
                        array(
                            'key'      => 'field_vr_salon_flow_title',
                            'label'    => 'ステップ名',
                            'name'     => 'title',
                            'type'     => 'text',
                            'required' => 1,
                        ),
                        array(
                            'key'   => 'field_vr_salon_flow_desc',
                            'label' => '説明',
                            'name'  => 'desc',
                            'type'  => 'textarea',
                            'rows'  => 3,
                            'new_lines' => '',
                        ),
                        array(
                            'key'           => 'field_vr_salon_flow_image',
                            'label'         => '装飾画像',
                            'name'          => 'image',
                            'type'          => 'image',
                            'instructions'  => '任意。設定するとステップの説明の下に丸い画像が入ります（デザイン上は一部のステップのみ）。',
                            'return_format' => 'array',
                            'preview_size'  => 'thumbnail',
                        ),
                    ),
                ),
                array(
                    'key'   => 'field_vr_salon_staff_photo',
                    'label' => 'スタッフ写真',
                    'name'  => 'salon_staff_photo',
                    'type'  => 'image',
                    'return_format' => 'array',
                    'preview_size'  => 'medium',
                ),
                array(
                    'key'   => 'field_vr_salon_staff_bio',
                    'label' => 'スタッフ紹介文',
                    'name'  => 'salon_staff_bio',
                    'type'  => 'textarea',
                    'rows'  => 4,
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
                    'key'          => 'field_vr_salon_region',
                    'label'        => '地域',
                    'name'         => 'salon_region',
                    'type'         => 'text',
                    'instructions' => '店舗一覧ページでの grouping に使用します（例: 関東、関西）。',
                ),
            ),
        )
    );

    /************************************************************************
    * お知らせ（CPT: news）
    ************************************************************************/
    acf_add_local_field_group(
        array(
            'key'      => 'group_vr_news',
            'title'    => 'お知らせ本文',
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
                    'instructions' => '記事種別の英字ラベル（例: Column、News）。',
                ),
                array(
                    'key'          => 'field_vr_news_body',
                    'label'        => '本文',
                    'name'         => 'news_body',
                    'type'         => 'flexible_content',
                    'instructions' => '「段落」「小見出し」「箇条書き」を必要な数だけ、好きな順番で追加できます。',
                    'button_label' => 'ブロックを追加',
                    'layouts'      => array(
                        'layout_vr_news_paragraph' => array(
                            'key'        => 'layout_vr_news_paragraph',
                            'name'       => 'paragraph',
                            'label'      => '段落',
                            'display'    => 'block',
                            'sub_fields' => array(
                                array(
                                    'key'       => 'field_vr_news_paragraph_text',
                                    'label'     => '本文',
                                    'name'      => 'text',
                                    'type'      => 'textarea',
                                    'rows'      => 5,
                                    'new_lines' => '',
                                ),
                            ),
                        ),
                        'layout_vr_news_heading' => array(
                            'key'        => 'layout_vr_news_heading',
                            'name'       => 'heading',
                            'label'      => '小見出し',
                            'display'    => 'block',
                            'sub_fields' => array(
                                array(
                                    'key'   => 'field_vr_news_heading_text',
                                    'label' => '見出し',
                                    'name'  => 'text',
                                    'type'  => 'text',
                                ),
                            ),
                        ),
                        'layout_vr_news_list' => array(
                            'key'        => 'layout_vr_news_list',
                            'name'       => 'list',
                            'label'      => '箇条書き',
                            'display'    => 'block',
                            'sub_fields' => array(
                                array(
                                    'key'          => 'field_vr_news_list_items',
                                    'label'        => '項目',
                                    'name'         => 'items',
                                    'type'         => 'repeater',
                                    'layout'       => 'table',
                                    'button_label' => '項目を追加',
                                    'sub_fields'   => array(
                                        array(
                                            'key'   => 'field_vr_news_list_item_text',
                                            'label' => '項目',
                                            'name'  => 'text',
                                            'type'  => 'text',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        )
    );
}
add_action('acf/init', 'vr_register_acf_fields');

/**
 * ACF PRO が無い場合に管理画面で知らせる
 * （リピーター・柔軟コンテンツは PRO 限定のため、無いと入力欄が出ない）
 */
function vr_acf_admin_notice(): void
{
    if (function_exists('acf_add_local_field_group')) {
        return;
    }
    echo '<div class="notice notice-warning"><p>';
    echo esc_html('Valentine Rose テーマ: 店舗情報とお知らせ本文の入力欄には ACF PRO が必要です。');
    echo '</p></div>';
}
add_action('admin_notices', 'vr_acf_admin_notice');
