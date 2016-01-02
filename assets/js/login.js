'use strict';

$(function() {
	var auth2;

	var signIn = function() {
		auth2.signIn().then(function() {
			$$('#report-login-frame').attr('data-state', 'authenticating');

			var googleUser = auth2.currentUser.get();

			$api('user/authenticate', {
				gid: googleUser.getId(),
				token: googleUser.getAuthResponse().id_token
			}).done(function(response) {
				if (response.state) {
					location.reload();
				} else {
					if (response.data !== undefined) {
						$$('#report-login-error-text').text(response.data)
					}

					$$('#report-login-frame').attr('data-state', 'error');
				}
			});
		});
	};

	window.checkIdentity = function() {
		$$('#report-login-button').length && signIn();
	};

	if ($$('#report-login-button').length) {
		gapi.load('auth2', function() {
			auth2 = gapi.auth2.init({
				scope: 'profile email'
			});

			$$('#report-login-button').on('click', signIn);
		});
	}
});
