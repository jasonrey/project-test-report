$(function() {
	'use strict';

	$$('#filter-form').on('change', '.filter-project', function(event) {
		var item = $(this),
			value = item.attr('data-value');

		document.forms['filter-form'].project.value = value.toLowerCase();

		$$('#filter-form').trigger('submit');
	});
});
