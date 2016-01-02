'use strict';

$(function() {
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

		if (target.closest('.filter-project').length === 0) {
			$$('.filter-project').removeClass('active');
		}
	});

	$$('#report-tab-navs').on('click', '.report-tab-nav', function(event) {
		var button = $(this),
			name = button.attr('data-name');

		$$('#report-frame').attr('data-tab', name);
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
			item = button.parents('.item'),
			id = item.attr('data-id'),
			list = item.find('.comment-item-list');

		item.toggleClass('show-comments');

		if (!item.hasClass('loaded-comments')) {
			$api('comment/load', {
				reportid: id
			}).done(function(response) {
				if (response.state) {
					list.html(response.data);

					setTimeout(function() {
						item.addClass('loaded-comments');
						list.scrollTop(list[0].scrollHeight);
					}, 1);
				}
			});
		}
	});

	$$('#report-item-list').on('submit', '.comment-reply', function(event) {
		event.preventDefault();

		var form = $(this),
			input = form.find('.comment-reply-input'),
			content = input.val(),
			item = form.parents('.item'),
			id = item.attr('data-id'),
			list = item.find('.comment-item-list'),
			commentcount = item.find('.item-comments-counter'),
			temporaryId = 'comment-' + Math.random().toString(36).substring(2),
			commentitem = $($template('comment-item-self', {
				id: temporaryId,
				content: content
			}));

		list.append(commentitem);

		input.val('');

		commentcount.text(parseInt(commentcount.text()) + 1);

		list.scrollTop(list[0].scrollHeight);

		$api('comment/submit', {
			id: id,
			content: content
		}).done(function(response) {
			if (response.state) {
				commentitem.attr('data-id', response.data);
			} else {
				commentitem.addClass('icon-attention error');
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

	var commentsSyncHandler = function() {
		var reports = {},
			ids = [];

		var items = $('.item');

		items.each(function() {
			var item = $(this),
				id = item.attr('data-id');

			ids.push(id);

			reports[id] = {
				totalComments: parseInt(item.find('.item-comments-counter').text()),
				commentsLoaded: false,
				comments: []
			};

			if (item.hasClass('loaded-comments')) {
				reports[id].commentsLoaded = true;

				item.find('.comment-item').each(function() {
					var comment = $(this),
						commentid = comment.attr('data-id');

					reports[id].comments.push(commentid);
				});
			}
		});

		$api('comment/sync', {
			reports: JSON.stringify(reports),
			ids: ids
		}).done(function(response) {
			if (response.state) {
				$.each(response.data, function(id, data) {
					var item = items.filter('[data-id="' + id + '"]');

					item.find('.item-comments-counter').text(data.totalComments);

					if (!item.hasClass('loaded-comments')) {
						return true;
					}

					var list = item.find('.comment-item-list'),
						lastCommentId = false;

					$.each(data.comments, function(commentId, commentHtml) {
						if (!commentHtml) {
							lastCommentId = commentId;
							return true;
						}

						if (!lastCommentId) {
							list.prepend(commentHtml);
						} else {
							list.find('.comment-item[data-id="' + lastCommentId + '"]').after(commentHtml);
						}

						lastCommentId = commentId;
					});

					list.scrollTop(list[0].scrollHeight);
				});

				setTimeout(commentsSyncHandler, 10000);
			}

		});
	};

	setTimeout(commentsSyncHandler, 10000);
});
