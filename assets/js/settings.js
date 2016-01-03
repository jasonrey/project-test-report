'use strict';

$(function() {
	$$('#settings-form').on('change', '.settings-project', function(event) {
		var item = $(this),
			value = item.attr('data-value').toLowerCase();

		document.forms['settings-form'].project.value = value;

		$$('#settings-form').toggleClass('show-warning', value === 'all');

		$api('user/loadSettings', {
			project: value
		}).done(function(response) {
			if (response.state) {
				var themeColor = $$('.theme-settings').find('.form-select'),
					colorOption = themeColor.find('.theme-' + response.data.color),
					colorOptionSiblings = colorOption.siblings();

				colorOption.addClass('active');
				colorOptionSiblings.removeClass('active');

				themeColor.attr('data-value', response.data.color);

				themeColor.find('.form-select-selected').html(colorOption.html());

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

	$$('.theme-settings').on('change', '.form-select', function(event) {
		var item = $(this),
			field = item.parents('.form-field'),
			name = field.attr('data-name'),
			value = item.attr('data-value').toLowerCase().replace(' ', ''),
			project = document.forms['settings-form'].project.value;

		$$('.custom-theme-settings').toggleClass('active', value === 'custom');

		$api('user/saveSettings', {
			project: project,
			setting: JSON.stringify({
				name: name,
				value: value
			})
		});

		var isDevelopment = $$('body').attr('data-development') == 1;

		var link = $('#theme');

		link.remove();

		if (isDevelopment) {
			$('[id^="less:"]').remove();
		}

		if (value === 'custom') {
			return;
		}

		if (value === 'cyan') {
			less.registerStylesheets().then(function() {
				less.refresh();
			});

			return;
		}

		link = $('<link id="theme" />');

		link.one('load', function() {

			if (isDevelopment) {
				link.attr('rel', 'stylesheet/less');
			}

			if (isDevelopment) {
				less.registerStylesheets().then(function() {
					less.refresh();
				});
			}
		});

		link.attr('rel', 'stylesheet');
		link.attr('type', 'text/css');
		link.attr('href', 'assets/css/theme-' + value + '.' + (isDevelopment ? 'less' : 'css'));

		$$('head').append(link);
	});

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
			});
		}, 500);
	});
});
