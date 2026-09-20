<?php
/**
 * Archive: salons（店舗一覧）
 *
 * 静的 HTML: salons.html の <main> 内を移植。
 * ヘッダー / ドロワー / フッターは header.php / footer.php が持つ。
 *
 * 店舗は ACF の salon_region（地域）でグルーピングして出力する。
 * 並び順は静的 HTML の都道府県順を既定とし、未知の地域は末尾に回す。
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

$vr_img = VR_THEME_URI . '/assets/images';

/**
 * 静的 HTML の並び順（既定）。
 * keys: salon_region に入り得る表記のゆれ（小文字で比較する）。
 */
$vr_region_defs = array(
    array('slug' => 'tokyo',    'en' => 'Tokyo',    'ja' => '東京都',   'keys' => array('東京都', '東京', 'tokyo')),
    array('slug' => 'kanagawa', 'en' => 'Kanagawa', 'ja' => '神奈川県', 'keys' => array('神奈川県', '神奈川', 'kanagawa')),
    array('slug' => 'saitama',  'en' => 'Saitama',  'ja' => '埼玉県',   'keys' => array('埼玉県', '埼玉', 'saitama')),
    array('slug' => 'ishikawa', 'en' => 'Ishikawa', 'ja' => '石川県',   'keys' => array('石川県', '石川', 'ishikawa')),
    array('slug' => 'aichi',    'en' => 'Aichi',    'ja' => '愛知県',   'keys' => array('愛知県', '愛知', 'aichi')),
    array('slug' => 'kyoto',    'en' => 'Kyoto',    'ja' => '京都府',   'keys' => array('京都府', '京都', 'kyoto')),
    array('slug' => 'osaka',    'en' => 'Osaka',    'ja' => '大阪府',   'keys' => array('大阪府', '大阪', 'osaka')),
    array('slug' => 'fukuoka',  'en' => 'Fukuoka',  'ja' => '福岡県',   'keys' => array('福岡県', '福岡', 'fukuoka')),
    array('slug' => 'okinawa',  'en' => 'Okinawa',  'ja' => '沖縄県',   'keys' => array('沖縄県', '沖縄', 'okinawa')),
);

/**
 * 表記ゆれ吸収用の小文字化（mbstring が無い環境でも UTF-8 を壊さない）。
 */
$vr_lower = static function (string $text): string {
    return function_exists('mb_strtolower') ? mb_strtolower($text, 'UTF-8') : strtolower($text);
};

// 表記ゆれ → 既定順のインデックス
$vr_region_index = array();
foreach ($vr_region_defs as $vr_i => $vr_def) {
    foreach ($vr_def['keys'] as $vr_key) {
        $vr_region_index[$vr_lower($vr_key)] = $vr_i;
    }
}

/**
 * ACF のテキストフィールドを安全に取り出す（ACF 無効環境でも落とさない）。
 */
$vr_field = static function (string $name, int $post_id): string {
    if (! function_exists('get_field')) {
        return '';
    }
    $value = get_field($name, $post_id);

    return is_string($value) ? trim($value) : '';
};

$vr_query = new WP_Query(
    array(
        'post_type'      => 'salons',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    )
);

// 地域ごとに振り分ける
$vr_groups      = array();
$vr_extra_order = 1000;

