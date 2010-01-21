<?php foreach($users as $user) { ?>
<h4><?= $user->name ?></h4>
<a href="<?= url::site('/profile/index/' . $user->username) ?>"><img src="<?= $user->avatar ?>"  /></a>
<a href="<?= url::site('/profile/index/' . $user->username) ?>"><?= $user->username ?></a> from <?= $user->city ?> has raised $XXX dollars so far!
<?php } ?>