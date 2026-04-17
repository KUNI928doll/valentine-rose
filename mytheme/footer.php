<?php
/**
 * Footer
 *
 * @package Valentine_Rose
 */

if (! defined('ABSPATH')) {
    exit;
}
?>

<footer class="footer">
    <div class="inner">
        <p class="footer__copy">&copy; <?php echo esc_html(gmdate('Y')); ?> <?php bloginfo('name'); ?></p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
