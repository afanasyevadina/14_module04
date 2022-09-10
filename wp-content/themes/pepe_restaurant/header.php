<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width"/>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="wrapper" class="hfeed">
    <nav>
        <a href="<?= site_url() ?>">
            <img src="<?= get_stylesheet_directory_uri() ?>/logo.png" alt="" class="logo">
        </a>
        <a href="#reservation">RESERVATION</a>
    </nav>
    <header style="background-image: url('<?= get_the_post_thumbnail_url() ?>')">
        <h1>
            <?php foreach (explode(' ',  get_option('blogname') ) as $item) : ?>
            <span><?= $item ?></span>
            <?php endforeach; ?>
        </h1>
    </header>
    <div id="container" class="container">