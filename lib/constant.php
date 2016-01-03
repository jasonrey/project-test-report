<?php
!defined('SERVER_EXEC') && die('No access.');

define('USER_ROLE_REPORTER', 0);
define('USER_ROLE_FIXER', 1);
define('USER_ROLE_ADMIN', 2);

define('STATE_ALL', 'all');
define('STATE_PENDING', 0);
define('STATE_COMPLETED', 1);
define('STATE_REJECTED', 2);

define('STATE_NAME_0', 'pending');
define('STATE_NAME_1', 'completed');
define('STATE_NAME_2', 'rejected');

define('PROJECT_STATE_ALL', 'all');
define('PROJECT_STATE_ACTIVE', 1);
define('PROJECT_STATE_INACTIVE', 0);

define('USER_SETTINGS', serialize(array(
	'assign' => true,
	'completed' => true,
	'rejected' => true,
	'comment-owner' => true,
	'comment-participant' => true,
	'color' => 'cyan',
	'color50' => '',
	'color100' => '',
	'color200' => '',
	'color300' => '',
	'color400' => '',
	'color500' => '',
	'color600' => '',
	'color700' => '',
	'color800' => '',
	'color900' => ''
)));
