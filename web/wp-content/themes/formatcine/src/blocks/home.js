/* global $ */

// Home slider
$('.js-slider-home').slick({
	mobileFirst: true,
	responsive: [
		{
			breakpoint: 991,
			settings: {
				slidesToShow: 1,
				infinite: true,
				fade: true,
				arrows: false,
				autoplay: true,
			},
		},
		{
			breakpoint: 1,
			settings: 'unslick',
		},
	],
});
