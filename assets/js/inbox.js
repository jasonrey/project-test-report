$(function() {
	'use strict';

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

		if (target.closest('.form-select').length) {
			$('.form-select').not(target.closest('.form-select')).removeClass('active');
		}

		if (target.closest('.form-select').length === 0) {
			$('.form-select').removeClass('active');
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

	$$('#filter-form').on('click', '.filter-item-option:not(.active)', function(event) {
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

	$$('body').on('click', '.refresh-list-button', function(event) {
		$$('#filter-form').trigger('submit');
	});

	$$('#report-item-list').on('click', '.item-screenshot', function(event) {
		event.preventDefault();

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
			content = input.val();

		if (!content) {
			return;
		}

		var item = form.parents('.item'),
			id = item.attr('data-id'),
			attachments = item.find('.attachment-item'),
			list = item.find('.comment-item-list'),
			commentcount = item.find('.item-comments-counter'),
			temporaryId = 'comment-' + Math.random().toString(36).substring(2);

		input.val('');

		commentcount.text(parseInt(commentcount.text()) + 1);

		list.scrollTop(list[0].scrollHeight);

		var formdata = new FormData();

		formdata.append('id', id);
		formdata.append('content', content);

		var attachmentsHTML = '';

		if (attachedFiles[id] !== undefined) {
			for (var fileKey in attachedFiles[id]) {
				formdata.append(fileKey, attachedFiles[id][fileKey]);

				var isImage = ['jpg', 'png'].indexOf(attachedFiles[id][fileKey].name.substr(-3)) >= 0;

				attachmentsHTML += $template('comment-item-attachment-file', {
					imageClass: isImage ? 'comment-attachment-image' : '',
					key: fileKey,
					filename: fileKey + '-' + attachedFiles[id][fileKey].name,
					name: attachedFiles[id][fileKey].name
				});
			}

			delete attachedFiles[id];

			attachments.remove();

			item.removeClass('has-attachment');
		}

		var commentitem = $($template('comment-item-self', {
			id: temporaryId,
			content: content,
			attachments: attachmentsHTML
		}));

		list.append(commentitem);

		$api('comment/submit', formdata, {
			processData: false,
			contentType: false
		}).done(function(response) {
			if (response.state) {
				commentitem.attr('data-id', response.data);

				item.find('.comment-attachment-uploading').each(function() {
					var attachmentItem = $(this);

					attachmentItem.attr('href', attachmentItem.attr('data-href'));
					attachmentItem.html(attachmentItem.attr('data-name'));
					attachmentItem.removeClass('comment-attachment-uploading');
					attachmentItem.removeAttr('data-href');
					attachmentItem.removeAttr('data-name');
				});
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

		var assigneeImage = assignee.find('img');

		if (assigneeImage.length) {
			addButton.before($template('report-item-assignee', {
				id: assigneeid,
				image: assignee.find('img').attr('src')
			}));
		} else {
			addButton.before($template('report-item-assignee-initial', {
				id: assigneeid,
				initial: assignee.find('.user-avatar-initial').text()
			}));
		}

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

	var dragEventCounter = 0;

	$$('#report-item-list').on('dragenter', '.item-comments', function(event) {
		event.stopPropagation();
		event.preventDefault();

		dragEventCounter++;

		var comments = $(this),
			item = comments.parents('.item');

		item.addClass('attaching-file');
	});

	$$('#report-item-list').on('dragleave', '.item-comments', function(event) {
		event.stopPropagation();
		event.preventDefault();

		dragEventCounter--;

		var comments = $(this),
			item = comments.parents('.item');

		if (dragEventCounter === 0) {
			item.removeClass('attaching-file');
		}
	});

	$$('#report-item-list').on('dragover', '.item-comments', function(event) {
		event.stopPropagation();
		event.preventDefault();
	});

	$$('#report-item-list').on('drop', '.item-comments', function(event) {
		event.stopPropagation();
		event.preventDefault();

		var comments = $(this),
			item = comments.parents('.item');

		item.removeClass('attaching-file');
		dragEventCounter = 0;

		var files = event.originalEvent.dataTransfer.files;

		attachFiles(item, files);

		item.addClass('has-attachment');
	});

	$$('#report-item-list').on('click', '.comment-attach-button', function(event) {
		var button = $(this),
			form = button.parents('.comment-reply'),
			input = form.find('.comment-attach-file');

		input.trigger('click');
	});

	$$('#report-item-list').on('change', '.comment-attach-file', function(event) {
		var input = $(this),
			item = input.parents('.item');

		attachFiles(item, this.files);

		item.addClass('has-attachment');
	});

	$$('#report-item-list').on('click', '.attachment-item-delete', function(event) {
		var button = $(this),
			attachment = button.parents('.attachment-item'),
			attachmentid = attachment.attr('id'),
			attachmentList = button.parents('.comment-form-attachment-items'),
			item = button.parents('.item'),
			id = item.attr('data-id');

		attachment.remove();

		if (attachmentList.find('.attachment-item').length === 0) {
			item.removeClass('has-attachment');
		}

		delete attachedFiles[id][attachmentid];
	});

	$$('#report-item-list').on('click', '.comment-attachment', function(event) {
		var link = $(this);

		if (link.hasClass('comment-attachment-uploading') || link.hasClass('comment-attachment-image')) {
			event.preventDefault();

			if (link.hasClass('comment-attachment-uploading')) {
				return;
			}
		}

		var source = link.attr('href');

		$$('#screenshot-preview').find('img').attr('src', source);

		$$('#screenshot-preview').addClass('active');
	});

	var attachedFiles = {};

	var attachFiles = function(item, files) {
		var promises = [];

		for (var i = 0; i < files.length; i++) {
			var file = files[i];

			promises.push(attachFile(item, file));
		}

		return Promise.all(promises);
	};

	var attachFile = function(item, file) {
		var id = item.attr('data-id'),
			commentFiles = item.find('.comment-form-attachment-items'),
			fileid = 'file-' + Date.now() + '-' + Math.random().toString(36).substring(2),
			attachment = $template('comment-form-attachment-file', {
				id: fileid,
				name: file.name
			});

		commentFiles.append(attachment);

		if (attachedFiles[id] === undefined) {
			attachedFiles[id] = {};
		}

		attachedFiles[id][fileid] = file;
	};

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

	// setTimeout(commentsSyncHandler, 10000);
});
