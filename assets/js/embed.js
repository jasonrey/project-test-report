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

	$$('body').on('click', function(event) {
		var target = $(event.target);

		if (target.closest('.filter-item').length === 0) {
			$('.filter-item').removeClass('active');
		}

		if (target.closest('.item-assignee-add').length || target.closest('.item-available-assignees').length) {
			$('.item').not(target.closest('.item')).removeClass('show-assignees');
		}

		if (target.closest('.item-assignee-add').length === 0 && target.closest('.item-available-assignees').length === 0) {
			$('.item').removeClass('show-assignees');
		}

		if (target.closest('.item-state').length) {
			$('.item-state').not(target.closest('.item-state')).removeClass('active');
		}

		if (target.closest('.item-state').length === 0) {
			$('.item-state').removeClass('active');
		}
	});

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

	$$('#report-item-list').on('click', '.item-screenshot', function(event) {
		var screenshot = $(this),
			source = screenshot.find('img').attr('src');

		$$('#screenshot-preview').find('img').attr('src', source);

		$$('#screenshot-preview').addClass('active');
	});

	$$('#screenshot-preview-close-button').on('click', function(event) {
		$$('#screenshot-preview').removeClass('active');
	});

	$$('#screenshot-preview').on('click', '.overlay', function(event) {
		$$('#screenshot-preview').removeClass('active');
	});

	$$('#report-item-list').on('click', '.item-comments-link', function(event) {
		var button = $(this),
			item = button.parents('.item');

		item.toggleClass('active');
	});

	$$('#filter-form').on('click', '.filter-item', function(event) {
		var button = $(this),
			siblings = button.siblings();

		button.toggleClass('active');
		siblings.removeClass('active');
	});

	$$('#filter-form').on('click', '.filter-item-option', function(event) {
		var button = $(this),
			siblings = button.siblings(),
			value = button.attr('data-value'),
			item = button.parents('.filter-item'),
			name = item.attr('data-name'),
			selectedIcon = item.find('.filter-item-selected .filter-item-icon');

		siblings.removeClass('active');
		button.addClass('active');

		selectedIcon.html(button.find('.filter-item-icon').html());

		document.forms['filter-form'][name].value = value;

		$$('#filter-form').trigger('submit');
	});

	$$('#filter-form').on('submit', function(event) {
		event.preventDefault();

		var form = document.forms['filter-form'];

		$api('report/filter', {
			state: form.state.value,
			assignee: form.assignee.value,
			sort: form.sort.value,
			project: form.project.value
		}).done(function(response) {
			if (response.state) {
				if (response.data.length === 0) {
					$$('#report-item-list').html($template('report-no-result'));
				} else {
					$$('#report-item-list').html(response.data);
				}
			}
		});
	});

	$$('#report-item-list').on('click', '.item-assignee-add', function(event) {
		var button = $(this),
			item = button.parents('.item');

		item.toggleClass('show-assignees');
	});

	$$('#report-item-list').on('click', '.item-available-assignee', function(event) {
		var assignee = $(this),
			siblings = assignee.siblings(),
			assigneeid = assignee.attr('data-value'),
			item = assignee.parents('.item'),
			id = item.attr('data-id'),
			addButton = item.find('.item-assignee-add');

		item.removeClass('show-assignees');

		if (assignee.hasClass('active')) {
			return;
		}

		assignee.addClass('active');
		siblings.removeClass('active');

		item.find('.item-assignee').remove();

		addButton.before($template('report-item-assignee', {
			id: assigneeid,
			image: assignee.find('img').attr('src')
		}));

		if (assignee.hasClass('is-self')) {
			item.addClass('is-assignee');
		}

		$api('report/assign', {
			id: id,
			assigneeid: assigneeid
		});
	});

	$$('#report-item-list').on('click', '.item-assignee-deletable', function(event) {
		var button = $(this),
			item = button.parents('.item'),
			id = item.attr('data-id');

		button.remove();
		item.find('.item-available-assignee').removeClass('active');
		item.removeClass('is-assignee');

		$api('report/assign', {
			id: id,
			assigneeid: '0'
		});
	});

	$$('#report-item-list').on('click', '.item-state', function(event) {
		$(this).toggleClass('active');
	});

	$$('#report-item-list').on('click', '.item-state-option:not(.item-state-selected)', function(event) {
		var button = $(this),
			siblings = button.siblings(),
			item = button.parents('.item'),
			id = item.attr('data-id'),
			value = button.attr('data-value');

		siblings.removeClass('item-state-selected');
		button.addClass('item-state-selected');

		item.attr('data-state', value);

		$api('report/mark', {
			id: id,
			state: value
		});
	});
});
