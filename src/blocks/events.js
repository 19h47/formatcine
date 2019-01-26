/**
 * Events
 *
 * @file blocks/Events.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class Events {
	constructor(element) {
		this.element = document.querySelector(element);

		if (!this.element || this.element === undefined) return false;

		this.$cont = this.element.querySelector('.js-events-container');
		this.buttonFilters = this.element.querySelectorAll('.js-events-button');

		this.category = {};
		this.category.id = 0;

		// this.count = parseInt(this.button.dataset.count, 0);
		// this.offset = 0;
	}

	/**
	 * Events.setupEvents
	 */
	setupEvents() {
		this.element.addEventListener('click', (e) => {
			if (e.target === this.category.button) {
				return false;
			}

			if (!e.target.classList.contains('js-events-button')) {
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
				button: e.target,
				id: e.target.dataset.categoryId,
			};

			return this.filter();
		});
	}


	/**
	 * Events.loadMore
	 */
	loadMore() {
		// load more projects with AJAX
		this.load()
			// then append result to the container
			.then(this.append.bind(this))
			// finally update things
			.done(this.update.bind(this));
	}


	/**
	 * Events.filter
	 */
	filter() {
		// load more projects with AJAX
		this.load()
			// then append result to the container
			.then(this.replace.bind(this))
			// finally update things
			.done(this.update.bind(this));
	}


	/**
	 * Events.load
	 */
	load() {
		const data = {
			action: 'ajax_load_events',
			// offset: this.offset,
		};

		if (this.category) {
			data.category = this.category.id;
		}

		// lock everything before the request
		this.lock('on');

		return $.get(window.wp.ajax_url, data);
	}


	/**
	 * Events.append
	 */
	replace(html) {
		if (!html) {
			return;
		}

		this.$cont.innerHTML = html;
	}


	/**
	 * Events.append
	 */
	append(html) {
		if (!html) {
			return;
		}

		$(this.$cont).append(html);
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
		if (method === 'on') {
			if (this.category.button) {
				this.category.button.classList.add('is-active');
			}

			// add loading state to ajax container if exists
			if (this.$cont) {
				this.$cont.classList.add('is-loading');
			}
		}

		// console.log('Events.lock.off');
		if (method === 'off') {
			// remove loading state of ajax container if exists
			if (this.$cont) {
				this.$cont.classList.remove('is-loading');
			}
		}
	}
}
