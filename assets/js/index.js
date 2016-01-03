'use strict';

$(function() {
	$$('.filter-project').on('change', function(event) {
		var item = $(this),
			value = item.attr('data-value');

		document.forms['filter-form'].project.value = value.toLowerCase();

		$$('#filter-form').trigger('submit');
	});
});
