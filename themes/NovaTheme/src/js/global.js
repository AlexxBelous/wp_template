/*
|--------------------------------------------------------------------------
| DYNAMIC MODULES LOADING
|--------------------------------------------------------------------------
| This section handles lazy-loading for heavy JS components.
| Modules are only imported if their corresponding HTML element exists.
*/


const handleDynamicModules = async () => {

	// --- Swiper: Hero Slider ---
	// Loads the slider logic only on pages with the .js-hero-slider class
	if ( document.querySelector( '.js-hero-slider' ) ) {
		const { initHeroSlider } = await import( './modules/HeroSlider' );
		initHeroSlider();
	}
};

document.addEventListener( 'DOMContentLoaded', handleDynamicModules );