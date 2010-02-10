<h1><?php echo html::specialchars($title) ?></h1>

<form id="participate" action="/participate/save" method="post">
	<p>After I raise the amount of $<input type="text" name="challenge_amount" class="amount" value="<?= $user->challenge_amount ? $user->challenge_amount : 500 ?>" />.00 USD, I will perform the following at the event <input type="text" name="challenge_event" value="<?= $user->challenge_event ? $user->challenge_event : "Bald for the Cure - SxSW" ?>">:
	</p>

	<ul>
	    <li class="participation_options"><input type="radio" name="challenge_option" value="shave" <?= !($user->challenge_option) || ($user->challenge_option == 'shave') ? 'CHECKED' : '' ?> /> shave my head </li>
	    <li class="participation_options"><input type="radio" name="challenge_option" value="haircut" <?= ($user->challenge_option) && ($user->challenge_option == 'haircut') ? 'CHECKED' : '' ?> /> cut my hair for <a href="http://locksoflove.org/">Locks of Love</a></li>
	    <li class="participation_options"><input type="radio" name="challenge_option" value="other" <?= ($user->challenge_option) && ($user->challenge_option == 'other') ? 'CHECKED' : '' ?> /> <input type="text" name="challenge_option_description" value="<?= $user->challenge_option_description ?>"/> &nbsp;<em>(fill in the blank)</em></li>
	</ul>

	<p>I am participating in Bald for the Cure in honor of <input type="text" name="challenge_honor" class="honor" value="<?= $user->challenge_honor ?>" />. (Optional)</p>
	
	<p><input type="submit" value="<?= auth::logged_in() ? "Participate" : "Authenticate Using Twitter" ?>" /></p>
</form>