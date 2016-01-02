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
