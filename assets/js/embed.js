'use strict';

(function(ready) {
	document.readyState !== 'loading' ? ready() : document.addEventListener('DOMContentLoaded', ready);
})(function() {
	var $id = function(name) {
		return document.getElementById(name);
	}

	Element.prototype.on = function(name, fx) {
		return this.addEventListener(name, fx);
	};

	var $template = function(id, data) {
		var item = $id(id).innerHTML.replace(RegExp('\\{\\{(.+?)\\}\\}', 'g'), function(match, p1) {
			return data[p1] !== undefined ? data[p1] : '';
		});

		var wrapper = document.createElement('div');

		wrapper.innerHTML = item;

		return wrapper.firstElementChild;
	};

	$id('report-close-button').on('click', function() {
		parent.document.getElementById('project-report-embed').className = '';
		parent.document.getElementById('project-report-button').className = '';
	});

	var dragEventCounter = 0;

	$id('report-screenshots').on('dragenter', function(event) {
		event.stopPropagation();
		event.preventDefault();

		dragEventCounter++;

		$id('drop-file-mask').className = 'active';
	});

	$id('report-screenshots').on('dragleave', function(event) {
		event.stopPropagation();
		event.preventDefault();

		dragEventCounter--;

		if (dragEventCounter === 0) {
			$id('drop-file-mask').className = '';
		}
	});

	$id('report-screenshots').on('dragover', function(event) {
		event.stopPropagation();
		event.preventDefault();
	});

	$id('report-screenshots').on('drop', function(event) {
		event.stopPropagation();
		event.preventDefault();

		$id('drop-file-mask').className = '';
		dragEventCounter = 0;

		var files = event.dataTransfer.files;

		uploadFiles(files);
	});

	$id('report-screenshot-add').on('click', function(event) {
		$id('report-screenshot-file').click();
	});

	$id('report-screenshot-file').on('change', function(event) {
		uploadFiles(this.files).then(function() {
		});
	});

	var uploadFiles = function(files) {
		var promises = [];

		var uploadFile = function(file) {
			var promise = new Promise(function(resolve, reject) {
				var reader = new FileReader(),
					id = 'screenshot-' + Math.random().toString(36).substring(2);

				reader.onloadend = function(e) {
					var item = $template('report-screenshot-item', {
						id: id,
						img: e.target.result
					});

					$id('report-screenshots').appendChild(item);

					resolve();
				};

				reader.readAsDataURL(file);

				var formdata = new FormData();

				formdata.append('file', file);
			});

			return promise;
		};

		for (var i = 0; i < files.length; i++) {
			var file = files[i];

			if (file.type === 'image/png' || file.type === 'image/jpeg') {
				promises.push(uploadFile(file));
			}
		}

		return Promise.all(promises);
	}
});
