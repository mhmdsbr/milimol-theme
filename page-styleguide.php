<?php
/**
 * Template Name: Styleguide
 */

$context = Timber::context();

$timber_post = new Timber\Post();
$context['post'] = $timber_post;
Timber::render(array('page-styleguide.twig'), $context);
