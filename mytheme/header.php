<?php
/**
 * Header
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
    <div class="header__inner">
        <p class="header__name">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo-link">
                <img src="<?php echo esc_url(VR_THEME_URI . '/assets/images/common/logo.png'); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <span class="header__logo-text md-show"><?php echo esc_html(get_bloginfo('name')); ?></span>
            </a>
        </p>
        <nav class="header__nav md-show" aria-label="<?php esc_attr_e('グローバルナビ', 'valentine-rose'); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'header__items',
                    'fallback_cb'    => 'vr_nav_fallback',
                )
            );
            ?>
        </nav>
    </div>
</header>
