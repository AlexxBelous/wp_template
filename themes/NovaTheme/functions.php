<?php

/*
|--------------------------------------------------------------------------
| DATABASE REPOSITORY START
|--------------------------------------------------------------------------
| This section describes the core logic for working with entities
*/
define( 'IS_VITE_DEVELOPMENT', true );
/*----------------------- END OF DATABASE REPOSITORY --------------------*/


/*
|--------------------------------------------------------------------------
| DATABASE REPOSITORY START
|--------------------------------------------------------------------------
| Get the theme version from style.css to use it for cache busting
*/
$theme = wp_get_theme();
define( 'THEME_VERSION', $theme->get( 'Version' ) );
/*----------------------- END OF DATABASE REPOSITORY --------------------*/


/*
|--------------------------------------------------------------------------
| VITE HMR PREAMBLE START
|--------------------------------------------------------------------------
| Output React preamble for Vite HMR (Fast Refresh) to work.
| Uncomment the add_action below when you start working with React.
*/
function novatheme_vite_head_preamble() {
	if ( IS_VITE_DEVELOPMENT ) {
		?>
		<script type="module">
			import RefreshRuntime from 'http://localhost:3000/@react-refresh'

			RefreshRuntime.injectIntoGlobalHook(window)
			window.$RefreshReg$ = () => {
			}
			window.$RefreshSig$ = () => (type) => type
			window.__vite_plugin_react_preamble_installed__ = true
		</script>
		<?php
	}
}

// add_action('wp_head', 'novatheme_vite_head_preamble');
/*----------------------- END OF VITE HMR PREAMBLE -----------------------*/








/*
|--------------------------------------------------------------------------
| ASSETS ENQUEUING (VITE INTEGRATION)
|--------------------------------------------------------------------------
| Handles enqueueing JS and CSS for both Vite Dev mode and Production build.
*/

function novatheme_enqueue_scripts() {

	if ( IS_VITE_DEVELOPMENT ) {

		/* --- DEVELOPMENT MODE (Vite HMR) --- */
		wp_enqueue_script( 'vite-client', 'http://localhost:3000/@vite/client', [], null, true );
		wp_enqueue_script( 'novatheme-main-js', 'http://localhost:3000/src/js/main.jsx', [], null, true );

	} else {

		/* --- PRODUCTION MODE (Bundled Manifest) --- */
		$manifest_path = get_theme_file_path( 'assets/.vite/manifest.json' );

		if ( file_exists( $manifest_path ) ) {
			$manifest = json_decode( file_get_contents( $manifest_path ), true );

			if ( isset( $manifest['src/js/main.jsx'] ) ) {
				$main_js = $manifest['src/js/main.jsx'];

				// Enqueue compiled JavaScript
				wp_enqueue_script( 'novatheme-main-js', get_theme_file_uri( 'assets/' . $main_js['file'] ), [], THEME_VERSION, true );

				// Enqueue compiled CSS
				if ( ! empty( $main_js['css'] ) ) {
					foreach ( $main_js['css'] as $css_file ) {
						wp_enqueue_style( 'novatheme-main-style', get_theme_file_uri( 'assets/' . $css_file ), [], THEME_VERSION );
					}
				}
			}
		}
	}

	/* --- LOCALIZE SCRIPT (CONFIG FOR JS & AJAX) --- */
	if ( wp_script_is( 'novatheme-main-js', 'enqueued' ) || wp_script_is( 'novatheme-main-js', 'registered' ) ) {
		wp_localize_script( 'novatheme-main-js', 'appConfig', [
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'app_nonce' ),
		] );
	}
}
add_action( 'wp_enqueue_scripts', 'novatheme_enqueue_scripts' );


/**
 * Add type="module" to ES module scripts (Vite Client & Main JS)
 */
