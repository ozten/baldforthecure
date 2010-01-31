<h1><?= $user->username ?></h1>
<p><img src="<?= $user->avatar ?>" /> <div><?= $user->name ?></div>
from <?= $user->city ?></p>
<?php if ($current_users_profile) { ?>
<p><button id="repair-avatar-btn" >Update Profile Image</button> from Twitter.</p>
<?php } else { ?>
<p><a href="<?= url::site('/donate/user/' . $donate_shaver_user_id) ?>">Donate Now</a></p>
<?php } ?>

<div class="photo before">
<?php if (is_null($before)) { ?>
    <?php if ($current_users_profile) { ?>
Please upload your before photo:
<form action="<?= url::site('/photo/upload')?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="photo_type" value="<?= Photo_Model::$before_type ?>" />
<input type="file"   name="photo" />
<input type="submit" value="Upload" />
</form>
    <?php } /* if ($current_users_profile) */ ?>
<?php } else { ?>
<h2>Before</h2>
<a href="<?= $before->page ?>"><img src="<?= $before->url ?>" width="<?= $before->width ?>" height="<?= $before->height ?>" alt="Before photo for <?= $user->name ?>" /></a>
<?php } ?>
</div><!-- //photo before -->
<div class="photo after">
<?php if (is_null($after)) { ?>
    <?php if ($current_users_profile) { ?>
After shaving your head, please upload a new photo.
<form action="<?= url::site('/photo/upload')?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="photo_type" value="<?= Photo_Model::$after_type ?>" />
<input type="file"   name="photo" />
<input type="submit" value="Upload" />
</form>
    <?php } /* if ($current_users_profile) */ ?>
<?php } else { ?>
<h2>After</h2>
<a href="<?= $after->page ?>"><img src="<?= $after->url ?>" width="<?= $after->width ?>" height="<?= $after->height ?>" alt="After photo for <?= $user->name ?>" /></a>
<?php } ?>
</div> <!-- //photo after -->

<hr style="clear: both" />