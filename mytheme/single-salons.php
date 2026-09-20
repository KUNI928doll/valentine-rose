<?php
/**
 * Single: salons（店舗詳細）
 *
 * 静的 HTML: salon-single.html
 *
 * 指示書の要件:
 *  - 「施術の流れ」は店舗ごとに流れもステップ数も違うため、ACF リピーター
 *    `salon_flow` を任意数ループする。番号はループのインデックスから自動採番。
 *  - 店舗詳細のテキスト・画像は各店舗スタッフが入力するため、すべてカスタム
 *    フィールドから出力する（文言のハードコードなし）。
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * 地図の埋め込みコードで許可する属性
 * （esc_html だとタグが文字列になって地図が出ないため wp_kses を使う）
 */
$vr_map_allowed_html = array(
    'iframe' => array(
        'src'             => true,
        'title'           => true,
        'class'           => true,
        'id'              => true,
        'name'            => true,
        'width'           => true,
        'height'          => true,
        'style'           => true,
        'frameborder'     => true,
        'scrolling'       => true,
        'marginwidth'     => true,
        'marginheight'    => true,
        'allow'           => true,
        'allowfullscreen' => true,
        'loading'         => true,
        'referrerpolicy'  => true,
        'aria-hidden'     => true,
        'aria-label'      => true,
    ),
);

/**
 * 管理者が貼った iframe に表示用のクラス（と未指定なら title）を付与する。
 *
 * Google マップのコピー元には class が無いため、そのままだと
 * .salon-single-access__map-iframe（4:3 枠へ敷き詰め）が効かない。
 *
 * @param string $html  wp_kses 済みの埋め込みコード。
 * @param string $title title 属性が無かった場合に補うテキスト。
 */
$vr_map_decorate = function (string $html, string $title): string {
    return (string) preg_replace_callback(
        '/<iframe\b([^>]*)>/i',
        function (array $m) use ($title): string {
            $attrs = $m[1];

            if (preg_match('/\sclass\s*=\s*"([^"]*)"/i', $attrs)) {
                $attrs = preg_replace('/\sclass\s*=\s*"([^"]*)"/i', ' class="$1 salon-single-access__map-iframe"', $attrs, 1);
            } elseif (preg_match("/\sclass\s*=\s*'([^']*)'/i", $attrs)) {
                $attrs = preg_replace("/\sclass\s*=\s*'([^']*)'/i", " class='$1 salon-single-access__map-iframe'", $attrs, 1);
            } else {
                $attrs = ' class="salon-single-access__map-iframe"' . $attrs;
            }

            if ($title !== '' && ! preg_match('/\stitle\s*=/i', $attrs)) {
                $attrs = ' title="' . esc_attr($title) . '"' . $attrs;
            }

            return '<iframe' . $attrs . '>';
        },
        $html,
        1
    );
};

get_header();

$vr_img = VR_THEME_URI . '/assets/images';
?>