foreach ($vr_query->posts as $vr_post_obj) {
    $vr_raw = $vr_field('salon_region', (int) $vr_post_obj->ID);
    $vr_key = $vr_lower($vr_raw);

    if ($vr_raw !== '' && isset($vr_region_index[$vr_key])) {
        $vr_def   = $vr_region_defs[$vr_region_index[$vr_key]];
        $vr_slug  = $vr_def['slug'];
        $vr_en    = $vr_def['en'];
        $vr_ja    = $vr_def['ja'];
        $vr_order = $vr_region_index[$vr_key];
    } elseif ($vr_raw !== '') {
        // 既定に無い地域は末尾へ。
        // 日本語は sanitize_title が URL エンコードを返すので、その場合は入力値から
        // 一意かつ安定した ID を作る（同じ地域名が別グループに割れないようにする）。
        $vr_slug = sanitize_title($vr_raw);
        if ($vr_slug === '' || strpos($vr_slug, '%') !== false) {
            $vr_slug = 'region-' . substr(md5($vr_key), 0, 8);
        }
        $vr_en    = $vr_raw;
        $vr_ja    = $vr_raw;
        $vr_order = $vr_extra_order;
    } else {
        // 地域未入力の店舗も取りこぼさない
        $vr_slug  = 'other';
        $vr_en    = 'Other';
        $vr_ja    = 'その他';
        $vr_order = PHP_INT_MAX;
    }

    if (! isset($vr_groups[$vr_slug])) {
        $vr_groups[$vr_slug] = array(
            'slug'  => $vr_slug,
            'en'    => $vr_en,
            'ja'    => $vr_ja,
            'order' => $vr_order,
            'posts' => array(),
        );
        if ($vr_order === $vr_extra_order) {
            ++$vr_extra_order;
        }
    }

    $vr_groups[$vr_slug]['posts'][] = $vr_post_obj;
}

uasort(
    $vr_groups,
    static function (array $a, array $b): int {
        return $a['order'] <=> $b['order'];
    }
);

// <body class="page-salons"> は functions.php の vr_body_class() が付与する。

get_header();
?>

  <main id="main">
    <section class="page-hero page-hero--salons-archive" aria-labelledby="page-hero-heading">
      <div class="page-hero__title-strip">
        <div class="inner">
          <h1 id="page-hero-heading" class="page-hero__title">Salons</h1>
        </div>
      </div>
      <div class="page-hero__parallax js-page-hero-parallax">
        <div class="page-hero__bg" role="presentation">
          <picture>
            <source media="(max-width: 768px)" srcset="<?php echo esc_url($vr_img . '/page/archive-salons_top-sp.jpg'); ?>">
            <img class="page-hero__img" src="<?php echo esc_url($vr_img . '/page/archive-salons_top-pc.jpg'); ?>" width="1440" height="600" alt="" loading="eager" decoding="async">
          </picture>
        </div>
      </div>
    </section>

    <div class="salons-archive__breadcrumb-bar">
      <div class="inner">
        <nav class="breadcrumb" aria-label="パンくず">
          <ol class="breadcrumb__list">
            <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('home')); ?>">ホーム</a></li>
            <li class="breadcrumb__item"><span aria-current="page">店舗一覧</span></li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="salons-archive-intro" aria-labelledby="salons-archive-heading">
      <div class="inner">
        <header class="salons-archive__head">
          <h2 id="salons-archive-heading" class="salons-archive__en">Prefectures</h2>
          <p class="salons-archive__ja md-show">店舗一覧</p>
          <p class="salons-archive__ja u-md-none">エリア</p>
        </header>
<?php if (! empty($vr_groups)) : ?>

        <nav class="salons-archive-nav salons-archive-nav--pc md-show" aria-label="都道府県（PC）">
          <ul class="salons-archive-nav__grid">
<?php foreach ($vr_groups as $vr_group) : ?>
            <li><a href="#pref-<?php echo esc_attr($vr_group['slug']); ?>" class="salons-archive-nav__link"><i class="fas fa-angle-right salons-archive-nav__ico" aria-hidden="true"></i><?php echo esc_html($vr_group['en']); ?> <span class="salons-archive-nav__count">(<?php echo esc_html((string) count($vr_group['posts'])); ?>)</span></a></li>
<?php endforeach; ?>
          </ul>
        </nav>

        <nav class="salons-archive-nav salons-archive-nav--sp u-md-none" aria-label="都道府県（スマートフォン）">
          <ul class="salons-archive-nav__list-sp">
<?php foreach ($vr_groups as $vr_group) : ?>
            <li class="salons-archive-nav__item-sp"><a href="#pref-<?php echo esc_attr($vr_group['slug']); ?>" class="salons-archive-nav__link-sp"><?php echo esc_html($vr_group['en']); ?></a></li>
<?php endforeach; ?>
          </ul>
        </nav>
<?php endif; ?>
      </div>
    </section>
<?php
global $post;
$vr_region_i = 0;

