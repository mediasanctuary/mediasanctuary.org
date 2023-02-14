window.addEventListener('DOMContentLoaded', function () {
	if (wp && wp.media) {
		wp.media.view.Modal.prototype.on('open', function() {
			wp.media.frame.content.mode('upload');
		});
	}
});
