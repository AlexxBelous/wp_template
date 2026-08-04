<?php

/*
|--------------------------------------------------------------------------
| HERO BANNER RENDERER
|--------------------------------------------------------------------------
| Fetches 'main_banner' posts and renders either a static image or a slider.
| Requires: Slick Slider JS/CSS if more than one banner exists.
*/

function novatheme_render_hero_banner() {
    $args = [
        'post_type'      => 'main_banner',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ];

    $query = new WP_Query($args);

    if ( $query->have_posts() ) :
        $count = $query->post_count;
        $slider_class = ($count > 1) ? 'js-hero-slider' : 'is-static-banner';
        ?>

        <div class="hero-wrapper swiper <?php echo esc_attr($slider_class); ?>">
            <div class="swiper-wrapper">
                <?php while ( $query->have_posts() ) : $query->the_post();
                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    ?>

                    <div class="hero-item swiper-slide">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('full', ['class' => 'hero-item__image']); ?>
                        <?php endif; ?>

                        <div class="hero-content">
                            <?php  ?>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>

            <?php if ($count > 1) : ?>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            <?php endif; ?>
        </div>

        <?php
        wp_reset_postdata();
    endif;
}