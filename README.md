# Usage Manual

- For a project/front-end developer, step __#1__ should be all that you need to integrate __Project Test Report__ system in your website for user to test and submit reports.
- For a back-end developer, go through __#2__ and __#3__ to properly configure the application for front-end developers

## 1. Embed

Include this script the `<head>` section of your page

```
<script src="[host]/js/reporting?name=[project-name]"></script>
```

- `host` - Location of the `project-test-report` application
- `project-name` - The name of the target project

## 2. Configuration

- All the configurations are in `config.php`

### 2.1 Database

- `Config::$dbconfig['default']['production']`
	- Password needs to be base64 encoded

### 2.2 Google Sign-In

- `Config::$googleClientId`
	- Google API client ID
	- Only the key is needed, e.g.:
		- [client-id].apps.googleusercontent.com
- `Config::$googleAllowedDomain`
	- Sets the allowed Email address domain
	- Set to empty string to allow any domains

### 2.3 Slack Notification

- `Config::$slackApiToken`
	- Web API Token
	- Used to access Web API such as retrieving list of users
- `Config::$slackHookToken`
	- Incoming Web Hook token from Slack
	- Used to send notification to Slack
	- Only the key is needed, e.g.:
		- hooks.slack.com/services/[hook-token]

## 3. Initialise

### 3.1 Database

- Create all the necessary tables
	- GET `maintenance/initTables`

### 3.2 Slack Users

- Retrieve list of Slack Users in the team and store it in `slackusers` table
	- GET `maintenance/populateSlackUsers`
