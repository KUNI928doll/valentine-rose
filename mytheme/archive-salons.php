<?php
/**
 * Archive: salons
 *
 * @package Valentine_Rose
 */

get_header();
?>

<main id="main" class="site-main site-main--archive site-main--salons">
    <header class="archive-header">
        <h1 class="archive-title"><?php post_type_archive_title(); ?></h1>
    </header>

    <?php if (have_posts()) : ?>
        <ul class="archive-list">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
                <?php
            endwhile;
            ?>
        </ul>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e('サロン情報はまだありません。', 'valentine-rose'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
