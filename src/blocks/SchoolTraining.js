/**
 * SchoolTraining
 *
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */
export default class SchoolTraining {
	constructor(element) {
		this.$element = document.querySelector(element);

		if (!this.$element || this.$element === undefined) return false;

		this.$cont = this.$element.querySelector('.js-school-trainings-container');
		this.buttonFilters = this.$element.querySelectorAll('.js-school-trainings-button');

		this.school_class = {
			ids: [0],
			button: null,
		};
		this.season = null;

		// this.count = parseInt(this.button.dataset.count, 0);
		// this.offset = 0;

		return true;
	}

	init() {
		if (!this.$element || this.$element === undefined) return false;

		return this.setupEvents();
	}

	/**
	 * SchoolTraining.setupEvents
	 */
	setupEvents() {
		this.$element.addEventListener('click', (e) => {
			if (e.target === this.school_class.button) {
				return;
			}

			// If element hasn't 'js-school-trainings-button' class
			if (!e.target.classList.contains('js-school-trainings-button')) {
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
	}


	/**
	 * SchoolTraining.filter
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
	 * SchoolTraining.load
	 */
	load() {
		let url = `${window.wp.ajax_url}?action=ajax_load_school_trainings`;

		if (this.school_class.ids) {
			url += `&school_class=${this.school_class.ids}`;
		}

		if (this.season) {
			url += `&season=${this.season}`;
		}

		const request = new Request(url);
		const init = {
			method: 'post',
			// offset: this.offset,
		};

		// lock everything before the request
		this.lock('on');

		return fetch(request, init);
	}


	/**
	 * SchoolTraining.replace
	 */
	replace(html) {
		if (!html) {
			return;
		}

		this.$cont.innerHTML = html;
	}


	/**
	 * SchoolTraining.update
	 */
	update() {
		// this.offset = this.$cont.children.length;
		// ensure everything is unlocked
		this.lock('off');
	}


	/**
	 * SchoolTraining.lock
	 *
	 * @param {str} method on or off
	 */
	lock(method) {
		// console.log('SchoolTraining.lock(on)');
		if (method === 'on') {
			if (this.school_class.button) {
				this.school_class.button.classList.add('is-active');
			}

			// add loading state to ajax container if exists
			if (this.$cont) {
				this.$cont.classList.add('is-loading');
			}
		}

		// console.log('SchoolTraining.lock('off')');
		if (method === 'off') {
			// remove loading state of ajax container if exists
			if (this.$cont) {
				this.$cont.classList.remove('is-loading');
			}
		}
	}
}
