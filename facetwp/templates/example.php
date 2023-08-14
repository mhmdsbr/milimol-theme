<div class="row">
    <?php

    while ( have_posts() ): the_post(); ?>

        <!-- HTML LOOP ITEM HERE -->

    <?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>
