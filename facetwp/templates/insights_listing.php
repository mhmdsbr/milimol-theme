<div class="row exp-insights-listing__wrapper">
    <?php while (have_posts()): the_post(); ?>
        <?php
        $post_fields = get_fields($post->ID);
        $insightType = get_the_terms($post->ID, 'insight_type');
        ?>

        <article class="exp-insights_listing card card-exp-insights_listing col-12 col-lg-4">
            <a href="<?= get_permalink($post->ID) ?>" class="card__permalink"></a>
            <div class="exp-insights_listing-image-wrapper card__image-wrapper">
                <?php if (has_post_thumbnail()): ?>
                    <img class="exp-insights_listing-image card__image"
                         src="<?= get_the_post_thumbnail_url(); ?>"
                         srcset="<?= wp_get_attachment_image_srcset(get_post_thumbnail_id(), 'thumbnail'); ?>"
                         title="<?= get_the_title(); ?>"
                         alt="<?= get_the_title(); ?>"
                         loading="lazy"
                    />

                    <?php if (!empty($insightType)): ?>
                        <div class="exp-insights_listing-region card__meta">
                                <span class="exp-insights_listing-loop">
                                    <?php foreach ($insightType as $key => $region): ?>
                                        <span class="badge">
                                            <?= array_key_last($insightType) === $key ? $region->name . '' : $region->name . ','; ?>
                                        </span>
                                    <?php endforeach; ?>
                                </span>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="exp-insights_listing-content">
                <div class="card__service-type-wrapper">
                    <?php
                    if (isset($post_fields['p2p_service_insight']) && is_countable($post_fields['p2p_service_insight']) && count($post_fields['p2p_service_insight']) > 0) :
                        foreach ($post_fields['p2p_service_insight'] as $item) :
                            echo '<div class="card__service-type">' . $item->post_title . '</div>';
                        endforeach;
                    endif;

                    ?>

                </div>

                <?php
                if (!empty(get_the_title())):
                    echo sprintf(
                        '<h3 class="exp-insights_listing-title card__title">%s</h3>',
                        get_the_title()
                    );
                endif;
                ?>

                <?php if (isset($post_fields['p2p_certi_industry_program']) || !empty($insightType)): ?>
                    <div class="exp-insights_listing-meta">
                        <?php if (isset($post_fields['p2p_certi_industry_program'])): ?>
                            <div class="exp-insights_listing-category">
                                <?php foreach ($post_fields['p2p_certi_industry_program'] as $industry): ?>
                                    <?php $industry_fields = get_fields($industry->ID); ?>
                                    <span>
                                        <?php if (isset($industry_fields['icon'])): ?>
                                            <span
                                                class="<?= $industry_fields['icon'][0]['icons']; ?>"><?= $industry_fields['icon'][0]['icons']; ?></span>
                                        <?php endif; ?>
                                        <?= $industry->post_title; ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>
    <?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>
