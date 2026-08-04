<?php

if (have_rows('social_media', 'options')) : ?>
    <ul class="social-networks">
        <?php while (have_rows('social_media', 'options')) : the_row();
            $icon = get_sub_field('social_icon');
            $url  = get_sub_field('social_url');
        ?>
            <?php if ($url && $icon) : ?>
                <li class="social-networks__item">
                    <a class="social-networks__link" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
                        <i class="<?php echo esc_attr($icon); ?> social-networks__icon" aria-hidden="true"></i>
                    </a>
                </li>
            <?php endif; ?>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>
