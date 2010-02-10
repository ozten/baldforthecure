<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo html::specialchars($title) ?></title>

	<link rel="stylesheet" type="text/css" href="<?= url::site('/css/screen.css') ?>" />
	

</head>
<body>
	<div class="page">
		<div class="header">
		    <div class="logo"><a href="<?= url::site("/") ?>"><img src="<?= url::site(Kohana::config('fundraiser.logo_small'))?>" width="300" height="229" alt="Bald for the Cure Logo" /></a></div>
			<ul id="header-nav" class="nav">
				<li><a href="#">Donate</a></li>
				<li><a href="/recruit/index">Recruit</a></li>
				<li><a href="/participate">Participate</a></li>
				<li><?= $user_widget ?></li>
	    
		<!--li><a href="<?= url::site("/blog") ?>">Blog</a></li>
		<li><a href="<?= url::site("/profiles/browse") ?>">Everybody</a></li>
	    <li><a href="#">About Bald for the Cure</a></li>
		<li><a href="#">Sponsors</a></li>
	    <li><a href="#">Press</a></li>
		<li><a href="#">Tweet</a></li-->
			</ul>
	
		<div class="motto"><?= Kohana::config('fundraiser.motto') ?></div>
	
	
			<ul class="page-nav">
				<li><a href="<?= url::site('/oauth/login') ?>">Count Me In</a></li>
				<li><a href="<?= url::site('/donate/user/' . $donate_shaver_user_id) ?>">Donate Now</a></li>
			</ul>
		</div><!-- /header -->
		<div class="content">
			<div id="errors">
				<?php
				if (isset($error_messages) && is_array($error_messages) && count($error_messages) > 0) { ?>
					<ol><?php
					
					foreach($error_messages as $error) { ?>
						<li><?= $error ?></li>
			<?php   }
					?></ol><p>Please wait a few minutes and try again. Sorry about that.</p>
		  <?php } ?>
			</div>
		    <?php echo $content ?>
			<br class="clearboth" />
		</div>
		<div class="footer">
			<p class="copyright">
			Rendered in {execution_time} seconds, using {memory_usage} of memory<br />
			Copyright &copy;2007&mdash;2008 Kohana Team
			</p>			
		</div><!-- /footer -->
	</div><!-- /page -->
<script src="/js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="/js/behaviors.js" type="text/javascript"></script>
</body>
</html>