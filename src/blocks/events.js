const classes = require('dom-classes');


/**
 * Events
 */
export default function Events(element) {
	if (!(this instanceof Events)) {
		return new Events(element);
	}

	this.element = document.querySelector(element);

	if (!this.element || this.element === undefined) return false;

	this.$cont = this.element.querySelector('.js-events-container');
	this.buttonFilters = this.element.querySelectorAll('.js-events-button');

	this.category = {};
	this.category.id = 0;

	// this.count = parseInt(this.button.dataset.count, 0);
	// this.offset = 0;

	this.setupEvents.call(this);
}


Events.prototype = {

	/**
	 * Events.setupEvents
	 */
	setupEvents() {
		this.element.addEventListener('click', (e) => {
			if (e.target === this.category.button) {
				return;
			}

			// If element hasn't 'js-events-button' class
			if (!classes.has(e.target, 'js-events-button')) {
				return;
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

			this.filter();
		});
	},


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
	},


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
	},


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
		this.lock.on.call(this);

		return $.get(window.wp.ajax_url, data);
	},


	/**
	 * Events.append
	 */
	replace(html) {
		if (!html) {
			return;
		}

		this.$cont.innerHTML = html;
	},


	/**
	 * Events.append
	 */
	append(html) {
		if (!html) {
			return;
		}

		$(this.$cont).append(html);
	},


	/**
	 * Events.update
	 */
	update() {
		// this.offset = this.$cont.children.length;
		// ensure everything is unlocked
		this.lock.off.call(this);
	},


	/**
	 * Events.lock
	 */
	lock: {

		/**
		 * Events.lock.on
		 */
		on() {
			// console.log('Events.lock.on');
			if (this.category.button) {
				classes.add(this.category.button, 'is-active');
			}

			// add loading state to ajax container if exists
			if (this.$cont) {
				classes.add(this.$cont, 'is-loading');
			}
		},


		/**
		 * Events.lock.off
		 */
		off() {
			// console.log('Events.lock.off');
			// remove loading state of ajax container if exists
			if (this.$cont) {
				classes.remove(this.$cont, 'is-loading');
			}
		},
	},
};