function novatheme_add_module_to_script( $tag, $handle ) {
	if ( in_array( $handle, [ 'vite-client', 'novatheme-main-js' ], true ) ) {
		return str_replace( '<script ', '<script type="module" ', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'novatheme_add_module_to_script', 10, 2 );










/*
|--------------------------------------------------------------------------
| MENUS REGISTRATION
|--------------------------------------------------------------------------
| Function to register navigation menu locations for NovaTheme.
| This allows assigning menus via the WordPress admin panel.
*/
function novaTheme_register_menus() {
	register_nav_menus( array(
		'main-menu' => 'Main Menu',
		'footer-menu' => 'Footer Menu'
	) );
}

add_action( 'after_setup_theme', 'novaTheme_register_menus' );
/*----------------------- END MENUS REGISTRATION -----------------------*/


/*
|--------------------------------------------------------------------------
| THEME SUPPORT: CUSTOM LOGO
|--------------------------------------------------------------------------
| Enables support for a custom logo in NovaTheme.
| Allows uploading and managing the site logo via the WordPress customizer.
*/
function novaTheme_setup() {
	add_theme_support( 'custom-logo', array(
		//          'height'      => 100,
//          'width'       => 300,
		'flex-height' => true,
		'flex-width' => true,
	) );
}

add_action( 'after_setup_theme', 'novaTheme_setup' );
/*----------------------- END THEME SUPPORT: CUSTOM LOGO -----------------------*/









/*
|--------------------------------------------------------------------------
| BEM CLASSES FOR MAIN NAVIGATION MENU
|--------------------------------------------------------------------------
| Adds full BEM-style classes to the main navigation menu:
|  - <ul> uses 'header__menu-list' (set via 'menu_class' in wp_nav_menu)
|  - <li> items get 'header__menu-item'
|  - <a> links get 'header__menu-link'
|  - Active <li> items get 'header__menu-item--active'
| This ensures clean and consistent BEM markup for styling.
*/
function novaTheme_bem_menu_classes( $classes, $item, $args ) {
	// Only modify the main-menu
	if ( $args->theme_location === 'main-menu' ) {
		// Add class to <li>
		$classes[] = 'header__menu-item';

		// Add active modifier if current menu item
		if ( in_array( 'current-menu-item', $classes ) ) {
			$classes[] = 'header__menu-item--active';
		}
	}
	return $classes;
}

add_filter( 'nav_menu_css_class', 'novaTheme_bem_menu_classes', 10, 3 );
/*-------------- END BEM CLASSES FOR MAIN NAVIGATION MENU ----------*/








/*
|--------------------------------------------------------------------------
| BEM CLASS FOR MENU LINKS <a>
|--------------------------------------------------------------------------
| Adds 'header__menu-link' class to <a> elements in the main navigation.
*/
function novaTheme_bem_menu_link_class( $atts, $item, $args ) {
	if ( $args->theme_location === 'main-menu' ) {
		$atts['class'] = 'header__menu-link';
	}
	return $atts;
}

add_filter( 'nav_menu_link_attributes', 'novaTheme_bem_menu_link_class', 10, 3 );
/*----------------------- END BEM MENU CLASSES -----------------------*/





/*
|--------------------------------------------------------------------------
| CUSTOM POST TYPES REGISTRATION
|--------------------------------------------------------------------------
| Includes the file that registers all custom post types for this theme.
| For example: Main Banners, Portfolio, Services, etc.
| Keeping this separate ensures a cleaner functions.php file.
*/
require_once get_parent_theme_file_path( '/inc/cpt.php' );

/*----------------------- END CPT REGISTRATION -----------------------*/





/*
|--------------------------------------------------------------------------
| THEME COMPONENTS & RENDERERS
|--------------------------------------------------------------------------
| Includes helper functions for rendering various theme components.
| 'main-banner.php' handles the logic and HTML output for the Hero section.
| This keeps template files clean and focuses on logic reuse.
*/
require_once get_parent_theme_file_path( '/inc/main-banner.php' );

/*----------------------- END THEME COMPONENTS -----------------------*/





/*
|--------------------------------------------------------------------------
| ENABLE FEATURED IMAGES
|--------------------------------------------------------------------------
| Adds support for post thumbnails (featured images) across the site.
| This is required for the 'thumbnail' support in custom post types.
| Essential for displaying banner images and post previews.
*/
add_theme_support( 'post-thumbnails' );
/*----------------------- END THEME SUPPORTS -----------------------*/





/*
|--------------------------------------------------------------------------
| ALLOW SVG UPLOADS
|--------------------------------------------------------------------------
| Extends the list of allowed mime types to include SVG files.
| By default, WordPress restricts SVG uploads for security reasons.
| This function enables vector graphics support in the Media Library.
*/
function add_file_types_to_uploads( $file_types ) {
	$new_filetypes = [ 'svg' => 'image/svg+xml' ];
	$file_types = array_merge( $file_types, $new_filetypes );
	return $file_types;
}
add_filter( 'upload_mimes', 'add_file_types_to_uploads' );
/*----------------------- END MIME TYPE SUPPORTS -----------------------*/






/*
|--------------------------------------------------------------------------
| ACF THEME OPTIONS PAGE
|--------------------------------------------------------------------------
| Registers a global Options Page in the WordPress dashboard using ACF.
| Data saved here can be accessed anywhere on the site using get_field('field', 'option').
*/
function novatheme_register_acf_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'page_title' => 'Theme General Settings',
			'menu_title' => 'Theme Options',
			'menu_slug' => 'theme-general-settings',
			'capability' => 'edit_posts',
			'redirect' => false
		) );
	}
}
add_action( 'init', 'novatheme_register_acf_options_page' );
/*----------------------- END OF ACF THEME OPTIONS PAGE -----------------*/






/*
|--------------------------------------------------------------------------
| ACF LOCAL JSON INFRASTRUCTURE
|--------------------------------------------------------------------------
| Configures ACF to automatically save and load field groups from the
| /acf-json folder inside the NovaTheme directory.
*/

// 1. Set the save point for ACF JSON
function novatheme_acf_json_save_point( $path ) {
	return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'novatheme_acf_json_save_point' );

// 2. Set the load point for ACF JSON
function novatheme_acf_json_load_point( $paths ) {
	// Remove the default path
	unset( $paths[0] );

	// Append our custom theme path
	$paths[] = get_stylesheet_directory() . '/acf-json';

	return $paths;
}
add_filter( 'acf/settings/load_json', 'novatheme_acf_json_load_point' );
/*----------------------- END OF ACF LOCAL JSON -------------------------*/







function dump( $data ) {
	echo '<pre style="background-color: black; color: greenyellow; padding: 20px">';
	print_r( $data );
	echo '</pre>';
}