<?php
/**
 * Footer
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}

$vr_img = VR_THEME_URI . '/assets/images';
?>

<footer class="footer">
    <div class="footer__inner">
        <div class="footer__logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo-link">
                <img src="<?php echo esc_url($vr_img . '/common/logo.png'); ?>" alt="VALENTINE ROSE" width="64" height="64" loading="lazy">
                <span class="footer__logo-text">VALENTINE <br>ROSE</span>
            </a>
        </div>
        <nav class="footer__nav" aria-label="フッターナビゲーション">
            <div class="footer__nav-main">
                <ul class="footer__nav-items footer__nav-items--row1">
                    <li class="footer__nav-item"><a href="<?php echo esc_url(vr_url('home')); ?>" class="footer__nav-link"<?php echo vr_aria_current('home'); ?>>TOP</a></li>
                    <li class="footer__nav-item"><a href="<?php echo esc_url(vr_url('concept')); ?>" class="footer__nav-link"<?php echo vr_aria_current('concept'); ?>>Concept</a></li>
                    <li class="footer__nav-item"><a href="<?php echo esc_url(vr_url('price')); ?>" class="footer__nav-link"<?php echo vr_aria_current('price'); ?>>Price</a></li>
                    <li class="footer__nav-break" aria-hidden="true"></li>
                    <li class="footer__nav-item"><a href="<?php echo esc_url(vr_url('news')); ?>" class="footer__nav-link"<?php echo vr_aria_current('news'); ?>>News</a></li>
                    <li class="footer__nav-item"><a href="<?php echo esc_url(vr_url('reserve')); ?>" class="footer__nav-link"<?php echo vr_aria_current('reserve'); ?>>Reserve</a></li>
                </ul>
            </div>
            <ul class="footer__nav-items footer__nav-items--sub">
                <li class="footer__nav-item"><a href="#" class="footer__nav-link">Privacy Policy</a></li>
                <li class="footer__nav-item"><a href="#" class="footer__nav-link">Site Map</a></li>
            </ul>
        </nav>
        <p class="footer__copyright">&copy; 2024 Valentine Rose., Ltd. All rights Reserved.</p>
    </div>
</footer>

<button class="pagetop js-pagetop" type="button" aria-label="ページトップへ戻る">
    <i class="fas fa-chevron-up" aria-hidden="true"></i>
</button>

<?php wp_footer(); ?>
</body>
</html>
