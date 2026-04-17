<?php
/**
 * Archive: news（投稿タイプスラッグ news 用）
 *
 * 別スラッグにした場合はファイル名を archive-{post_type}.php に合わせてください。
 *
 * @package Valentine_Rose
 */

get_header();
?>

<main id="main" class="site-main site-main--archive site-main--news">
    <header class="archive-header">
        <h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
    </header>

    <?php if (have_posts()) : ?>
        <ul class="news__list archive-list">
            <?php
            while (have_posts()) :
                the_post();
                $thumb_url = vr_get_thumbnail_url_or_placeholder();
                ?>
                <li class="news__item">
                    <a href="<?php the_permalink(); ?>" class="news__link">
                        <figure class="news__thumb">
                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="400" height="300" loading="lazy" decoding="async">
                        </figure>
                        <time class="news__date" datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>"><?php echo esc_html(get_the_date()); ?></time>
                        <p class="news__text"><?php the_title(); ?></p>
                    </a>
                </li>
                <?php
            endwhile;
            ?>
        </ul>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('お知らせはまだありません。', 'valentine-rose'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
