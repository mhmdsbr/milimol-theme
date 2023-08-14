<?php
$context = Timber::get_context();
$context['ajax_url'] = admin_url('admin-ajax.php');
$site = new TimberSite();
Timber::render( 'searchform.twig', $context );