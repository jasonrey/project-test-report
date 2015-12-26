<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<a href="javascript:void(0);" id="report-close-button">&times;</a>

<?php if ($isLoggedIn) { ?>
<div id="report-frame" data-tab="<?php echo $user->role == USER_ROLE_ADMIN ? 'inbox' : 'report'; ?>">
	<div id="report-tab-navs">
		<a href="javascript:void(0);" class="report-tab-nav" data-name="report"><i class="icon-feather-paper"></i><p>Report</p></a>
		<a href="javascript:void(0);" class="report-tab-nav" data-name="inbox"><i class="icon-feather-archive"></i><p>Inbox</p></a>
	</div>

	<div id="report-tab-contents">
		<div class="report-tab-content" data-name="report">
			<form id="report-form">
				<div class="form-group">
					<label for="report-screenshots" class="icon-picture">Screenshots</label>
					<div id="report-screenshots" name="report-screenshots" class="report-screenshots">
						<div id="drop-file-mask">
							<div class="drop-file-message icon-upload">Upload this image</div>
						</div>
						<button type="button" id="report-screenshot-add" class="report-screenshot"><i class="icon-plus"></i></button>
					</div>
					<input type="file" name="report-screenshot-file" id="report-screenshot-file" />
				</div>

				<div class="form-group">
					<label for="report-text" class="icon-pencil">Report</label>
					<textarea name="report-text"></textarea>
				</div>

				<input type="hidden" name="project" value="<?php echo $project; ?>" />

				<button class="form-submit">Submit</button>

				<div id="report-submitting">
					<div class="report-submitting-message report-submitting-message-loading"><i class="icon-loader icon-spin"></i></div>
					<div class="report-submitting-message report-submitting-message-completed"><i class="icon-ok"></i></div>
				</div>
			</form>
		</div>
		<div class="report-tab-content" data-name="inbox">
			<div id="report-item-filter">
				<div class="report-item-filter-title"><i class="icon-filter"></i></div>
				<div class="report-item-filter-group">
					<div class="report-item-filter-group-title">State</div>
					<a href="javascript:void(0);"><i class="icon-clock"></i></a>
					<a href="javascript:void(0);"><i class="icon-ok"></i></a>
					<a href="javascript:void(0);"><i class="icon-cancel"></i></a>
				</div>
				<div class="report-item-filter-group">
					<div class="report-item-filter-group-title">Fixer</div>
					<a href="javascript:void(0);"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></a>
					<a href="javascript:void(0);"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></a>
					<a href="javascript:void(0);"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></a>
					<a href="javascript:void(0);"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></a>
					<a href="javascript:void(0);"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></a>
				</div>
			</div>
			<ul id="report-item-list">
				<li class="report-item">
					<div class="report-item-flexrow report-item-header">
						<div class="report-item-user">
							<div class="report-item-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
						</div>
						<div class="report-item-details">
							<a href="javascript:void(0);" class="report-item-url icon-globe">http://test/test.test?test=testtest/test.test?test=testtest/test.test?test=testtest/test.test?test=test</a>
							<div class="report-item-date icon-calendar">2015-02-03 12:34:56</div>
						</div>
					</div>
					<div class="report-item-flexrow report-item-content">
						<p class="report-item-text">Testing text testing text Testing text testing text Testing text testing text Testing text testing text Testing text testing text Testing text testing text Testing text testing text</p>
						<div class="report-item-screenshots">
							<a href="javascript:void(0);" class="report-item-screenshot"><img src="screenshots/screenshot-2jyp5p1j46yr2j4i-1451029158-2013-09-01 17.14.14.jpg" /></a>
							<a href="javascript:void(0);" class="report-item-screenshot"><img src="screenshots/screenshot-2jyp5p1j46yr2j4i-1451029158-2013-09-01 17.14.14.jpg" /></a>
						</div>
					</div>
					<div class="report-item-flexrow report-item-meta">
						<a href="javascript:void(0);" class="report-item-comments-link icon-chat">Comments <span class="report-item-comment-count">2</span> <i class="icon-right-dir"></i></a>
						<div class="report-item-assignees icon-user-secret">
							<a href="javascript:void(0);" class="report-item-assignee">
								<div class="report-item-assignee-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /><i class="icon-user-times"></i></div>
							</a>
							<a href="javascript:void(0);" class="report-item-assignee">
								<div class="report-item-assignee-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /><i class="icon-user-times"></i></div>
							</a>
							<a href="javascript:void(0);" class="report-item-assignee-add"><i class="icon-user-plus"></i></a>
						</div>
						<a href="javascript:void(0);" class="report-item-state"><i class="icon-clock"></i></a>
					</div>
					<div class="report-item-row report-item-comments">
						<ul class="comment-item-list">
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world</p></div>
							</li>
							<li class="comment-item comment-owner">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world to you too!</p></div>
							</li>
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la</p></div>
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world</p></div>
							</li>
							<li class="comment-item comment-owner">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world to you too!</p></div>
							</li>
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la</p></div>
							</li>
						</ul>
						<div class="comment-reply">
							<input type="text" class="comment-reply-input" placeholder="Your comment..." />
							<a href="javascript:void(0);" class="comment-reply-button icon-reply">Reply</a>
						</div>
					</div>
				</li>
				<li class="report-item">
					<div class="report-item-flexrow report-item-header">
						<div class="report-item-user">
							<div class="report-item-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
						</div>
						<div class="report-item-details">
							<a href="javascript:void(0);" class="report-item-url icon-globe">http://test/test.test?test=testtest/test.test?test=testtest/test.test?test=testtest/test.test?test=test</a>
							<div class="report-item-date icon-calendar">2015-02-03 12:34:56</div>
						</div>
					</div>
					<div class="report-item-flexrow report-item-content">
						<p class="report-item-text">Testing text testing text Testing text testing text Testing text testing text Testing text testing text Testing text testing text Testing text testing text Testing text testing text</p>
						<div class="report-item-screenshots">
							<a href="javascript:void(0);" class="report-item-screenshot"><img src="screenshots/screenshot-2jyp5p1j46yr2j4i-1451029158-2013-09-01 17.14.14.jpg" /></a>
							<a href="javascript:void(0);" class="report-item-screenshot"><img src="screenshots/screenshot-2jyp5p1j46yr2j4i-1451029158-2013-09-01 17.14.14.jpg" /></a>
						</div>
					</div>
					<div class="report-item-flexrow report-item-meta">
						<a href="javascript:void(0);" class="report-item-comments-link icon-chat">Comments <span class="report-item-comment-count">2</span> <i class="icon-right-dir"></i></a>
						<div class="report-item-assignees icon-user-secret">
							<a href="javascript:void(0);" class="report-item-assignee">
								<div class="report-item-assignee-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /><i class="icon-user-times"></i></div>
							</a>
							<a href="javascript:void(0);" class="report-item-assignee">
								<div class="report-item-assignee-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /><i class="icon-user-times"></i></div>
							</a>
							<a href="javascript:void(0);" class="report-item-assignee-add"><i class="icon-user-plus"></i></a>
						</div>
						<a href="javascript:void(0);" class="report-item-state"><i class="icon-clock"></i></a>
					</div>
					<div class="report-item-row report-item-comments">
						<ul class="comment-item-list">
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world</p></div>
							</li>
							<li class="comment-item comment-owner">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world to you too!</p></div>
							</li>
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la</p></div>
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world</p></div>
							</li>
							<li class="comment-item comment-owner">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world to you too!</p></div>
							</li>
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la</p></div>
							</li>
						</ul>
						<div class="comment-reply">
							<input type="text" class="comment-reply-input" placeholder="Your comment..." />
							<a href="javascript:void(0);" class="comment-reply-button icon-reply">Reply</a>
						</div>
					</div>
				</li>
				<li class="report-item">
					<div class="report-item-flexrow report-item-header">
						<div class="report-item-user">
							<div class="report-item-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
						</div>
						<div class="report-item-details">
							<a href="javascript:void(0);" class="report-item-url icon-globe">http://test/test.test?test=testtest/test.test?test=testtest/test.test?test=testtest/test.test?test=test</a>
							<div class="report-item-date icon-calendar">2015-02-03 12:34:56</div>
						</div>
					</div>
					<div class="report-item-flexrow report-item-content">
						<p class="report-item-text">Testing text testing text Testing text testing text Testing text testing text Testing text testing text Testing text testing text Testing text testing text Testing text testing text</p>
						<div class="report-item-screenshots">
							<a href="javascript:void(0);" class="report-item-screenshot"><img src="screenshots/screenshot-2jyp5p1j46yr2j4i-1451029158-2013-09-01 17.14.14.jpg" /></a>
							<a href="javascript:void(0);" class="report-item-screenshot"><img src="screenshots/screenshot-2jyp5p1j46yr2j4i-1451029158-2013-09-01 17.14.14.jpg" /></a>
						</div>
					</div>
					<div class="report-item-flexrow report-item-meta">
						<a href="javascript:void(0);" class="report-item-comments-link icon-chat">Comments <span class="report-item-comment-count">2</span> <i class="icon-right-dir"></i></a>
						<div class="report-item-assignees icon-user-secret">
							<a href="javascript:void(0);" class="report-item-assignee">
								<div class="report-item-assignee-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /><i class="icon-user-times"></i></div>
							</a>
							<a href="javascript:void(0);" class="report-item-assignee">
								<div class="report-item-assignee-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /><i class="icon-user-times"></i></div>
							</a>
							<a href="javascript:void(0);" class="report-item-assignee-add"><i class="icon-user-plus"></i></a>
						</div>
						<a href="javascript:void(0);" class="report-item-state"><i class="icon-clock"></i></a>
					</div>
					<div class="report-item-row report-item-comments">
						<ul class="comment-item-list">
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world</p></div>
							</li>
							<li class="comment-item comment-owner">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world to you too!</p></div>
							</li>
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la</p></div>
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world</p></div>
							</li>
							<li class="comment-item comment-owner">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Hello world to you too!</p></div>
							</li>
							<li class="comment-item">
								<div class="comment-user-image"><img src="https://lh4.googleusercontent.com/-RLuDMRx_XDY/AAAAAAAAAAI/AAAAAAAAAA8/83RkyfXwqTg/s96-c/photo.jpg" /></div>
								<div class="comment-user-text"><p>Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la Blablabl abl abl bla blabl balb labl balb la</p></div>
							</li>
						</ul>
						<div class="comment-reply">
							<input type="text" class="comment-reply-input" placeholder="Your comment..." />
							<a href="javascript:void(0);" class="comment-reply-button icon-reply">Reply</a>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>

<script type="text/html" id="report-screenshot-item">
<div id="{{id}}" class="report-screenshot report-screenshot-item">
	<img src="{{img}}" />
	<button type="button" class="report-screenshot-close"><i class="icon-cancel"></i></button>
</div>
</script>
<?php } else { ?>
<div id="report-login-frame">
	<div id="report-login-error">
		<p><i class="icon-attention"></i></p>
		<p>Uh oh. There was an error.</p>
		<p id="report-login-error-text">Be sure to sign in with your Compass email.</p>
	</div>

	<div id="report-login-authenticating">
		<p class="icon-clock">Authenticating</p>
	</div>

	<button type="button" id="report-login-button" class="icon-compass">Sign in with your Compass email</button>
</div>
<?php } ?>
