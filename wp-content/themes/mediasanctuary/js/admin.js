(function($) {

	wp.domReady(async function() {

		const isEditorReady = async () =>
			new Promise(resolve => {
				const unsubscribe = wp.data.subscribe(() => {
					const isCleanNewPost = wp.data.select('core/editor').isCleanNewPost();
					if ( isCleanNewPost ) {
						unsubscribe();
						resolve();
					}
					const blocks = wp.data.select('core/editor').getBlocks();
					if ( blocks.length > 0 ) {
						unsubscribe();
						resolve();
					}
				});
			});

		await isEditorReady();

		wp.data.dispatch('core/edit-post').removeEditorPanel('discussion-panel');

		const post = await wp.data.select("core/editor").getCurrentPost();

		// If this is a child of the Initiatives page, show a warning message.
		if (post.parent == 29640) {
			const warning_message = 'Reminder: DO NOT edit the text of Initiatives pages without reviewing with the full staff.';
			wp.data.dispatch('core/notices').createWarningNotice(warning_message, {
				id: 'initiatives-warning'
			});
		}
	});

})(jQuery);