<main id="main">
    <?php
    while (have_posts()) :
        the_post();

        $vr_salon_name = get_the_title();

        $vr_staff_photo = function_exists('get_field') ? get_field('salon_staff_photo') : null;
        $vr_staff_bio   = function_exists('get_field') ? (string) get_field('salon_staff_bio') : '';
        $vr_staff_name  = function_exists('get_field') ? (string) get_field('salon_staff_name') : '';

        $vr_address  = function_exists('get_field') ? (string) get_field('salon_address') : '';
        $vr_access   = function_exists('get_field') ? (string) get_field('salon_access') : '';
        $vr_tel      = function_exists('get_field') ? (string) get_field('salon_tel') : '';
        $vr_tel_note = function_exists('get_field') ? (string) get_field('salon_tel_note') : '';
        $vr_hours    = function_exists('get_field') ? (string) get_field('salon_hours') : '';
        $vr_map      = function_exists('get_field') ? (string) get_field('salon_map') : '';

        // tel: リンク用にハイフン・括弧・空白などを除去（先頭の + は残す）
        // 全角で入力されても拾えるよう、先に半角へ寄せる
        $vr_tel_href = function_exists('mb_convert_kana') ? mb_convert_kana($vr_tel, 'a', 'UTF-8') : $vr_tel;
        $vr_tel_href = preg_replace('/[^0-9+]/', '', $vr_tel_href);
        $vr_tel_href = is_string($vr_tel_href) ? $vr_tel_href : '';

        // 画像フィールドは通常 ACF が配列を返すが、CLI や移行で入れたデータだと
        // 参照キー（_salon_staff_photo）が無く添付IDのまま返ることがある。両方を受ける。
        if (! is_array($vr_staff_photo) && $vr_staff_photo) {
            $vr_staff_photo_id = absint($vr_staff_photo);
            $vr_staff_meta     = $vr_staff_photo_id ? wp_get_attachment_metadata($vr_staff_photo_id) : array();
            $vr_staff_photo    = array(
                'url'    => (string) wp_get_attachment_image_url($vr_staff_photo_id, 'large'),
                'width'  => isset($vr_staff_meta['width']) ? $vr_staff_meta['width'] : '',
                'height' => isset($vr_staff_meta['height']) ? $vr_staff_meta['height'] : '',
                'alt'    => (string) get_post_meta($vr_staff_photo_id, '_wp_attachment_image_alt', true),
            );
        }
        $vr_staff_photo_url = (is_array($vr_staff_photo) && ! empty($vr_staff_photo['url'])) ? (string) $vr_staff_photo['url'] : '';
        $vr_has_staff       = $vr_staff_photo_url !== '' || trim($vr_staff_bio) !== '' || trim($vr_staff_name) !== '';
        $vr_has_info        = trim($vr_address) !== '' || trim($vr_access) !== '' || trim($vr_tel) !== '' || trim($vr_hours) !== '';
        $vr_has_access      = $vr_has_info || trim($vr_map) !== '';
        ?>

        <section class="page-hero" aria-labelledby="salon-single-hero-heading">
            <div class="page-hero__title-strip">
                <div class="inner salon-single-hero__title-inner">
                    <h1 id="salon-single-hero-heading" class="salon-single-hero__heading">
                        <span class="salon-single-hero__brand" lang="en">VALENTINE ROSE</span>
                        <span class="salon-single-hero__shop-name"><?php echo esc_html($vr_salon_name); ?></span>
                    </h1>
                </div>
            </div>
            <div class="page-hero__parallax js-page-hero-parallax">
                <div class="page-hero__bg">
                    <?php
                    // FV は 1440px 幅で出すため、既定の large(1024px) ではなく原寸を使う。
                    // SP 用画像が設定されていれば静的版と同じく <source> で切り替える。
                    $vr_hero_pc    = vr_get_thumbnail_url_or_placeholder(null, 'full');
                    $vr_hero_sp_fld = function_exists('get_field') ? get_field('salon_hero_sp') : null;
                    $vr_hero_sp    = '';
                    if (is_array($vr_hero_sp_fld) && ! empty($vr_hero_sp_fld['url'])) {
                        $vr_hero_sp = (string) $vr_hero_sp_fld['url'];
                    } elseif ($vr_hero_sp_fld) {
                        // CLI や移行で添付IDのまま入っている場合
                        $vr_hero_sp = (string) wp_get_attachment_image_url(absint($vr_hero_sp_fld), 'full');
                    }
                    ?>
                    <picture>
                        <?php if ($vr_hero_sp !== '') : ?>
                            <source media="(max-width: 768px)" srcset="<?php echo esc_url($vr_hero_sp); ?>">
                        <?php endif; ?>
                        <img class="page-hero__img" src="<?php echo esc_url($vr_hero_pc); ?>" width="1440" height="600" alt="" loading="eager" decoding="async">
                    </picture>
                </div>
            </div>
        </section>

        <div class="salon-single__breadcrumb-bar">
            <div class="inner">
                <nav class="breadcrumb" aria-label="パンくず">
                    <ol class="breadcrumb__list">
                        <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('home')); ?>">ホーム</a></li>
                        <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('salons')); ?>">店舗一覧</a></li>
                        <li class="breadcrumb__item"><span aria-current="page"><?php echo esc_html($vr_salon_name); ?></span></li>
                    </ol>
                </nav>
            </div>
        </div>

        <?php
        // 紹介文は本文欄（ブロックエディタ）。段落を任意の数だけ追加できる。
        if (trim(get_the_content()) !== '') :
            ?>
            <section class="salon-single-intro" aria-labelledby="salon-single-intro-heading">
                <div class="inner">
                    <h2 id="salon-single-intro-heading" class="visually-hidden"><?php echo esc_html($vr_salon_name . 'について'); ?></h2>
                    <div class="salon-single-intro__body">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php
        // 施術の流れ: 専用メタボックス（inc/salon-flow-metabox.php）から取得。
        // 店舗ごとにステップ数が異なるため件数は固定しない。番号は並び順から自動採番。
        $vr_flow_rows = vr_get_salon_flow();
        $vr_deco_index = 0; // 装飾画像の通し番号（左右の振り分けに使う）
        if ($vr_flow_rows) :
            ?>
            <section class="salon-single-flow" id="flow" aria-labelledby="salon-single-flow-heading">
                <div class="inner">
                    <header class="salon-single-flow__head">
                        <p class="salon-single-flow__en" aria-hidden="true">FLOW</p>
                        <h2 id="salon-single-flow-heading" class="salon-single-flow__title">施術の流れ</h2>
                    </header>
                    <ol class="salon-single-flow__list">
                        <?php foreach ($vr_flow_rows as $vr_flow_index => $vr_flow_row) : ?>
                            <li class="salon-single-flow__item">
                                <span class="salon-single-flow__num"><?php echo esc_html((string) ($vr_flow_index + 1)); ?></span>
                                <div class="salon-single-flow__body">
                                    <?php if (trim($vr_flow_row['title']) !== '') : ?>
                                        <h3 class="salon-single-flow__step-title"><?php echo esc_html($vr_flow_row['title']); ?></h3>
                                    <?php endif; ?>
                                    <?php if (trim($vr_flow_row['desc']) !== '') : ?>
                                        <p class="salon-single-flow__desc"><?php echo nl2br(esc_html($vr_flow_row['desc'])); ?></p>
                                    <?php endif; ?>
                                    <?php
                                    // 装飾画像（任意。設定されたステップにのみ入る）
                                    $vr_flow_img = $vr_flow_row['image'] ? wp_get_attachment_image_url($vr_flow_row['image'], 'medium') : '';
                                    if ($vr_flow_img) :
                                        // 左右交互に振る（1枚目=左 / 2枚目=右 / 3枚目=左）。
                                        // 指示書「3枚目の画像の位置はテキストに被らないよう、よしなに設定する」への対応。
                                        $vr_deco_index++;
                                        $vr_deco_side = ($vr_deco_index % 2 === 1) ? 'left' : 'right';
                                        ?>
                                        <figure class="salon-single-flow__deco salon-single-flow__deco--<?php echo esc_attr($vr_deco_side); ?>">
                                            <img src="<?php echo esc_url($vr_flow_img); ?>" width="200" height="200" alt="" loading="lazy">
                                        </figure>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($vr_has_staff) : ?>
            <section class="salon-single-staff" aria-labelledby="salon-single-staff-heading">
                <div class="inner salon-single-staff__inner">
                    <?php
                    if ($vr_staff_photo_url !== '') :
                        $vr_staff_photo_w   = ! empty($vr_staff_photo['width']) ? (string) $vr_staff_photo['width'] : '400';
                        $vr_staff_photo_h   = ! empty($vr_staff_photo['height']) ? (string) $vr_staff_photo['height'] : '400';
                        $vr_staff_photo_alt = ! empty($vr_staff_photo['alt']) ? (string) $vr_staff_photo['alt'] : 'スタッフ写真';
                        ?>
                        <figure class="salon-single-staff__photo">
                            <img src="<?php echo esc_url($vr_staff_photo_url); ?>" width="<?php echo esc_attr($vr_staff_photo_w); ?>" height="<?php echo esc_attr($vr_staff_photo_h); ?>" alt="<?php echo esc_attr($vr_staff_photo_alt); ?>" loading="lazy">
                        </figure>
                    <?php endif; ?>
                    <div class="salon-single-staff__text">
                        <p class="salon-single-staff__en" lang="en">Staff</p>
                        <h2 id="salon-single-staff-heading" class="salon-single-staff__sub">スタッフ紹介</h2>
                        <?php if (trim($vr_staff_bio) !== '') : ?>
                            <p class="salon-single-staff__bio">
                                <?php echo nl2br(esc_html($vr_staff_bio)); ?>
                            </p>
                        <?php endif; ?>
                        <?php if (trim($vr_staff_name) !== '') : ?>
                            <p class="salon-single-staff__name"><?php echo esc_html($vr_staff_name); ?></p>
                        <?php endif; ?>
                        <a href="#" class="salon-single-staff__more">スタッフをもっと見る <i class="fas fa-chevron-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($vr_has_access) : ?>
            <section class="salon-single-access" aria-labelledby="salon-single-access-heading">
                <div class="inner">
                    <h2 id="salon-single-access-heading" class="visually-hidden">アクセス・地図</h2>
                    <div class="salon-single-access__grid">
                        <?php if ($vr_has_info) : ?>
                            <div class="salon-single-access__info">
                                <dl class="salon-single-access__dl">
                                    <?php if (trim($vr_address) !== '') : ?>
                                        <div class="salon-single-access__row">
                                            <dt class="salon-single-access__dt">住所</dt>
                                            <dd class="salon-single-access__dd"><?php echo nl2br(esc_html($vr_address)); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (trim($vr_access) !== '') : ?>
                                        <div class="salon-single-access__row">
                                            <dt class="salon-single-access__dt">アクセス</dt>
                                            <dd class="salon-single-access__dd"><?php echo nl2br(esc_html($vr_access)); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (trim($vr_tel) !== '') : ?>
                                        <div class="salon-single-access__row">
                                            <dt class="salon-single-access__dt">電話番号</dt>
                                            <dd class="salon-single-access__dd"><?php
                                                if ($vr_tel_href !== '') {
                                                    echo '<a href="' . esc_url('tel:' . $vr_tel_href) . '">' . esc_html($vr_tel) . '</a>';
                                                } else {
                                                    echo esc_html($vr_tel);
                                                }
                                                if (trim($vr_tel_note) !== '') {
                                                    echo esc_html('（' . $vr_tel_note . '）');
                                                }
                                            ?></dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (trim($vr_hours) !== '') : ?>
                                        <div class="salon-single-access__row">
                                            <dt class="salon-single-access__dt">営業時間</dt>
                                            <dd class="salon-single-access__dd"><?php echo nl2br(esc_html($vr_hours)); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                </dl>
                            </div>
                        <?php endif; ?>
                        <?php
                        if (trim($vr_map) !== '') :
                            $vr_map_html = $vr_map_decorate(wp_kses($vr_map, $vr_map_allowed_html), $vr_salon_name . 'の地図');
                            if (trim($vr_map_html) !== '') :
                                ?>
                                <div class="salon-single-access__map">
                                    <?php echo $vr_map_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_kses 済み ?>
                                </div>
                                <?php
                            endif;
                        endif;
                        ?>
                    </div>
                    <div class="salon-single-access__cta">
                        <a href="<?php echo esc_url(vr_url('reserve')); ?>" class="button">ご予約</a>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <section class="reserve-cta" id="reserve">
            <a href="<?php echo esc_url(vr_url('reserve')); ?>" class="reserve-cta__link">
                <div class="reserve-cta__media">
                    <picture>
                        <source srcset="<?php echo esc_url($vr_img . '/page/reserve_top-sp.png'); ?>" width="375" height="200" media="(max-width: 768px)">
                        <img src="<?php echo esc_url($vr_img . '/page/reserve_top-pc.png'); ?>" width="1024" height="284" alt="" loading="lazy">
                    </picture>
                </div>
                <span class="reserve-cta__overlay" aria-hidden="true"></span>
                <div class="reserve-cta__copy">
                    <p class="reserve-cta__title">RESERVE</p>
                    <p class="reserve-cta__lead">ご予約はこちらから</p>
                </div>
            </a>
        </section>

        <section class="salons-sns" id="salons-sns" aria-labelledby="salons-sns-heading">
            <h2 id="salons-sns-heading" class="salons-sns__heading visually-hidden">店舗・SNS</h2>
            <div class="inner">
                <div class="salons-sns__row">
                    <a href="<?php echo esc_url(vr_url('salons')); ?>" class="salons-sns__col"><span class="salons-sns__title" lang="en">SALONS</span><span class="salons-sns__sub">店舗一覧</span></a>
                    <span class="salons-sns__vline" aria-hidden="true"></span>
                    <a href="#" class="salons-sns__col"><span class="salons-sns__title" lang="en">SNS</span><span class="salons-sns__sub">インスタグラム</span></a>
                </div>
                <div class="salons-sns__rule" aria-hidden="true"></div>
            </div>
        </section>

        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
