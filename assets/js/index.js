'use strict';

$(function() {
	$$('.form-select').on('click', function(event) {
		$(this).toggleClass('active');
	});

	$$('.filter-project').on('click', '.filter-project-list li:not(.active)', function(event) {
		var item = $(this),
			siblings = item.siblings(),
			value = item.text();

		siblings.removeClass('active');
		item.addClass('active');

		$$('.filter-project-selected').text(value);

		document.forms['filter-form'].project.value = value.toLowerCase();

		$('#filter-form').trigger('submit');
	});
});
