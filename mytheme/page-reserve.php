<?php
/**
 * Template Name: Reserve
 *
 * @package Valentine_Rose
 */

get_header();
?>

<main id="main" class="site-main site-main--reserve">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
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
