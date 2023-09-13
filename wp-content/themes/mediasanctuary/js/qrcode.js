window.addEventListener('DOMContentLoaded', async () => {
	const el = document.getElementById('acf-field_64fc963d8dfc4');
	if (!el) {
		return;
	}
	const parent = document.querySelector('.acf-field-64fc963d8dfc4');
	let url = '/wp-admin/admin-ajax.php?action=qrcode';
	const id = window.location.search.match(/post=(\d+)/);
	if (id) {
		url += `&id=${id[1]}`;
	}
	try {
		const rsp = await fetch(url);
		const qrcode = await rsp.json();
		const img = document.createElement('img');
		img.style.width = '100%';
		img.style.height = 'auto';
		img.style.border = '1px solid #ccc';
		img.style.marginTop = '15px';
		img.src = qrcode.url;
		parent.appendChild(img);
	} catch(error) {
		console.error(error);
	}
});
