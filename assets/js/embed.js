'use strict';

(function(ready) {
	document.readyState !== 'loading' ? ready() : document.addEventListener('DOMContentLoaded', ready);
})(function() {
	var $id = function(name) {
		return document.getElementById(name);
	};

	var $class = function(name) {
		return document.getElementsByClassName(name);
	};

	Element.prototype.on = function(name, fx) {
		return this.addEventListener(name, fx);
	};

	Element.prototype.parents = function(name) {
		var type,
			identifier = name;

		switch(name.slice(0, 1)) {
			case '#':
				type = 'id';
				identifier = name.slice(1);
			break;

			case '.':
				type = 'class';
				identifier = name.slice(1);
			break;

			default:
				type = 'tag';
			break;
		}

		var element = this;
		while (
			element && (
				(type === 'id' && element.id !== identifier) ||
				(type === 'class' && !element.classList.contains(identifier)) ||
				(type === 'tag' && element.tagName !== identifier.toUpperCase())
			)
		) {
			element = element.parentElement;
		}

		return element;
	};

	Element.prototype.remove = function() {
		this.parentElement.removeChild(this);
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

			if (args.constructor.name === 'FormData') {
				return args;
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

	var $template = function(id, data) {
		var item = $id(id).innerHTML.replace(RegExp('\\{\\{(.+?)\\}\\}', 'g'), function(match, p1) {
			return data[p1] !== undefined ? data[p1] : '';
		});

		return item;
	};

	$id('report-close-button').on('click', function() {
		parent.document.getElementById('project-report-embed').className = '';
		parent.document.getElementById('project-report-button').className = '';
	});

	var loginButton = $id('report-login-button');

	var auth2;

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

	window.checkIdentity = function() {
		loginButton && signIn();
	};

	if (loginButton) {
		gapi.load('auth2', function() {
			auth2 = gapi.auth2.init({
				scope: 'profile email'
			});

			loginButton.on('click', signIn);
		});

		return;
	};

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

		attachFiles(files);
	});

	$id('report-screenshots').on('click', function(event) {
		if (event.target.classList.contains('icon-cancel') || event.target.classList.contains('report-screenshot-close')) {
			var item = event.target.parents('.report-screenshot');

			delete attachedFiles[item.id];

			item.remove();
		}
	});

	$id('report-screenshot-add').on('click', function(event) {
		$id('report-screenshot-file').click();
	});

	$id('report-screenshot-file').on('change', function(event) {
		attachFiles(this.files);
	});

	$id('report-form').on('submit', function(event) {
		event.preventDefault();

		var report = this['report-text'].value,
			project = this['project'].value;

		$api('report/save').post({
			project: project,
			files: attachedFiles,
			report: report,
			location: parent.location.toString()
		});

		console.log(attachedFiles, this['report-text'].value, this['project'].value, parent.location);
	});

	var attachedFiles = {};

	var attachFiles = function(files) {
		var promises = [];

		var attachFile = function(file) {
			var promise = new Promise(function(resolve, reject) {
				var reader = new FileReader(),
					id = 'screenshot-' + Math.random().toString(36).substring(2);

				reader.onloadend = function(e) {
					var item = $template('report-screenshot-item', {
						id: id,
						img: e.target.result
					});

					$id('report-screenshots').insertAdjacentHTML('beforeend', item);

					attachedFiles[id] = file;

					resolve();
				};

				reader.readAsDataURL(file);
			});

			return promise;
		};

		for (var i = 0; i < files.length; i++) {
			var file = files[i];

			if (file.type === 'image/png' || file.type === 'image/jpeg') {
				promises.push(attachFile(file));
			}
		}

		return Promise.all(promises);
	};

	var resetForm = function() {
		attachedFiles = {};

		var items = $class('report-screenshot-item');

		while (items.length > 0) {
			items[0].parentNode.removeChild(items[0]);
		}
	};
});
