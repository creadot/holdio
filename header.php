<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
 	<meta name="viewport" content="initial-scale = 1.0, user-scalable = yes, width = device-width"> 

	<title><?php echo wp_title(); ?></title>
	<link rel="preconnect" href="<?php echo get_site_url(); ?>" />
    <link rel="dns-prefetch" href="<?php echo get_site_url(); ?>" />

    <!--
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
	 -->
	<link rel="stylesheet" href="https://use.typekit.net/ghw8jpb.css">
	<script src="https://kit.fontawesome.com/91dbdb6e96.js" crossorigin="anonymous"></script>

    <!-- Favicons -->
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/favicon.svg" />
	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="Holdio" />
	<link rel="manifest" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/site.webmanifest" />

    <!-- CSS -->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/theme.css?v2-9-2025">

    <!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-WXZ8PDQ5');</script>
	<!-- End Google Tag Manager -->

	<?php wp_head(); ?>
</head>

<?php global $post; ?>

<body <?php body_class(); ?>>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WXZ8PDQ5"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div class="loading"></div>

	<header class="header">
		<div class="container">
			<a href="<?php echo get_site_url(); ?>" class="header-logo">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo.svg" alt="<?php echo get_bloginfo( 'name' ); ?>">
			</a>
			<nav class="main-menu">
				<ul>
					<?php
						wp_nav_menu( [
							"theme_location" => "primary",
							"container" => "",
							"items_wrap" => '%3$s'
						] );
					?>
				</ul>
			</nav>
			<span class="menu-button">
				<span></span>
				<span></span>
				<span></span>
			</span>
		</div>
	</header>

    <main class="main">