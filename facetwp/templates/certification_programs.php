<div class="exp-program-overview__wrapper">
    <?php while (have_posts()): the_post(); ?>
        <?php
            $post_fields = get_fields($post->ID);
            $regions = get_the_terms($post->ID, 'region');
        ?>
        <div class="exp-program-overview__item">
            <div class="exp-program-overview__item-image-wrapper">
                <?php if (has_post_thumbnail()): ?>
                    <img class="exp-program-overview__item-image"
                        src="<?= get_the_post_thumbnail_url(); ?>"
                        srcset="<?= wp_get_attachment_image_srcset( get_post_thumbnail_id(), 'thumbnail' ); ?>"
                        title="<?= get_the_title(); ?>"
                        alt="<?= get_the_title(); ?>"
                        loading="lazy"
                    />
                <?php endif;?>
            </div>

            <div class="exp-program-overview__item-content">
                <?php
                if (!empty(get_the_title())):
                    echo sprintf(
                        '<h2 class="exp-program-overview__item-title">%s</h2>',
                        get_the_title()
                    );
                endif;
                ?>

                <?php
                if (!empty(get_the_excerpt())):
                    echo sprintf(
                        '<div class="exp-program-overview__item-text">%s</div>',
                        get_the_excerpt()
                    );
                endif;
                ?>

                <?php if (isset($post_fields['p2p_certi_industry_program']) || !empty($regions)): ?>
                    <div class="exp-program-overview__item-meta">
                        <?php if (isset($post_fields['p2p_certi_industry_program'])): ?>
                            <div class="exp-program-overview__item-category">
                                <?php foreach ($post_fields['p2p_certi_industry_program'] as $industry): ?>
                                    <?php $industry_fields = get_fields($industry->ID); ?>
                                    <span>
                                        <?php if (isset($industry_fields['icon'])): ?>
                                            <span class="<?= $industry_fields['icon'][0]['icons']; ?>"><?= $industry_fields['icon'][0]['icons']; ?></span>
                                        <?php endif;?>
                                        <?= $industry->post_title; ?>
                                    </span>
                                <?php endforeach;?>
                            </div>
                        <?php endif;?>

                        <?php if (!empty($regions)): ?>
                            <div class="exp-program-overview__item-region">
                                <span class="exp-program-overview__item-icon">
                                    <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 9.625C8.38071 9.625 9.5 8.50571 9.5 7.125C9.5 5.74429 8.38071 4.625 7 4.625C5.61929 4.625 4.5 5.74429 4.5 7.125C4.5 8.50571 5.61929 9.625 7 9.625Z" stroke="#728182" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.25 7.125C13.25 12.75 7 17.125 7 17.125C7 17.125 0.75 12.75 0.75 7.125C0.75 5.4674 1.40848 3.87768 2.58058 2.70558C3.75268 1.53348 5.3424 0.875 7 0.875C8.6576 0.875 10.2473 1.53348 11.4194 2.70558C12.5915 3.87768 13.25 5.4674 13.25 7.125V7.125Z" stroke="#728182" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                                <span class="exp-program-overview__item-loop">
                                    <?php foreach($regions as $key => $region): ?>
                                        <span>
                                            <?= array_key_last($regions) === $key ? $region->name . '' : $region->name . ','; ?>
                                        </span>
                                    <?php endforeach; ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>
