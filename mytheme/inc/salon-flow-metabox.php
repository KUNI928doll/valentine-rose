<?php
/**
 * 施術の流れ（可変ステップ）の入力欄
 *
 * 指示書の要件:
 *   「店舗詳細ページの『お問い合わせから施術の流れ』セクションの各ステップは
 *     店舗によって流れが異なり、ステップ数も違うので、任意の数だけループできるように実装。」
 *
 * ACF のリピーターは PRO 限定のため、WordPress 標準のメタボックスで同等の
 * 「行の追加・削除・並べ替え」を自前実装している。追加プラグインは不要。
 *
 * 保存先: post_meta `_vr_salon_flow`（[['title'=>..,'desc'=>..,'image'=>添付ID], ...]）
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

const VR_SALON_FLOW_META = '_vr_salon_flow';

/**
 * 装飾画像の上限枚数
 *
 * 指示書の指定:
 *   「デザインの関係上4枚以上だと見栄えが悪くなるので、最大で3枚まで設定できるようにする。」
 */
const VR_SALON_FLOW_MAX_IMAGES = 3;

/**
 * 保存済みの施術の流れを取得する（テンプレートから使う正規の入口）
 *
 * @return array{title:string,desc:string,image:int}[]
 */
function vr_get_salon_flow(?int $post_id = null): array
{
    $post_id = $post_id ? $post_id : get_the_ID();
    $rows    = get_post_meta($post_id, VR_SALON_FLOW_META, true);

    if (! is_array($rows)) {
        return array();
    }

    $out = array();
    foreach ($rows as $row) {
        if (! is_array($row)) {
            continue;
        }
        $title = isset($row['title']) ? (string) $row['title'] : '';
        $desc  = isset($row['desc']) ? (string) $row['desc'] : '';
        $image = isset($row['image']) ? (int) $row['image'] : 0;

        // タイトルも説明も空の行は出力しない（番号も消費させない）
        if (trim($title) === '' && trim($desc) === '') {
            continue;
        }
        $out[] = array(
            'title' => $title,
            'desc'  => $desc,
            'image' => $image,
        );
    }

    // 上限を超えた画像は表示しない（保存側でも弾くが、DBを直接触られた場合の保険）
    $seen = 0;
    foreach ($out as $i => $row) {
        if (! $row['image']) {
            continue;
        }
        $seen++;
        if ($seen > VR_SALON_FLOW_MAX_IMAGES) {
            $out[$i]['image'] = 0;
        }
    }

    return $out;
}

/**
 * メタボックスの登録
 */
