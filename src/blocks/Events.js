/* global wp */

/**
 * Events
 *
 * @file blocks/Events.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class Events {
	constructor(element) {
		this.$element = document.querySelector(element);

		if (!this.$element || undefined === this.$element) return false;

		this.$cont = this.$element.querySelector('.js-events-container');
		this.buttonFilters = this.$element.querySelectorAll('.js-events-button');

		this.category = {
			button: null,
			id: 0,
		};

		return true;

		// this.count = parseInt(this.button.dataset.count, 0);
		// this.offset = 0;
	}

	init() {
		if (!this.$element || this.$element === undefined) return false;

		return this.setupEvents();
	}

	/**
	 * Events.setupEvents
	 */
	setupEvents() {
		this.$element.addEventListener(
			'click',
			event => {
				const { target } = event;

				if (target === this.category.button) {
					return false;
				}

				if (!target.classList.contains('js-events-button')) {
					return false;
				}

				// Remove all `is-active` classes
				for (let i = 0; i < this.buttonFilters.length; i += 1) {
					this.buttonFilters[i].classList.remove('is-active');
				}

				// Update count, offset
				// this.count = e.target.dataset.count;
				// this.offset = 0;

				// Stock current term_id
				this.category = {
					button: target,
					id: target.dataset.categoryId,
				};

				return this.filter();
			},
			{ passive: true },
		);
	}

	/**
	 * Events.filter
	 */
	filter() {
		// load more projects with AJAX
		this.load()
			.then(response => response.text())
			// then replace result to the container
			.then(this.replace.bind(this))
			// finally update things
			.finally(this.update.bind(this));
	}

	/**
	 * Events.load
	 */
	load() {
		let url = `${wp.ajax_url}?action=ajax_load_events&nonce=${wp.nonce}`;

		if (this.category) {
			url += `&category=${this.category.id}`;
		}

		const request = new Request(url);
		const init = {
			method: 'post',
		};

		// Lock everything before the request.
		this.lock('on');

		return fetch(request, init);
	}

	/**
	 * Events.replace
	 */
	replace(html) {
		if (!html) {
			return;
		}

		this.$cont.innerHTML = html;
	}

	/**
	 * Events.update
	 */
	update() {
		// this.offset = this.$cont.children.length;
		// ensure everything is unlocked
		this.lock('off');
	}

	/**
	 * Events.lock
	 */
	lock(method) {
		// console.log('Events.lock(on)');
		if ('on' === method) {
			if (this.category.button) {
				this.category.button.classList.add('is-active');
			}

			// add loading state to ajax container if exists
			if (this.$cont) {
				this.$cont.classList.add('is-loading');
			}
		}

		// console.log('Events.lock.off');
		if ('off' === method) {
			// remove loading state of ajax container if exists
			if (this.$cont) {
				this.$cont.classList.remove('is-loading');
			}
		}
	}
}
