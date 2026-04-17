<?php
/**
 * Main template (fallback)
 *
 * @package Valentine_Rose
 */

get_header();
?>

<main id="main" class="site-main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <article <?php post_class(); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('投稿が見つかりませんでした。', 'valentine-rose'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
