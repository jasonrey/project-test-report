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
	'color50' => 'E0F7FA',
	'color100' => 'B2EBF2',
	'color200' => '80DEEA',
	'color300' => '4DD0E1',
	'color400' => '26C6DA',
	'color500' => '00BCD4',
	'color600' => '00ACC1',
	'color700' => '0097A7',
	'color800' => '00838F',
	'color900' => '006064'
)));