function vr_add_salon_flow_metabox(): void
{
    add_meta_box(
        'vr-salon-flow',
        '施術の流れ',
        'vr_render_salon_flow_metabox',
        'salons',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'vr_add_salon_flow_metabox');

/**
 * 1行分のHTML
 *
 * @param int|string $index 数値インデックス、またはJS用のプレースホルダ
 */
function vr_salon_flow_row(array $row, $index): string
{
    $title = isset($row['title']) ? (string) $row['title'] : '';
    $desc  = isset($row['desc']) ? (string) $row['desc'] : '';
    $image = isset($row['image']) ? (int) $row['image'] : 0;
    $thumb = $image ? wp_get_attachment_image_url($image, 'thumbnail') : '';
    $name  = 'vr_salon_flow[' . $index . ']';

    ob_start();
    ?>
    <div class="vr-flow-row">
        <div class="vr-flow-row__handle">
            <span class="vr-flow-row__num"></span>
            <div class="vr-flow-row__move">
                <button type="button" class="button vr-flow-up" aria-label="ひとつ上へ">▲</button>
                <button type="button" class="button vr-flow-down" aria-label="ひとつ下へ">▼</button>
            </div>
        </div>
        <div class="vr-flow-row__body">
            <p>
                <label><strong>ステップ名</strong><br>
                    <input type="text" class="widefat" name="<?php echo esc_attr($name); ?>[title]"
                           value="<?php echo esc_attr($title); ?>" placeholder="例）カウンセリング・ご案内">
                </label>
            </p>
            <p>
                <label><strong>説明</strong><br>
                    <textarea class="widefat" rows="3" name="<?php echo esc_attr($name); ?>[desc]"
                              placeholder="例）ご希望や肌状態をうかがい、最適なプランをご提案します。"><?php echo esc_textarea($desc); ?></textarea>
                </label>
            </p>
            <p class="vr-flow-row__media">
                <strong>装飾画像（任意）</strong><br>
                <span class="vr-flow-thumb"><?php if ($thumb) : ?><img src="<?php echo esc_url($thumb); ?>" alt=""><?php endif; ?></span>
                <input type="hidden" class="vr-flow-image" name="<?php echo esc_attr($name); ?>[image]" value="<?php echo esc_attr((string) $image); ?>">
                <button type="button" class="button vr-flow-select">画像を選択</button>
                <button type="button" class="button vr-flow-clear"<?php echo $image ? '' : ' style="display:none"'; ?>>画像を外す</button>
            </p>
        </div>
        <div class="vr-flow-row__actions">
            <button type="button" class="button-link delete vr-flow-remove">このステップを削除</button>
        </div>
    </div>
    <?php
    return (string) ob_get_clean();
}

/**
 * メタボックス本体
 */
function vr_render_salon_flow_metabox(WP_Post $post): void
{
    wp_nonce_field('vr_save_salon_flow', 'vr_salon_flow_nonce');
    $rows = get_post_meta($post->ID, VR_SALON_FLOW_META, true);
    $rows = is_array($rows) ? $rows : array();
    ?>
    <p class="description">
        ステップは必要な数だけ追加できます。番号は並び順から自動で振られるので入力は不要です。
        並べ替えは ▲▼ ボタンで行えます。
    </p>
    <p class="description" id="vr-flow-image-count">
        装飾画像は<strong>最大 <?php echo esc_html((string) VR_SALON_FLOW_MAX_IMAGES); ?> 枚</strong>まで設定できます
        （デザインの都合上、4枚以上は表示が崩れるため）。
    </p>
    <div id="vr-flow-list"><?php
        foreach (array_values($rows) as $i => $row) {
            echo vr_salon_flow_row((array) $row, $i); // phpcs:ignore WordPress.Security.EscapeOutput
        }
    ?></div>
    <p><button type="button" class="button button-primary" id="vr-flow-add">ステップを追加</button></p>

    <script type="text/html" id="tmpl-vr-flow-row"><?php
        echo vr_salon_flow_row(array(), '__INDEX__'); // phpcs:ignore WordPress.Security.EscapeOutput
    ?></script>

    <style>
        #vr-flow-list { margin: 12px 0; }
        .vr-flow-row { display: flex; gap: 12px; align-items: flex-start; padding: 12px; margin-bottom: 10px;
                       border: 1px solid #dcdcde; background: #fff; border-radius: 4px; }
        .vr-flow-row__handle { flex: 0 0 56px; text-align: center; }
        .vr-flow-row__num { display: inline-block; width: 32px; height: 32px; line-height: 32px; margin-bottom: 6px;
                            border-radius: 50%; background: #CA7F13; color: #fff; font-weight: 700; }
        .vr-flow-row__move { display: flex; flex-direction: column; gap: 4px; }
        .vr-flow-row__move .button { padding: 0 6px; min-height: 24px; line-height: 22px; }
        .vr-flow-row__body { flex: 1 1 auto; }
        .vr-flow-row__body p { margin: 0 0 10px; }
        .vr-flow-row__actions { flex: 0 0 auto; }
        .vr-flow-thumb img { display: block; max-width: 80px; height: auto; margin-bottom: 6px; }
    </style>

    <script>
    (function () {
        var list = document.getElementById('vr-flow-list');
        var addBtn = document.getElementById('vr-flow-add');
        var tpl = document.getElementById('tmpl-vr-flow-row').textContent;
        var counter = document.getElementById('vr-flow-image-count');
        var MAX_IMAGES = <?php echo (int) VR_SALON_FLOW_MAX_IMAGES; ?>;
        var frame = null;

        // name 属性の添字を並び順で振り直す（送信データの順序＝画面の順序にする）
        function reindex() {
            var rows = list.querySelectorAll('.vr-flow-row');
            Array.prototype.forEach.call(rows, function (row, i) {
                row.querySelector('.vr-flow-row__num').textContent = i + 1;
                Array.prototype.forEach.call(row.querySelectorAll('[name^="vr_salon_flow["]'), function (el) {
                    el.name = el.name.replace(/vr_salon_flow\[[^\]]*\]/, 'vr_salon_flow[' + i + ']');
                });
                row.querySelector('.vr-flow-up').disabled = (i === 0);
                row.querySelector('.vr-flow-down').disabled = (i === rows.length - 1);
            });
            updateImageLimit();
        }

        // 画像の枚数が上限に達したら、未設定の行の「画像を選択」を押せなくする
        function updateImageLimit() {
            var used = 0;
            Array.prototype.forEach.call(list.querySelectorAll('.vr-flow-image'), function (input) {
                if (input.value) { used++; }
            });
            var full = used >= MAX_IMAGES;
            Array.prototype.forEach.call(list.querySelectorAll('.vr-flow-row'), function (row) {
                var hasImage = !!row.querySelector('.vr-flow-image').value;
                var selectBtn = row.querySelector('.vr-flow-select');
                selectBtn.disabled = full && !hasImage;
                selectBtn.title = selectBtn.disabled
                    ? '装飾画像は最大' + MAX_IMAGES + '枚までです。他のステップの画像を外すと選べます。'
                    : '';
            });
            counter.innerHTML = '装飾画像は<strong>最大 ' + MAX_IMAGES + ' 枚</strong>まで設定できます'
                + '（デザインの都合上、4枚以上は表示が崩れるため）。現在 <strong>' + used + ' 枚</strong>設定中。'
                + (full ? ' <span style="color:#b32d2e">上限に達しています。</span>' : '');
        }

        addBtn.addEventListener('click', function () {
            var wrap = document.createElement('div');
            wrap.innerHTML = tpl.replace(/__INDEX__/g, String(list.children.length));
            list.appendChild(wrap.firstElementChild);
            reindex();
        });

        list.addEventListener('click', function (e) {
            var row = e.target.closest('.vr-flow-row');
            if (!row) { return; }

            if (e.target.closest('.vr-flow-remove')) {
                row.remove();
                reindex();
                return;
            }
            if (e.target.closest('.vr-flow-up') && row.previousElementSibling) {
                row.parentNode.insertBefore(row, row.previousElementSibling);
                reindex();
                return;
            }
            if (e.target.closest('.vr-flow-down') && row.nextElementSibling) {
                row.parentNode.insertBefore(row.nextElementSibling, row);
                reindex();
                return;
            }
            if (e.target.closest('.vr-flow-clear')) {
                row.querySelector('.vr-flow-image').value = '';
                row.querySelector('.vr-flow-thumb').innerHTML = '';
                e.target.style.display = 'none';
                updateImageLimit();
                return;
            }
            if (e.target.closest('.vr-flow-select')) {
                e.preventDefault();
                frame = wp.media({ title: '装飾画像を選択', multiple: false,
                                   library: { type: 'image' }, button: { text: 'この画像を使う' } });
                frame.on('select', function () {
                    var att = frame.state().get('selection').first().toJSON();
                    var url = (att.sizes && att.sizes.thumbnail) ? att.sizes.thumbnail.url : att.url;
                    row.querySelector('.vr-flow-image').value = att.id;
                    row.querySelector('.vr-flow-thumb').innerHTML = '<img src="' + url + '" alt="">';
                    row.querySelector('.vr-flow-clear').style.display = '';
                    updateImageLimit();
                });
                frame.open();
            }
        });

        reindex();
    })();
    </script>
    <?php
}

/**
 * 管理画面でメディアアップローダを使えるようにする
 */
function vr_salon_flow_admin_assets(string $hook): void
{
    if (! in_array($hook, array('post.php', 'post-new.php'), true)) {
        return;
    }
    $screen = get_current_screen();
    if (! $screen || $screen->post_type !== 'salons') {
        return;
    }
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'vr_salon_flow_admin_assets');

/**
 * 保存
 */
function vr_save_salon_flow(int $post_id): void
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (! isset($_POST['vr_salon_flow_nonce'])
        || ! wp_verify_nonce(sanitize_key(wp_unslash($_POST['vr_salon_flow_nonce'])), 'vr_save_salon_flow')) {
        return;
    }
    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $raw = isset($_POST['vr_salon_flow']) ? wp_unslash($_POST['vr_salon_flow']) : array();
    if (! is_array($raw)) {
        $raw = array();
    }

    $rows = array();
    $vr_image_count = 0;
    foreach ($raw as $row) {
        if (! is_array($row)) {
            continue;
        }
        $title = isset($row['title']) ? sanitize_text_field($row['title']) : '';
        $desc  = isset($row['desc']) ? sanitize_textarea_field($row['desc']) : '';
        $image = isset($row['image']) ? absint($row['image']) : 0;

        if (trim($title) === '' && trim($desc) === '' && $image === 0) {
            continue; // 完全に空の行は保存しない
        }
        // 画像は上限まで。超えた分はステップ自体は残して画像だけ落とす。
        if ($image) {
            $vr_image_count++;
            if ($vr_image_count > VR_SALON_FLOW_MAX_IMAGES) {
                $image = 0;
            }
        }
        $rows[] = array(
            'title' => $title,
            'desc'  => $desc,
            'image' => $image,
        );
    }

    if ($rows) {
        update_post_meta($post_id, VR_SALON_FLOW_META, $rows);
    } else {
        delete_post_meta($post_id, VR_SALON_FLOW_META);
    }
}
add_action('save_post_salons', 'vr_save_salon_flow');
