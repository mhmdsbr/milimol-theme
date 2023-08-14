<div class="row exp-academy-listing_wrapper">
    <?php while (have_posts()): the_post(); ?>
        <?php
        $post_fields = get_fields($post->ID);
        ?>
        <div class="exp-academy-listing col-12">
            <article class="card-exp-academy-listing">
                <div class="exp-academy__listing-image-wrapper card__image-wrapper d-none d-md-block">
                    <?php if (has_post_thumbnail()): ?>
                        <img class="exp-academy-listing-image card__image"
                             src="<?= get_the_post_thumbnail_url(); ?>"
                             srcset="<?= wp_get_attachment_image_srcset(get_post_thumbnail_id(), 'thumbnail'); ?>"
                             title="<?= get_the_title(); ?>"
                             alt="<?= get_the_title(); ?>"
                             loading="lazy"
                             width="200px"
                        />
                    <?php endif; ?>
                </div>
                <div class="exp-academy-listing-content card__content">
                    <?php if (isset($post_fields['p2p_industry_academy'])) : ?>
                        <div class="exp-academy-listing-meta">
                            <div class="exp-academy-listing-industry card__industry-type">
                                <?php foreach ($post_fields['p2p_industry_academy'] as $industry): ?>
                                    <?php $industry_fields = get_fields($industry->ID); ?>
                                    <span class="card__industry-type-item"><?= $industry->post_title; ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php
                    if (!empty(get_the_title())):
                        echo sprintf(
                            '<h2 class="exp-academy-listing-title card__title">%s</h2>',
                            get_the_title()
                        );
                    endif;
                    ?>

                    <?php
                    if (!empty(get_the_excerpt())):
                        echo sprintf(
                            '<div class="exp-academy-listing-text card__text">%s</div>',
                            get_the_excerpt()
                        );
                    endif;
                    ?>

                    <div class="exp-academy-listing-meta card__meta-list">
                    
                        <div class="card__meta-list-wrapper">
                            <?php if (isset($post_fields['training_meta_date'])) : ?>
                                <time class="training-date position-relative"><?= $post_fields['training_meta_date']; ?></time>
                            <?php endif; ?>
                            <?php if (isset($post_fields['training_meta_time'])) : ?>
                                <time class="training-time position-relative" datetime="<?= $post_fields['training_meta_time']; ?>"><?= $post_fields['training_meta_time']; ?></time>
                            <?php endif; ?>
                            <?php if (isset($post_fields['training_meta_language'])) : ?>
                                <span class="training-language position-relative"><?= $post_fields['training_meta_language']; ?></span>
                            <?php endif; ?>
                        </div>
                    
                        <?php if (isset($post_fields['link']) && is_array($post_fields['link'])) : ?>
                            <div class="exp-academy-listing__cta card__cta">
                                <a 
                                    href="<?= $post_fields['link']['url']; ?>"
                                    class="btn btn--red" 
                                    title="button" 
                                    target="_blank"
                                >
                                    <span class="btn--text d-none d-md-block"><?= __('More info', 'expedition'); ?></span>
                                    <span class="btn__svg"><svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 7H0" stroke-width="1.5"></path>
                                        <path d="M10 13L14.5858 8.41421C15.3668 7.63317 15.3668 6.36683 14.5858 5.58579L10 1" stroke-width="1.5"></path>
                                        </svg>
                                    </span>
                        
                                </a>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        </div>
    <?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>
