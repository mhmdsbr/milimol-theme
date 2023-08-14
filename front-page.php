<?php
$context = Timber::context();
$timber_post = new Timber\Post();
$context['custom_fields'] = get_fields();
$context['post'] = $timber_post;
$context['is_front_page'] = 'true';

Timber::render(array('front-page.twig'), $context);
