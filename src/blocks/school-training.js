const classes = require('dom-classes');


/**
 * SchoolTraining
 */
function SchoolTraining(element) {
	if (!(this instanceof SchoolTraining)) {
		return new SchoolTraining(element);
	}

	this.element = document.querySelector(element);

	if (!this.element) {
		return false;
	}

	this.$cont = this.element.querySelector('.js-school-trainings-container');
	this.buttonFilters = this.element.querySelectorAll('.js-school-trainings-button');

	this.school_class = {};
	this.school_class.ids = [0];
	this.season = null;

	// this.count = parseInt(this.button.dataset.count, 0);
	// this.offset = 0;

	this.setupEvents.call(this);
}


SchoolTraining.prototype = {

	/**
	 * SchoolTraining.setupEvents
	 */
	setupEvents() {
		this.element.addEventListener('click', (e) => {
			if (e.target === this.school_class.button) {
				return;
			}

			// If element hasn't 'js-school-trainings-button' class
			if (!classes.has(e.target, 'js-school-trainings-button')) {
				return;
			}

			// Remove all `is-active` classes
			this.buttonFilters.forEach((buttonFilter) => {
				buttonFilter.classList.remove('is-active');
			});

			// Update season
			this.season = e.target.dataset.season;

			// Stock current term_id
			this.school_class = {
				button: e.target,
				ids: e.target.dataset.schoolClassIds ? JSON.parse(e.target.dataset.schoolClassIds) : null,
			};

			this.filter();
		});
	},


	/**
	 * SchoolTraining.loadMore
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
	 * SchoolTraining.filter
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
	 * SchoolTraining.load
	 */
	load() {
		const data = {
			action: 'ajax_load_school_trainings',
			// offset: this.offset,
		};

		if (this.school_class.ids) {
			data.school_class = this.school_class.ids;
		}

		if (this.season) {
			data.season = this.season;
		}

		// lock everything before the request
		this.lock.on.call(this);

		return $.get(window.wp.ajax_url, data);
	},


	/**
	 * SchoolTraining.append
	 */
	replace(html) {
		if (!html) {
			return;
		}

		this.$cont.innerHTML = html;
	},


	/**
	 * SchoolTraining.append
	 */
	append(html) {
		if (!html) {
			return;
		}

		$(this.$cont).append(html);
	},


	/**
	 * SchoolTraining.update
	 */
	update() {
		// this.offset = this.$cont.children.length;
		// ensure everything is unlocked
		this.lock.off.call(this);
	},


	/**
	 * SchoolTraining.lock
	 */
	lock: {

		/**
		 * SchoolTraining.lock.on
		 */
		on() {
			// console.log('SchoolTraining.lock.on');
			if (this.school_class.button) {
				classes.add(this.school_class.button, 'is-active');
			}

			// add loading state to ajax container if exists
			if (this.$cont) {
				classes.add(this.$cont, 'is-loading');
			}
		},


		/**
		 * SchoolTraining.lock.off
		 */
		off() {
			// console.log('SchoolTraining.lock.off');
			// remove loading state of ajax container if exists
			if (this.$cont) {
				classes.remove(this.$cont, 'is-loading');
			}
		},
	},
};


export default SchoolTraining;
