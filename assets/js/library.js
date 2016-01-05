(function() {
	'use strict';

	// Cached selector
	window.$$cached = {};
	window.$$ = function(selector, refresh) {
		if (refresh !== undefined && refresh && $$cached[selector] !== undefined) {
			delete $$cached[selector];
		}

		if ($$cached[selector] === undefined) {
			$$cached[selector] = $(selector);
		}

		return $$cached[selector];
	};

	window.$template = function(id, data) {
		var item = $$('#' + id).html().replace(new RegExp('\\{\\{(.+?)\\}\\}', 'g'), function(match, p1) {
			return data[p1] !== undefined ? data[p1] : '';
		});

		return item;
	};

	window.$api = function(namespace, data, userOptions) {
		var options = $.extend({
			dataType: 'json',
			method: 'post'
		}, userOptions);

		options.data = data;

		return $.ajax('api/' + namespace, options);
	};
})();
