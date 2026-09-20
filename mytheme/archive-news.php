<?php
/**
 * Archive: news（投稿タイプスラッグ news 用）
 *
 * 静的 HTML: news.html を移植。
 * 別スラッグにした場合はファイル名を archive-{post_type}.php に合わせてください。
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$vr_img = VR_THEME_URI . '/assets/images';

// 記事の有無（ループ後は have_posts() が false を返すため先に控える）
$vr_has_posts = have_posts();

// サイドバーの絞り込みに対応するキー（data-news-filter と一致させる）
$vr_filter_keys = array('all', 'news', 'column');
?>

<main id="main">
    <section class="page-hero" aria-labelledby="page-hero-heading">
        <div class="page-hero__title-strip">
            <div class="inner"><h1 id="page-hero-heading" class="page-hero__title">News</h1></div>
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

    <div class="news-archive__breadcrumb-bar">
        <div class="inner">
            <nav class="breadcrumb" aria-label="パンくず">
                <ol class="breadcrumb__list">
                    <li class="breadcrumb__item"><a href="<?php echo esc_url(vr_url('home')); ?>">ホーム</a></li>
                    <li class="breadcrumb__item"><span aria-current="page">ニュース一覧</span></li>
                </ol>
            </nav>
        </div>
    </div>

    <section id="news-archive" class="news-archive js-news-archive" aria-labelledby="news-archive-heading">
        <h2 id="news-archive-heading" class="visually-hidden">ニュース一覧</h2>
        <div class="inner news-archive__inner">
            <div class="news-archive__main">
                <ul class="news-archive__list">
                    <?php
                    if ($vr_has_posts) :
                        while (have_posts()) :
                            the_post();

                            // ラベル（ACF）。未入力時は静的 HTML と同じ「All」を既定にする。
                            $vr_label = function_exists('get_field') ? (string) get_field('news_label') : '';
                            $vr_label = trim($vr_label);
                            if ($vr_label === '') {
                                $vr_label = 'All';
                            }

                            // 絞り込み用キー（js/main.js の data-news-filter と突き合わせる）。
                            $vr_category = sanitize_title($vr_label);
                            if (! in_array($vr_category, $vr_filter_keys, true)) {
                                // 想定外のラベルでも「すべて」には必ず並ぶようにする
                                $vr_category = 'all';
                            }
                            ?>
                            <li class="news-archive__item" data-news-category="<?php echo esc_attr($vr_category); ?>">
                                <article>
                                    <a href="<?php the_permalink(); ?>" class="news-archive__link">
                                        <time class="news-archive__date" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
                                        <span class="news-archive__title"><?php echo esc_html(get_the_title()); ?></span>
                                        <span class="news-archive__label" lang="en"><?php echo esc_html($vr_label); ?></span>
                                    </a>
                                </article>
                            </li>
                            <?php
                        endwhile;
                    endif;
                    ?>
                </ul>

                <p class="news-archive__empty" id="news-archive-empty"<?php echo $vr_has_posts ? ' hidden' : ''; ?>>該当する記事はありません。</p>

                <?php
                global $wp_query;
                $vr_max_page     = (int) $wp_query->max_num_pages;
                $vr_current_page = max(1, (int) get_query_var('paged'));

                if ($vr_max_page > 1) :
                    ?>
                    <nav class="news-archive__pagination" aria-label="ページネーション">
                        <?php
                        for ($vr_page = 1; $vr_page <= $vr_max_page; $vr_page++) :
                            if ($vr_page === $vr_current_page) :
                                ?>
                                <span class="news-archive__page-current" aria-current="page"><?php echo esc_html((string) $vr_page); ?></span>
                                <?php
                            else :
                                ?>
                                <a href="<?php echo esc_url(get_pagenum_link($vr_page)); ?>" class="news-archive__page-link"><?php echo esc_html((string) $vr_page); ?></a>
                                <?php
                            endif;
                        endfor;

                        if ($vr_current_page < $vr_max_page) :
                            ?>
                            <a href="<?php echo esc_url(get_pagenum_link($vr_current_page + 1)); ?>" class="news-archive__page-next" aria-label="次のページへ"><span aria-hidden="true">&gt;</span></a>
                            <?php
                        endif;
                        ?>
                    </nav>
                    <?php
                endif;
                ?>
            </div>

            <aside class="news-archive__aside" aria-labelledby="news-archive-cat-heading" aria-label="カテゴリ">
                <h3 id="news-archive-cat-heading" class="news-archive__cat-heading" lang="en">Category</h3>
                <ul class="news-archive__cat-list">
                    <li class="news-archive__cat-item">
                        <a href="#news-archive" class="news-archive__cat-link js-news-archive-filter" data-news-filter="all" aria-current="true">すべて</a>
                    </li>
                    <li class="news-archive__cat-item">
                        <a href="#news-archive" class="news-archive__cat-link js-news-archive-filter" data-news-filter="news">お知らせ</a>
                    </li>
                    <li class="news-archive__cat-item">
                        <a href="#news-archive" class="news-archive__cat-link js-news-archive-filter" data-news-filter="column">コラム</a>
                    </li>
                </ul>
            </aside>
        </div>
    </section>

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

    <section class="salons-sns" id="salons" aria-labelledby="salons-sns-heading">
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
