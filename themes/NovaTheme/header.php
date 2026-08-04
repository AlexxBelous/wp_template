<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<link rel="icon" href="data:;base64,iVBORw0KGgo=">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
		<?php wp_body_open(); ?>

	<header class="header">
		<div class="container">
			<div class="header__wrapper">
				<div class="header__logo">
					<?php the_custom_logo(); ?>
				</div>
	
					<nav id="site-navigation" class="header__menu">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'main-menu',
						'menu_id' => 'primary-menu',
						'menu_class' => 'header__menu-list',
						'container' => false,
					) );
					?>
					</nav>
			</div>
		</div>
	</header>