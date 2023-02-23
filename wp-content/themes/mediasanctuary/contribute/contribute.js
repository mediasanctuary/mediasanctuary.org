window.addEventListener('DOMContentLoaded', function () {
	if (wp && wp.media) {
		wp.media.view.Modal.prototype.on('open', function() {
			wp.media.frame.content.mode('upload');
		});
	}
	let menu = document.querySelector('select[name="id"]');
	if (menu) {
		menu.addEventListener('change', e => {
			let form = menu.closest('form');
			form.submit();
		});
	}
});
