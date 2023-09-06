<?php
/**
 * Template Name: Sign Up
 */

$context = Timber::context();

$timber_post = new Timber\Post();
$context['post'] = $timber_post;
Timber::render(array('page-signup.twig'), $context);
