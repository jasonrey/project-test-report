$(function() {
	'use strict';

	$$('#settings-form').on('change', '.settings-project', function(event) {
		var item = $(this),
			value = item.attr('data-value').toLowerCase();

		document.forms['settings-form'].project.value = value;

		$$('#settings-form').toggleClass('show-warning', value === 'all');
		$$('#settings-form').toggleClass('hide-notification-settings', value === '-1');
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

		link.attr('href', 'assets/css/theme-' + value.replace(' ', '') + '.' + (isDevelopment ? 'less' : 'css'));

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
});
