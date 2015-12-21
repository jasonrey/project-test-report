'use strict';

(function(ready) {
	document.readyState !== 'loading' ? ready() : document.addEventListener('DOMContentLoaded', ready);
})(function() {
	var $id = function(name) {
		return document.getElementById(name);
	};

	var $ajax = function(method, target, args) {
		var promise = new Promise(function(resolve, reject) {
			var request = new XMLHttpRequest();
			request.open(method.toUpperCase(), target);

			request.onload = function() {
				if (this.status >= 200 && this.status < 300) {
					var response = this.response;

					if (this.getResponseHeader('content-type') === 'application/json') {
						response = JSON.parse(this.response);
					}

					resolve(response);
				} else {
					reject(this.statusText);
				}
			};
			request.onerror = function() {
				reject(this.statusText);
			}

			if (method === 'post') {
				request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
				request.send(args);
			} else {
				request.send();
			}
		});

		return promise;
	};

	var $api = function(namespace) {

		var buildDataString = function(args) {
			if (args === undefined || args === null) {
				return '';
			}

			var parameters = [];

			for (var key in args) {
				parameters.push(encodeURIComponent(key) + '=' + encodeURIComponent(args[key]));
			}

			return parameters.join('&');
		}

		namespace = 'api/' + namespace

		return {
			get: function(args) {
				var dataString = buildDataString(args);

				if (dataString.length > 0) {
					namespace += (namespace.indexOf('?') >= 0 ? '&' : '?') + dataString;
				}

				return $ajax('get', namespace);
			},
			post: function(args) {
				return $ajax('post', namespace, buildDataString(args));
			}
		}
	};

	Element.prototype.on = function(name, fx) {
		return this.addEventListener(name, fx);
	};

	var $template = function(id, data) {
		var item = $id(id).innerHTML.replace(RegExp('\\{\\{(.+?)\\}\\}', 'g'), function(match, p1) {
			return data[p1] !== undefined ? data[p1] : '';
		});

		var wrapper = document.createElement('div');

		wrapper.innerHTML = item;

		return wrapper.firstElementChild;
	};

	var loginButton = $id('report-login-button');

	if (loginButton) {
		gapi.load('auth2', function() {
			var auth2 = gapi.auth2.init({
				scope: 'profile email'
			});

			var signIn = function() {
				auth2.signIn().then(function() {
					$id('report-login-frame').setAttribute('data-state', 'authenticating');

					var googleUser = auth2.currentUser.get();

					$api('user/authenticate').post({
						gid: googleUser.getId(),
						token: googleUser.getAuthResponse().id_token
					}).done(function(response) {
						if (response.state) {
							location.reload();
						} else {
							if (response.data !== undefined) {
								$id('report-login-error-text').innerText = document.createTextNode(response.data).textContent;
							}

							$id('report-login-frame').setAttribute('data-state', 'error');
						}
					});
				});
			};

			loginButton.on('click', signIn);

			signIn();
		});

		return;
	}

	$id('report-close-button').on('click', function() {
		parent.document.getElementById('project-report-embed').className = '';
		parent.document.getElementById('project-report-button').className = '';
	});

	var dragEventCounter = 0;

	$id('report-screenshots').on('dragenter', function(event) {
		event.stopPropagation();
		event.preventDefault();

		dragEventCounter++;

		$id('drop-file-mask').className = 'active';
	});

	$id('report-screenshots').on('dragleave', function(event) {
		event.stopPropagation();
		event.preventDefault();

		dragEventCounter--;

		if (dragEventCounter === 0) {
			$id('drop-file-mask').className = '';
		}
	});

	$id('report-screenshots').on('dragover', function(event) {
		event.stopPropagation();
		event.preventDefault();
	});

	$id('report-screenshots').on('drop', function(event) {
		event.stopPropagation();
		event.preventDefault();

		$id('drop-file-mask').className = '';
		dragEventCounter = 0;

		var files = event.dataTransfer.files;

		uploadFiles(files);
	});

	$id('report-screenshot-add').on('click', function(event) {
		$id('report-screenshot-file').click();
	});

	$id('report-screenshot-file').on('change', function(event) {
		uploadFiles(this.files).then(function() {
		});
	});

	var uploadFiles = function(files) {
		var promises = [];

		var uploadFile = function(file) {
			var promise = new Promise(function(resolve, reject) {
				var reader = new FileReader(),
					id = 'screenshot-' + Math.random().toString(36).substring(2);

				reader.onloadend = function(e) {
					var item = $template('report-screenshot-item', {
						id: id,
						img: e.target.result
					});

					$id('report-screenshots').appendChild(item);

					resolve();
				};

				reader.readAsDataURL(file);

				var formdata = new FormData();

				formdata.append('file', file);
			});

			return promise;
		};

		for (var i = 0; i < files.length; i++) {
			var file = files[i];

			if (file.type === 'image/png' || file.type === 'image/jpeg') {
				promises.push(uploadFile(file));
			}
		}

		return Promise.all(promises);
	}
});
