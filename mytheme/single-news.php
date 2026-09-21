<?php
/**
 * Single: news（お知らせ詳細）
 *
 * 静的 HTML: news-single.html
 *
 * 本文は ACF 柔軟コンテンツ `news_body` から出力する。
 * レイアウトは paragraph（段落）/ heading（小見出し）/ list（箇条書き）の 3 種類で、
 * スタッフが任意の数・順番でブロックを追加できる。
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$vr_img = VR_THEME_URI . '/assets/images';
?>

<main id="main">
    <?php
    while (have_posts()) :
        the_post();

        $vr_label     = function_exists('get_field') ? (string) get_field('news_label') : '';
        $vr_thumb_url = vr_get_thumbnail_url_or_placeholder();
        ?>
        <section class="page-hero" aria-labelledby="page-hero-heading">
            <div class="page-hero__title-strip">
                <div class="inner">
                    <p id="page-hero-heading" class="page-hero__title">News</p>
                </div>
            </div>
            <div class="page-hero__parallax js-page-hero-parallax">
                <div class="page-hero__bg">
                    <picture>
                        <source media="(max-width: 768px)" srcset="<?php echo esc_url($vr_img . '/page/news_top-sp.jpg'); ?>">
                        <img class="page-hero__img" src="<?php echo esc_url($vr_img . '/page/news_top-pc.jpg'); ?>" width="1440" height="600" alt="" loading="eager" decoding="async">
                    </picture>
                </div>
            </div>
        </section>

        <div class="news-single__breadcrumb-bar">
            <div class="inner">
                <nav class="breadcrumb" aria-label="パンくず">
                    <ol class="breadcrumb__list">
                        <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('home')); ?>">ホーム</a></li>
                        <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('news')); ?>">ニュース一覧</a></li>
                        <li class="breadcrumb__item"><span aria-current="page"><?php the_title(); ?></span></li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="news-single" aria-labelledby="news-single-title">
            <div class="inner news-single__inner">
                <article class="news-single__article">
                    <h1 id="news-single-title" class="news-single__title"><?php the_title(); ?></h1>
                    <p class="news-single__meta">
                        <?php if ($vr_label !== '') : ?>
                            <span class="news-single__label" lang="en"><?php echo esc_html($vr_label); ?></span>
                        <?php endif; ?>
                        <time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
                    </p>

                    <figure class="news-single__thumb">
                        <img src="<?php echo esc_url($vr_thumb_url); ?>" width="691" height="250" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" decoding="async">
                    </figure>

                    <div class="news-single__body">
                        <?php
                        // 本文はブロックエディタ。段落・小見出し・箇条書きを任意の数・順番で
                        // 追加でき、出力は素の p / h3 / ul となる（SCSS が直接その要素を見ている）。
                        the_content();
                        ?>
                    </div>

                    <p class="news-single__actions">
                        <a href="<?php echo esc_url(vr_url('news')); ?>" class="news-single__back">お知らせ一覧へ</a>
                    </p>
                </article>

                <aside class="news-single__aside" aria-labelledby="news-single-cat-heading" aria-label="カテゴリ">
                    <h2 id="news-single-cat-heading" class="news-single__cat-heading" lang="en">Category</h2>
                    <ul class="news-single__cat-list">
                        <li class="news-single__cat-item"><a href="<?php echo esc_url(vr_url('news')); ?>" class="news-single__cat-link">すべて</a></li>
                        <li class="news-single__cat-item"><a href="#" class="news-single__cat-link">キャンペーン</a></li>
                        <li class="news-single__cat-item"><a href="#" class="news-single__cat-link">お知らせ</a></li>
                        <li class="news-single__cat-item"><a href="#" class="news-single__cat-link" aria-current="true">コラム</a></li>
                    </ul>
                </aside>
            </div>
        </section>
        <?php
    endwhile;
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
            <div class="reserve-cta__copy">
                <p class="reserve-cta__title">RESERVE</p>
                <p class="reserve-cta__lead">予約はこちらから</p>
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
</main>

<?php
get_footer();
