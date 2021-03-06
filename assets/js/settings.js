$(function() {
	'use strict';

	$$('#settings-form').on('change', '.settings-project', function(event) {
		var item = $(this),
			value = item.attr('data-value').toLowerCase();

		document.forms['settings-form'].project.value = value;

		if (value === 'all') {
			$$('#settings-form').attr('data-scope', 'all');
		} else if (value === '-1') {
			$$('#settings-form').attr('data-scope', 'this');
		} else {
			$$('#settings-form').attr('data-scope', 'project');
		}

		$api('user/loadSettings', {
			project: value
		}).done(function(response) {
			if (response.state) {
				var themeColor = $$('.theme-settings').find('.form-select'),
					colorOption = themeColor.find('.theme-' + response.data.color.replace(' ', '')),
					colorOptionSiblings = colorOption.siblings();

				colorOption.addClass('active');
				colorOptionSiblings.removeClass('active');

				themeColor.attr('data-value', response.data.color);

				themeColor.find('.form-select-selected').html(colorOption.html());

				$$('.custom-theme-settings').toggleClass('active', response.data.color === 'custom');

				$.each(['assign', 'completed', 'rejected', 'comment-owner', 'comment-participant'], function(i, name) {
					$$('#settings-form').find('[data-name="' + name + '"] .form-checkbox').toggleClass('active', response.data[name]);
				});

				$.each(['color50', 'color100', 'color200', 'color300', 'color400', 'color500', 'color600', 'color700', 'color800', 'color900'], function(i, name) {
					if (response.data[name] !== undefined) {
						document.forms['settings-form'][name].value = response.data[name];
					}
				});
			}
		});
	});

	$$('.notification-settings').on('click', '.form-title', function(event) {
		var item = $(this),
			field = item.parents('.form-field'),
			checkbox = field.find('.form-checkbox');

		checkbox.trigger('click');
	});

	$$('.notification-settings').on('change', '.form-checkbox', function(event) {
		var checkbox = $(this),
			item = checkbox.parents('.form-field'),
			name = item.attr('data-name'),
			project = document.forms['settings-form'].project.value;

		$api('user/saveSettings', {
			project: project,
			setting: JSON.stringify({
				name: name,
				value: checkbox.hasClass('active')
			})
		});
	});

	$$('.assignees-settings').on('click', '.user-avatar', function(event) {
		var item = $(this),
			avatar = item.parents('.project-assignee'),
			checkbox = avatar.find('.form-checkbox');

		checkbox.trigger('click');
	});

	$$('.assignees-settings').on('change', '.form-checkbox', function(event) {
		var checkbox = $(this),
			item = checkbox.parents('.project-assignee'),
			userid = item.attr('data-id'),
			project = document.forms['settings-form'].project.value;

		$api('project/saveAssignees', {
			project: project,
			setting: JSON.stringify({
				id: userid,
				value: checkbox.hasClass('active')
			})
		});
	});

	$$('.theme-settings').on('change', '.form-select', function(event) {
		var item = $(this),
			field = item.parents('.form-field'),
			name = field.attr('data-name'),
			value = item.attr('data-value').toLowerCase(),
			project = document.forms['settings-form'].project.value;

		$$('.custom-theme-settings').toggleClass('active', value === 'custom');

		$api('user/saveSettings', {
			project: project,
			setting: JSON.stringify({
				name: name,
				value: value
			})
		});

		reloadTheme(value);
	});

	var reloadTheme = function(value) {
		var project = document.forms['settings-form'].project.value;

		if ($$('.settings-project-bar').length && project !== '-1' && project !== 'all') {
			return;
		}

		var isDevelopment = $$('body').attr('data-development') == 1;

		var link = $('#theme');

		link.remove();

		if (isDevelopment) {
			$('[id^="less:"]').remove();
		}

		if (value === 'cyan') {
			if (isDevelopment) {
				less.registerStylesheets().then(function() {
					less.refresh();
				});
			}

			return;
		}

		link = $('<link id="theme" rel="stylesheet" type="text/css" />');

		link.one('load', function() {

			if (isDevelopment) {

				if (value !== 'custom') {
					link.attr('rel', 'stylesheet/less');
				}

				less.registerStylesheets().then(function() {
					less.refresh();
				});
			}
		});

		link.attr('href', 'assets/' + (isDevelopment ? 'less' : 'css') + '/theme-' + value.replace(' ', '') + '.' + (isDevelopment ? 'less' : 'css'));

		if (value === 'custom') {
			link.attr('href', 'css/theme-custom/' + project);
		}

		$$('head').append(link);
	};

	var customThemeSettingsTimeout = {};

	$$('.custom-theme-settings').on('keyup', 'input', function(event) {

		var input = $(this),
			name = input.attr('name'),
			project = document.forms['settings-form'].project.value;

		clearTimeout(customThemeSettingsTimeout[name]);

		customThemeSettingsTimeout[name] = setTimeout(function() {
			var value = input.val();

			$api('user/saveSettings', {
				project: project,
				setting: JSON.stringify({
					name: name,
					value: value
				})
			}).done(function() {
				reloadTheme('custom');
			});
		}, 500);
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

		var project = document.forms['settings-form'].project.value;

		var html = $template('category-settings-list-item', data);

		$api('category/save', {
			project: project,
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

	$$('#category-settings-list').on('click', 'li button', function(event) {
		event.stopPropagation();

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

	$$('#category-settings-list').on('click', 'li', function(event) {
		var item = $(this);

		item.addClass('editting');

		item.find('div')
			.prop('contenteditable', true)
			.trigger('focus');
	});

	$$('#category-settings-list').on('keydown', 'li', function(event) {
		if (event.keyCode === 13) {
			$(this).trigger('blur');

			return false;
		}
	});

	$$('#category-settings-list').on('blur', 'li', function(event) {
		var item = $(this),
			id = item.attr('data-id'),
			name = item.find('div').text();

		item.removeClass('editting');

		item.find('div').prop('contenteditable', false);

		$api('category/update', {
			id: id,
			name: name
		}).done(function(response) {
			if (response.state) {
				$$('#report-category').find('option[value="' + id + '"]').text(name);
			}
		});
	});
});
