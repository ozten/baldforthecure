Pledge Your Support
<ol>
    <li>Record Your Pledge
        <!-- TODO on submit we should disable this form and maybe replace it with a thanks for donating -->
        <form action="<?= url::site('/donate/pledge') ?>" method="post" target="<?= $page_target ?>">
            <input type="hidden" name="nonce" value="<?= $nonce ?>" />
            <input type="hidden" name="shaver_user_id" value="<?= $shaver_user_id ?>" />
            <p><label for="pledge_amount">I pledge to donate</label>
                $<input type="text" name="pledge_amount" id="pledge_amount" value=""
                       size="4" />.00 Dollars</p>
            <p>(Optional) <label for="pledge_reason">I'd like for this to be in the name of</label>
                <input type="text" name="pledge_reason" id="pledge_reason" value="" /></p>
            <input type="submit" name="save" value="Save and Continue" />
        </form>
    </li>
    <li>Made Your Donation through Facebook Causes</li>
</ol>
<?php

?>