/**
 * Guid
 */
const Guid = () => {
	// show/hide guides with CMD+;
	document.addEventListener('keydown', e => {
		const $guid = document.querySelector('.Guid');

		if ((e.metaKey || e.ctrlKey) && 186 === e.keyCode) {
			$guid.classList.toggle('d-none');
		}
	});
};

export default Guid;
