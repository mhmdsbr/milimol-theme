<?php
/**
 * Template Name: Account
 */

$context = Timber::context();

$timber_post = new Timber\Post();
$context['post'] = $timber_post;
Timber::render(array('page-account.twig'), $context);
