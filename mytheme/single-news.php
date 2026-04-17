<?php
/**
 * Single: news（投稿タイプスラッグ news 用）
 *
 * @package Valentine_Rose
 */

get_header();
?>

<main id="main" class="site-main site-main--single site-main--news">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article <?php post_class(); ?>>
            <header class="entry-header">
                <time class="entry-date" datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>"><?php echo esc_html(get_the_date()); ?></time>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
            <figure class="entry-thumbnail news__thumb">
                <img src="<?php echo esc_url(vr_get_thumbnail_url_or_placeholder()); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="1200" height="900" loading="eager" decoding="async">
            </figure>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
