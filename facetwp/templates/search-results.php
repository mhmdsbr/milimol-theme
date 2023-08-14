<div class="row exp-search-listing__wrapper">

    <?php while (have_posts()): the_post(); ?>
        <?php
        $postType    = get_post_type();
        $post_fields = get_fields($post->ID);
        ?>
        <div class="col-12">
            <div class="exp-search_listing pt-5 pb-5 border-bottom-1">
                <div class="exp-search_listing-content">
                    <?php if (!empty(get_the_title())):
                        echo sprintf(
                            '<h2 class="exp-search_listing-title">%s</h2>',
                            get_the_title()
                        );
                    endif; ?>

                    <?php if (!empty(get_the_excerpt())):
                        echo sprintf(
                            '<div class="exp-search_listing-text">%s</div>',
                            get_the_excerpt()
                        );
                    endif; ?>
                </div>
                <div class="exp-search_listing-meta">
                    <div class="exp-search_listing-meta">
                        <?php
                        if (($postType === 'service' || $postType === 'industry') && isset($post_fields['p2p_service_industry'])) : ?>
                            <ul class="exp-search_listing-connection">
                                <?php foreach ($post_fields['p2p_service_industry'] as $connection): ?>
                                    <?php $connection_fields = get_fields($connection->ID); ?>
                                    <li>
                                        <?php if (isset($connection_fields['icon'])): ?>
                                            <span
                                                class="<?= $connection_fields['icon'][0]['icons']; ?>"><?= trim(file_get_contents(get_theme_file_path('/svg/' . $connection_fields['icon'][0]['icons'] . '.svg'))); ?></span>
                                        <?php endif; ?>
                                        <?= $connection->post_title; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif;

                        if ($postType === 'training'  && isset($post_fields['p2p_service_academy'])) : ?>
                            <ul class="exp-search_listing-connection">
                                <?php foreach ($post_fields['p2p_service_academy'] as $connection): ?>
                                    <?php $connection_fields = get_fields($connection->ID); ?>
                                    <li>
                                        <?php if (isset($connection_fields['icon'])): ?>
                                            <span
                                                class="<?= $connection_fields['icon'][0]['icons']; ?>"><?= trim(file_get_contents(get_theme_file_path('/svg/' . $connection_fields['icon'][0]['icons'] . '.svg'))); ?></span>
                                        <?php endif; ?>
                                        <?= $connection->post_title; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif;

                        if ($postType === 'training'  && isset($post_fields['p2p_industry_academy'])) : ?>
                            <ul class="exp-search_listing-connection">
                                <?php foreach ($post_fields['p2p_industry_academy'] as $connection): ?>
                                    <?php $connection_fields = get_fields($connection->ID); ?>
                                    <li>
                                        <?php if (isset($connection_fields['icon'])): ?>
                                            <span
                                                class="<?= $connection_fields['icon'][0]['icons']; ?>"><?= trim(file_get_contents(get_theme_file_path('/svg/' . $connection_fields['icon'][0]['icons'] . '.svg'))); ?></span>
                                        <?php endif; ?>
                                        <?= $connection->post_title; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif;

                        if (($postType === 'certi_service' || $postType === 'certi_industry' || $postType === 'certi_program') && isset($post_fields['p2p_certi_service_industry'])) : ?>
                            <ul class="exp-search_listing-connection">
                                <?php foreach ($post_fields['p2p_certi_service_industry'] as $connection): ?>
                                    <?php $connection_fields = get_fields($connection->ID); ?>
                                    <li>
                                        <?php if (isset($connection_fields['icon'])): ?>
                                            <span
                                                class="<?= $connection_fields['icon'][0]['icons']; ?>"><?= trim(file_get_contents(get_theme_file_path('/svg/' . $connection_fields['icon'][0]['icons'] . '.svg'))); ?></span>
                                        <?php endif; ?>
                                        <?= $connection->post_title; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif;

                        // Posttype singular name
                        if (!empty($postType)) :
                            echo sprintf(
                            '<div class="exp-search_listing-type">%s</div>',
                                get_post_type_labels(get_post_type_object($postType))->singular_name
                            );
                        endif;

                        // Insight type
                        if ($postType === 'insight') :
                            echo sprintf(
                                '<div class="exp-search_listing-pubdate">%s</div>',
                                get_the_terms( $post->ID, 'insight_type' )[0]->name
                            );
                        endif;

                        // Publish date
                        if ($postType === 'insight' || $postType === 'people_story' || $postType === 'press_release' || $postType === 'training') :
                            echo sprintf(
                                '<div class="exp-search_listing-pubdate">%s</div>',
                                get_the_date( 'd F Y', $post->ID)
                            );
                        endif;
                        ?>
                    </div>

                    <a href="<?php get_permalink($post->ID); ?>" class="btn btn--outline" title="<?= get_the_title(); ?>"><?= __('Read more' , 'expedtion'); ?></a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>
