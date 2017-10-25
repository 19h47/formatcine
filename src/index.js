import './assets/stylesheets/styles.scss';
import App from './app/modules/app';
import Events from './app/modules/events';
import SchoolTraining from './app/modules/school-training';
import guid from './app/modules/guid';
import Menu from './app/modules/Menu';

window.app = new App();

Events('.js-events');
SchoolTraining('.js-school-trainings');
guid();

// Menu
const MainMenu = new Menu();
MainMenu.setupEvents();

// Movies slider
const sliders = document.querySelectorAll('.js-movie-slider');
console.log(sliders);
sliders.forEach((slider) => {
	const $slider = $(slider);

	$slider.find('.js-movie-slider-container').slick({
		slidesToScroll: 1,
		centerMode: true,
		centerPadding: `${100 / 3}%`,
		infinite: true,
		arrows: true,
		nextArrow: $slider.find('.js-movie-next'),
		prevArrow: $slider.find('.js-movie-previous'),
	});
});

const filters = document.querySelectorAll('.js-movie-filter');
const containers = document.querySelectorAll('.js-movie-slider');

filters.forEach((filter) => {
	filter.addEventListener('click', function () {
		if (this.classList.contains('is-active')) {
			return;
		}

		const schoolClasses = JSON.parse(this.dataset.schoolClass);
		let currentContainer = null;

		filters.forEach((e) => {
			e.classList.remove('is-active');
		});

		this.classList.add('is-active');

		containers.forEach((e) => {
			const categories = JSON.parse(e.dataset.schoolClass);
			e.classList.remove('is-active');

			schoolClasses.some((el) => {
				currentContainer = e;
				return categories.indexOf(el) >= 0 ? currentContainer.classList.add('is-active') : '';
			});
		});
	});
});

console.log('Yo!');
