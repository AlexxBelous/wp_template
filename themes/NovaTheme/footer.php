<footer id="footer" class="footer">
    <div class="container">
        <div class="footer__inner">
            <?php if ($logo = get_field('footer_logo', 'options')): ?>
                <div class="footer__logo">
                    <a class="footer__logo-link" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php echo wp_get_attachment_image(
                                $logo['ID'],
                                'full',
                                false,
                                ['class' => 'footer__logo-img']
                        ) ?>
                    </a>
                </div>
            <?php endif; ?>
            <div class="footer__social">
                <?php get_template_part('parts/socials'); ?>
            </div>
        </div>

        <div class="footer__copyright">
            <?php if ($copyright = get_field('copyright_text', 'options')) : ?>
                <?php echo $copyright; ?>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>