<?php
/**
 * Front page (TOP)
 *
 * @package Valentine_Rose
 */

get_header();
?>

<main id="main" class="site-main site-main--front">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            ?>
            <article <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    endif;
    ?>
    <?php
    // または固定ページの本文ではなく、パーツ化する場合:
    // get_template_part('template-parts/front/hero');
    ?>
</main>

<?php
get_footer();
