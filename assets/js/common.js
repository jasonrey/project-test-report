'use strict';

$(function() {
	$$('.form-select').on('click', function(event) {
		$(this).toggleClass('active');
	});

	$$('.form-select').on('click', '.form-select-list li:not(.active)', function(event) {
		var item = $(this),
			siblings = item.siblings(),
			value = item.text(),
			parent = $(event.delegateTarget),
			selected = parent.find('.form-select-selected');

		siblings.removeClass('active');
		item.addClass('active');

		selected.text(value);
		parent.attr('data-value', value);

		parent.trigger('change');
	});
});
