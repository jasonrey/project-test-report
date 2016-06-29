$(function() {
	'use strict';

	var currentLocation;

	parent.postMessage('getLocation', '*');

	$$('#report-close-button').on('click', function() {
		parent.postMessage('project-test-report-close', '*');
	});

	window.addEventListener('message', function(event) {
		if (event.data === 'checkIdentity') {
			if (window.checkIdentity) {
				window.checkIdentity();
			}
		}

		if (typeof event.data === 'object') {
			if (event.data.name === 'location') {
				currentLocation = event.data.data;
			}
		}
	});

	var dragEventCounter = 0;

	$$('#report-screenshots').on('dragenter', function(event) {
		event.stopPropagation();
		event.preventDefault();

		dragEventCounter++;

		$$('#drop-file-mask').addClass('active');
	});

	$$('#report-screenshots').on('dragleave', function(event) {
		event.stopPropagation();
		event.preventDefault();

		dragEventCounter--;

		if (dragEventCounter === 0) {
			$$('#drop-file-mask').removeClass('active');
		}
	});

	$$('#report-screenshots').on('dragover', function(event) {
		event.stopPropagation();
		event.preventDefault();
	});

	$$('#report-screenshots').on('drop', function(event) {
		event.stopPropagation();
		event.preventDefault();

		$$('#drop-file-mask').removeClass('active');
		dragEventCounter = 0;

		var files = event.originalEvent.dataTransfer.files;

		attachFiles(files);
	});

	$$('#report-screenshots').on('click', '.report-screenshot-close', function(event) {
		var item = $(this).parents('.report-screenshot');

		delete attachedFiles[item.attr('id')];

		item.remove();
	});

	$$('#report-screenshot-add').on('click', function(event) {
		$$('#report-screenshot-file').trigger('click');
	});

	$$('#report-screenshot-file').on('change', function(event) {
		attachFiles(this.files);
	});

	$$('#report-form').on('submit', function(event) {
		event.preventDefault();

		var form = this,
			content = form['report-text'].value,
			category = form['report-category'].value,
			project = form.project.value;

		if (content.length === 0) {
			return;
		}

		$$('#report-form').addClass('submitting');

		var formdata = new FormData();

		formdata.append('project', project);
		formdata.append('content', content);
		formdata.append('category', category);
		formdata.append('url', currentLocation);

		for (var fileKey in attachedFiles) {
			formdata.append(fileKey, attachedFiles[fileKey]);
		}

		$api('report/save', formdata, {
			processData: false,
			contentType: false
		}).done(function(response) {
			if (response.state) {
				setTimeout(function() {
					$$('#report-form').removeClass('submitting');
					resetForm();
				}, 500);
			}
		});
	});

	var attachedFiles = {};

	var attachFiles = function(files) {
		var promises = [];

		for (var i = 0; i < files.length; i++) {
			var file = files[i];

			if (file.type === 'image/png' || file.type === 'image/jpeg') {
				promises.push(attachFile(file));
			}
		}

		return Promise.all(promises);
	};

	var attachFile = function(file) {
		var promise = new Promise(function(resolve, reject) {
			var reader = new FileReader(),
				id = 'screenshot-' + Math.random().toString(36).substring(2);

			reader.onloadend = function(e) {
				var item = $template('report-screenshot-item', {
					id: id,
					img: e.target.result
				});

				$$('#report-screenshots').append(item);

				attachedFiles[id] = file;

				resolve();
			};

			reader.readAsDataURL(file);
		});

		return promise;
	};

	var resetForm = function() {
		attachedFiles = {};

		$$('.report-screenshot-item').remove();

		document.forms['report-form']['report-text'].value = '';
	};

	$$('#report-item-list').on('click', '.item-date a', function(event) {
		event.preventDefault();
	});

	$$('#category-settings-new').on('keyup', function(event) {
		if (event.keyCode === 13) {
			$$('#category-settings-add').trigger('click');
		}
	});

	$$('#category-settings-add').on('click', function(event) {
		var name = $$('#category-settings-new').val();

		if (name === '') {
			return;
		}

		var randomId = 'tmp' + Math.random().toString().substr(2);

		var data = {
			id: randomId,
			name: name
		};

		var html = $template('category-settings-list-item', data);

		$api('category/save', {
			name: name
		}).done(function(response) {
			if (response.state) {
				$$('#' + randomId)
					.removeClass('loading')
					.attr('data-id', response.data);

				if ($$('#report-category').length > 0) {
					$$('#report-category').append($template('report-category-item', {
						id: response.data,
						name: name
					}));
				}
			} else {
				$$('#' + randomId).remove();
			}
		});

		$$('#category-settings-new').val('');

		$$('#category-settings-list').append(html);
	});

	$$('#category-settings-list').on('click', 'li button', function() {
		var button = $(this),
			item = button.parents('li'),
			id = item.attr('data-id');

		item.remove();

		$api('category/delete', {
			id: id
		}).done(function(response) {
			if (response.state) {
				if ($$('#report-category').length > 0) {
					$$('#report-category').find('option[value="' + id + '"]').remove();
				}
			}
		});
	});
});
