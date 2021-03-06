<?php
!defined('SERVER_EXEC') && die('No access.');
?>
<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo Config::getHTMLBase(); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, minimal-ui" />

	<?php if (!empty($meta)) { ?>
		<?php foreach ($meta as $m) { ?>
			<meta name="<?php echo $m['name']; ?>" content="<?php echo $m['content']; ?>" />
		<?php } ?>
	<?php } ?>

	<?php if (!empty($googlefont)) { ?>
		<?php if (is_array($googlefont)) { ?>
			<?php foreach ($googlefont as $font) { ?>
				<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=<?php echo $font; ?>" />
			<?php } ?>
		<?php } ?>

		<?php if (is_string($googlefont)) { ?>
			<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=<?php echo $googlefont; ?>" />
		<?php } ?>
	<?php } ?>

	<?php if (!empty($css)) { ?>
		<?php if (is_array($css)) { ?>
			<?php foreach ($css as $file) { ?>
				<link rel="stylesheet<?php if (Config::env() === 'development') { ?>/less<?php } ?>" type="text/css" href="<?php echo (strpos($file, 'http') === 0 ? '' : 'assets/' . (Config::env() === 'development' ? 'less' : 'css') . '/') . $file; ?><?php echo strpos($file, 'http') === 0 ? '' : (Config::env() === 'development' ? '.less' : '.css'); ?>" class="page-stylesheet" />
			<?php } ?>
		<?php } ?>

		<?php if (is_string($css)) { ?>
			<link rel="stylesheet<?php if (Config::env() === 'development') { ?>/less<?php } ?>" type="text/css" href="<?php echo (strpos($css, 'http') === 0 ? '' : 'assets/' . (Config::env() === 'development' ? 'less' : 'css') . '/') . $css; ?><?php echo strpos($file, 'http') === 0 ? '' : (Config::env() === 'development' ? '.less' : '.css'); ?>" class="page-stylesheet" />
		<?php } ?>
	<?php } ?>

	<?php if (Config::env() === 'development') { ?>
		<script type="text/javascript" src="assets/static/less.min.js"></script>
	<?php } ?>

	<script type="text/javascript" src="assets/static/jquery.min.js"></script>

	<?php if (!empty($js)) { ?>
		<?php if (is_array($js)) { ?>
			<?php foreach ($js as $file) { ?>
				<script type="text/javascript" src="<?php echo (strpos($file, 'http') === 0 ? '' : 'assets/js/') . $file . (strpos($file, 'http') === 0 ? '' : '.js'); ?>"></script>
			<?php } ?>
		<?php } ?>

		<?php if (is_string($js)) { ?>
			<script type="text/javascript" src="<?php echo (strpos($js, 'http') === 0 ? '' : 'assets/js/') . $js . (strpos($js, 'http') === 0 ? '' : '.js'); ?>"></script>
		<?php } ?>
	<?php } ?>

	<title><?php echo !empty($pagetitle) ? $pagetitle : Config::getPageTitle(); ?></title>
</head>
<body <?php if (Config::env() === 'development') { ?>data-development="1"<?php } ?>>
<?php echo $body; ?>
</body>
</html>