foreach ($vr_groups as $vr_group) :
    $vr_section_class = 'salons-archive-region' . ($vr_region_i % 2 === 1 ? ' salons-archive-region--alt' : '');
    ++$vr_region_i;
    ?>

    <section class="<?php echo esc_attr($vr_section_class); ?>" id="pref-<?php echo esc_attr($vr_group['slug']); ?>" aria-labelledby="pref-<?php echo esc_attr($vr_group['slug']); ?>-heading">
      <h2 id="pref-<?php echo esc_attr($vr_group['slug']); ?>-heading" class="salons-archive-region__banner"><span class="visually-hidden"><?php echo esc_html($vr_group['ja']); ?></span><span aria-hidden="true"><?php echo esc_html($vr_group['en']); ?></span></h2>
      <div class="inner">
        <ul class="salons-archive-grid">
<?php
    foreach ($vr_group['posts'] as $vr_post_obj) :
        $post = $vr_post_obj; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
        setup_postdata($post);

        $vr_post_id = (int) $post->ID;
        $vr_address = $vr_field('salon_address', $vr_post_id);
        $vr_tel     = $vr_field('salon_tel', $vr_post_id);
        $vr_hours   = $vr_field('salon_hours', $vr_post_id);

        $vr_meta_line2 = implode('／', array_filter(array($vr_tel, $vr_hours), 'strlen'));
        $vr_meta_lines = array_filter(array($vr_address, $vr_meta_line2), 'strlen');
        ?>
          <li class="salons-archive-card">
            <article>
              <?php
              // 指示書:「地図、英語表記、店名、住所もすべて店舗詳細ページが追加されたら
              //         自動的に一覧ページにも追加されるようにする」
              // → すべて店舗詳細（CPT salons）の値をそのまま流用する。
              $vr_card_title = get_the_title();
              $vr_card_en    = function_exists('get_field') ? trim((string) get_field('salon_name_en')) : '';
              $vr_card_map   = function_exists('get_field') ? trim((string) get_field('salon_map')) : '';
              ?>
              <a href="<?php the_permalink(); ?>" class="salons-archive-card__link">
                <div class="salons-archive-card__map">
                  <?php if ($vr_card_map !== '') : ?>
                    <?php echo vr_salon_map_embed($vr_card_map, $vr_card_title); // phpcs:ignore WordPress.Security.EscapeOutput ?>
                  <?php else : ?>
                    <span class="salons-archive-card__pin" aria-hidden="true"><i class="fas fa-map-marker-alt"></i></span>
                  <?php endif; ?>
                </div>
                <div class="salons-archive-card__body">
                  <h3 class="salons-archive-card__name"><?php echo esc_html($vr_card_en !== '' ? $vr_card_en : $vr_card_title); ?></h3>
<?php if ($vr_card_en !== '') : ?>
                  <p class="salons-archive-card__name-ja"><?php echo esc_html($vr_card_title); ?></p>
<?php endif; ?>
<?php if (! empty($vr_meta_lines)) : ?>
                  <p class="salons-archive-card__meta"><?php echo implode('<br>', array_map('esc_html', $vr_meta_lines)); ?></p>
<?php endif; ?>
                </div>
              </a>
            </article>
          </li>
<?php
    endforeach;
    ?>
        </ul>
      </div>
    </section>
<?php
endforeach;

wp_reset_postdata();
?>
    <section class="reserve-cta" id="reserve">
      <a href="<?php echo esc_url(vr_url('reserve')); ?>" class="reserve-cta__link">
        <div class="reserve-cta__media">
          <picture>
            <source srcset="<?php echo esc_url($vr_img . '/page/reserve_top-sp.png'); ?>" width="375" height="200" media="(max-width: 768px)">
            <img src="<?php echo esc_url($vr_img . '/page/reserve_top-pc.png'); ?>" width="1024" height="284" alt="" loading="lazy">
          </picture>
        </div>
        <span class="reserve-cta__overlay" aria-hidden="true"></span>
        <div class="reserve-cta__copy"><p class="reserve-cta__title">RESERVE</p><p class="reserve-cta__lead">予約はこちらから</p></div>
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
  </main>

<?php
get_footer();
