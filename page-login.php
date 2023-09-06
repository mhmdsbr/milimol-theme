<?php
/**
 * Template Name: Login
 */

$context = Timber::context();

$timber_post = new Timber\Post();
$context['post'] = $timber_post;
Timber::render(array('page-login.twig'), $context);
