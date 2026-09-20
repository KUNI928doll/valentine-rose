<?php
/**
 * Header
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

$vr_img = VR_THEME_URI . '/assets/images';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Parisienne&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="<?php echo esc_url($vr_img . '/common/favicon.ico'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url($vr_img . '/common/apple-touch-icon.png'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
    <div class="header__inner">
        <?php
        // TOP のみ h1、下層は p（静的版と同じ使い分け）
        $vr_logo_tag = is_front_page() ? 'h1' : 'p';
        ?>
        <<?php echo $vr_logo_tag; ?> class="header__name">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo-link">
                <img src="<?php echo esc_url($vr_img . '/common/logo.png'); ?>" alt="ヘッダーロゴ">
                <span class="header__logo-text md-show">VALENTINE <br>ROSE</span>
            </a>
        </<?php echo $vr_logo_tag; ?>>
        <nav class="header__nav md-show" aria-label="グローバルナビ">
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
        <button class="hamburger js-hamburger u-md-none" type="button" aria-label="メニュー" aria-expanded="false">
            <span class="hamburger__text">メニュー</span>
            <span class="hamburger__lines" aria-hidden="true">
                <span class="hamburger__line"></span>
                <span class="hamburger__line"></span>
                <span class="hamburger__line"></span>
            </span>
        </button>
    </div>
</header>

<div class="drawer js-drawer">
    <button class="drawer__close js-drawer-close" type="button" aria-label="閉じる">
        <span class="drawer__close-line"></span>
        <span class="drawer__close-line"></span>
    </button>
    <div class="drawer-menu__inner">
        <ul class="drawer-menu__items">
            <li class="drawer-menu__item">
                <a href="<?php echo esc_url(vr_url('home')); ?>" class="drawer-menu__link"<?php echo vr_aria_current('home'); ?>>HOME</a>
            </li>
            <li class="drawer-menu__item">
                <a href="<?php echo esc_url(vr_url('concept')); ?>" class="drawer-menu__link"<?php echo vr_aria_current('concept'); ?>>SALON CONCEPT</a>
            </li>
            <li class="drawer-menu__item">
                <a href="<?php echo esc_url(vr_url('price')); ?>" class="drawer-menu__link"<?php echo vr_aria_current('price'); ?>>PRICE MENU</a>
            </li>
            <li class="drawer-menu__item">
                <a href="<?php echo esc_url(vr_url('salons')); ?>" class="drawer-menu__link"<?php echo vr_aria_current('salons'); ?>>SALONS</a>
            </li>
            <li class="drawer-menu__item">
                <a href="<?php echo esc_url(vr_url('news')); ?>" class="drawer-menu__link"<?php echo vr_aria_current('news'); ?>>NEWS</a>
            </li>
            <li class="drawer-menu__item">
                <a href="<?php echo esc_url(vr_url('reserve')); ?>" class="drawer-menu__link"<?php echo vr_aria_current('reserve'); ?>>RESERVE</a>
            </li>
        </ul>
    </div>
</div>
