import $ from 'jquery';
import 'slick-carousel';

// Movies slider
const sliders = [...document.querySelectorAll('.js-movie-slider')];
const filters = document.querySelectorAll('.js-movie-filter');
const containers = document.querySelectorAll('.js-movie-slider');

/**
 * Active filter
 *
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @return {bool}
 */
function activeFilter() {
	if (this.classList.contains('is-active')) {
		return false;
	}

	const schoolClasses = JSON.parse(this.dataset.schoolClass);
	let currentContainer = null;

	filters.forEach(e => {
		e.classList.remove('is-active');
	});
	this.classList.add('is-active');

	containers.forEach(e => {
		const categories = JSON.parse(e.dataset.schoolClass);
		e.classList.remove('is-active');

		schoolClasses.some(el => {
			currentContainer = e;
			$(currentContainer)
				.find('.js-movie-slider-container')
				.slick('refresh');
			return 0 <= categories.indexOf(el) ? currentContainer.classList.add('is-active') : '';
		});
	});

	return true;
}

sliders.forEach(slider => {
	const $slider = $(slider);

	$slider.find('.js-movie-slider-container').slick({
		slidesToScroll: 1,
		infinite: true,
		arrows: true,
		nextArrow: $slider.find('.js-movie-next'),
		prevArrow: $slider.find('.js-movie-previous'),
		mobileFirst: true,
		responsive: [
			{
				breakpoint: 991,
				settings: {
					centerMode: true,
					centerPadding: `${100 / 3}%`,
				},
			},
		],
	});
});

filters.forEach(filter => {
	filter.addEventListener('click', activeFilter);
});
