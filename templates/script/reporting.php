<?php
!defined('SERVER_EXEC') && die('No access.');
?>
'use strict';

(function(ready) {
	document.readyState !== 'loading' ? ready() : document.addEventListener('DOMContentLoaded', ready);
})(function() {
	var stylesheet = document.createElement('style');

	stylesheet.id = 'project-reporting-stylesheet';
	stylesheet.type = 'text/css';
	stylesheet.innerHTML = '' +
		'#project-report-button {' +
			'display: inline-block;' +
			'font-family: Roboto, Helvetica, Arial, sans-serif;' +
			'position: fixed;' +
			'bottom: 0;' +
			'right: 8px;' +
			'height: 32px;' +
			'line-height: 32px;' +
			'background-color: #0097a7;' +
			'font-size: 16px;' +
			'color: white;' +
			'font-weight: bold;' +
			'padding: 0 16px;' +
			'box-shadow: -1px -1px 5px 1px rgba(0, 0, 0, 0.2);' +
			'border-top-left-radius: 4px;' +
			'border-top-right-radius: 4px;' +
			'opacity: 0.7;' +
			'transition: opacity .2s;' +
			'-webkit-transition: opacity .2s;' +
		'}' +
		'#project-report-button:hover {' +
			'opacity: 1;' +
		'}' +
		'#project-report-button.hide {' +
			'opacity: 0;' +
		'}' +
		'#project-report-embed {' +
			'position: fixed;' +
			'top: 100%;' +
			'left: 0;' +
			'width: 100%;' +
			'height: 100%;' +
			'z-index: 999999;' +
			'opacity: 0;' +
			'transition: opacity .2s, transform 0s;' +
			'transition-delay: 0s, .2s;' +
		'}' +
		'#project-report-embed.active {' +
			'opacity: 1;' +
			'transform: translateY(-100%);' +
			'transition-delay: 0s, 0s;' +
		'}';

	document.head.appendChild(stylesheet);

	var iframe = document.createElement('iframe');

	iframe.id = 'project-report-embed';
	iframe.src = '<?php echo $iframepath; ?>';

	document.body.appendChild(iframe);

	var reportButton = document.createElement('a');

	reportButton.id = 'project-report-button';
	reportButton.href = 'javascript:void(0);';
	reportButton.innerHTML = 'Report';

	reportButton.addEventListener('click', function() {
		iframe.className = 'active';
		reportButton.className = 'hide';

		iframe.contentWindow.checkIdentity();
	});

	document.body.appendChild(reportButton);
});
