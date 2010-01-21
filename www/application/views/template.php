<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo html::specialchars($title) ?></title>

	<link rel="stylesheet" type="text/css" href="<?= url::site('/css/screen.css') ?>" />
	

</head>
<body>
    <div class="logo">Bald for the Cure</div>
	<div class="motto">Raising money for the families of cancer victims</div>
	<div id="account-area">Account area: Login / Create An Account via Twitter
    <?= $user_widget ?>
	</div>
	<h1><?php echo html::specialchars($title) ?></h1>
	<ul class="nav">
		<li><a href="<?= url::site("/") ?>">Home</a></li>
	    <li><a href="<?= url::site("/profile/index/ozten") ?>">Sample Profile</a></li>
		<li><a href="<?= url::site("/profiles/browse") ?>">Everybody</a></li>
	    <li><a href="#">About Bald for the Cure</a></li>
		<li><a href="#">Sponsors</a></li>
	    <li><a href="#">Press</a></li>
		<li><a href="#">Tweet</a></li>
	    
	</ul>
	<?php echo $content ?>

	<p class="copyright">
		Rendered in {execution_time} seconds, using {memory_usage} of memory<br />
		Copyright &copy;2007&mdash;2008 Kohana Team
	</p>

</body>
</html>