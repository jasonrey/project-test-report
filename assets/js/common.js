'use strict';

$(function() {
	$$('body').on('click', '.form-select', function(event) {
		$(this).toggleClass('active');
	});

	$$('body').on('click', '.form-select .form-select-list li:not(.active)', function(event) {
		var item = $(this),
			siblings = item.siblings(),
			value = item.attr('data-value') || item.html(),
			parent = item.parents('.form-select'),
			selected = parent.find('.form-select-selected');

		siblings.removeClass('active');
		item.addClass('active');

		selected.html(item.html());
		parent.attr('data-value', value);

		parent.trigger('change');
	});

	$$('body').on('click', '.form-checkbox', function(event) {
		var item = $(this);

		item.toggleClass('active');
		item.trigger('change');
	});
});
