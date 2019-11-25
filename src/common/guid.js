/**
 * Guid
 */
export default function () {
	// show/hide guides with CMD+;
	document.addEventListener('keydown', (e) => {
		const $guid = document.querySelector('.Guid');

		if ((e.metaKey || e.ctrlKey) && e.keyCode === 186) {
			$guid.classList.toggle('display-none');
		}
	});
}
