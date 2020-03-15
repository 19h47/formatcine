import config from './config';


/**
 * App
 */
class App {
	constructor() {
		console.log('%c🔥 Moka Création x 19h47 🔥', 'background-color:#000;color:#fff;padding:0.5em 1em;');
	}

	/**
	 * App.disableScroll
	 */
	static disableScroll() {
		const documentElementScrollLeft = document.documentElement.scrollLeft;
		const documentElementScrollTop = document.documentElement.scrollTop;
		// eslint-disable-next-line
		const pageXOffset = self.pageXOffset;
		// eslint-disable-next-line
		const pageYOffset = self.pageYOffset;
		const bodyScrollLeft = document.body.scrollLeft;
		const bodyScrollTop = document.body.scrollTop;

		// lock scroll position, but retain settings for later
		// http://stackoverflow.com/a/3656618
		config.body.scroll.left = pageXOffset || documentElementScrollLeft || bodyScrollLeft;

		config.body.scroll.top = pageYOffset || documentElementScrollTop || bodyScrollTop;

		config.html.style.setProperty('overflow', 'hidden');

		App.resetScroll(config.body.scroll.left, config.body.scroll.top);
	}


	/**
	 * App.enableScroll
	 *
	 * @param  position
	 */
	static enableScroll(position) {
		// console.log('App.enableScroll');
		let resumeScroll = true;
		let currentPosition = position;

		if ('undefined' === typeof currentPosition) {
			currentPosition = config.body.scroll.top;
		}

		if ('boolean' === typeof currentPosition && false === currentPosition) {
			resumeScroll = false;
		}

		// unlock scroll position
		// http://stackoverflow.com/a/3656618
		config.html.style.setProperty('overflow', 'visible');

		// resume scroll position if possible
		if (resumeScroll) {
			App.resetScroll(config.body.scroll.left, currentPosition);
		}
	}


	/**
	 * App.resetScroll
	 *
	 * @param  positionX
	 * @param  positionY
	 */
	static resetScroll(positionX, positionY) {
		if ('undefined' !== typeof positionX) {
			config.body.scroll.left = parseInt(positionX, 10);
		}

		if ('undefined' !== typeof positionY) {
			config.body.scroll.top = parseInt(positionY, 10);
		}

		window.scrollTo(config.body.scroll.left, config.body.scroll.top);
	}
}

export default App;
