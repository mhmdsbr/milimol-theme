<?php
/**
 * Template Name: Message
 */

$context = Timber::context();

$timber_post = new Timber\Post();
$context['post'] = $timber_post;
Timber::render(array('page-message.twig'), $context);
