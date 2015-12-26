'use strict';

$(function() {
	// Cached selector
	var $$cached = {};
	var $$ = function(selector, refresh) {
		if (refresh !== undefined && refresh && $$cached[selector] !== undefined) {
			delete $$cached[selector];
		}

		if ($$cached[selector] === undefined) {
			$$cached[selector] = $(selector);
		}

		return $$cached[selector];
	};

	var $template = function(id, data) {
		var item = $$('#' + id).html().replace(RegExp('\\{\\{(.+?)\\}\\}', 'g'), function(match, p1) {
			return data[p1] !== undefined ? data[p1] : '';
		});

		return item;
	};

	var $api = function(namespace, data, userOptions) {
		var options = $.extend({
			dataType: 'json',
			method: 'post'
		}, userOptions);

		options.data = data;

		return $.ajax('api/' + namespace, options);
	};

	$$('#report-close-button').on('click', function() {
		parent.document.getElementById('project-report-embed').className = '';
		parent.document.getElementById('project-report-button').className = '';
	});

	var auth2;

	var signIn = function() {
		auth2.signIn().then(function() {
			$$('#report-login-frame').attr('data-state', 'authenticating');

			var googleUser = auth2.currentUser.get();

			$api('user/authenticate', {
				gid: googleUser.getId(),
				token: googleUser.getAuthResponse().id_token
			}).done(function(response) {
				if (response.state) {
					location.reload();
				} else {
					if (response.data !== undefined) {
						$$('#report-login-error-text').text(response.data)
					}

					$$('#report-login-frame').attr('data-state', 'error');
				}
			});
		});
	};

	window.checkIdentity = function() {
		$$('#report-login-button').length && signIn();
	};

	if ($$('#report-login-button').length) {
		gapi.load('auth2', function() {
			auth2 = gapi.auth2.init({
				scope: 'profile email'
			});

			$$('#report-login-button').on('click', signIn);
		});

		return;
	}

	$$('#report-tab-navs').on('click', '.report-tab-nav', function(event) {
		var button = $(this),
			name = button.attr('data-name');

		$$('#report-frame').attr('data-tab', name);
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
			project = form['project'].value;

		if (content.length === 0) {
			return;
		}

		$$('#report-form').addClass('submitting');

		var formdata = new FormData;

		formdata.append('project', project);
		formdata.append('content', content);
		formdata.append('url', parent.location.toString());

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

		for (var i = 0; i < files.length; i++) {
			var file = files[i];

			if (file.type === 'image/png' || file.type === 'image/jpeg') {
				promises.push(attachFile(file));
			}
		}

		return Promise.all(promises);
	};

	var resetForm = function() {
		attachedFiles = {};

		$$('.report-screenshot-item').remove();

		document.forms['report-form']['report-text'].value = '';
	};

	$$('#report-item-list').on('click', '.report-item-comments-link', function(event) {
		var button = $(this),
			item = button.parents('.report-item'),
			commentList = item.find('.comment-item-list');

		item.toggleClass('active');

		var scrollinit = item.data('scrollinit');

		if (!scrollinit) {
			commentList.scrollTop(commentList[0].scrollHeight);

			item.data('scrollinit', true);
		}

	});

	$$('#report-item-filter').on('click', '.filter-item', function(event) {
		var button = $(this),
			siblings = button.siblings();

		button.toggleClass('active');
		siblings.removeClass('active');
	});

});
