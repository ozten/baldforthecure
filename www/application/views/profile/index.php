<h1><?= $user->username ?></h1>
<p><img src="<?= $user->avatar ?>" /> <div><?= $user->name ?></div>
from <?= $user->city ?></p>
<?php if (is_null($before)) { ?>
Please upload your before photo
<?php } else { ?>
<h2>Before</h2>
<img src="<?= $before->url ?>" width="<?= $before->width ?>" height="<?= $before->height ?>" alt="Before photo for <?= $user->name ?>" />
<?php } ?>

<?php if (is_null($after)) { ?>
After shaving your head, please upload a new photo.
<?php } else { ?>
<h2>After</h2>
<img src="<?= $after->url ?>" width="<?= $after->width ?>" height="<?= $after->height ?>" alt="After photo for <?= $user->name ?>" />
<?php } ?>