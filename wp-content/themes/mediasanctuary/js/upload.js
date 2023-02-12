class Upload {

	constructor(el) {
		this.el = el;
		console.log(el);
	}

}

document.querySelectorAll('.upload-form').forEach(el => new Upload(el));
