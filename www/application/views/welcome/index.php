<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h1><?php echo html::specialchars($title) ?></h1>
<ul class="updates">
<?php if (is_null($updates)) { ?>
    
<?php } else {
        foreach($updates as $update) {            
                ?>
            <li><?= $update->show() ?> <a href="<?= url::site('/profile/index/' . $update->username()) ?>"><?= $update->username() ?></a> <?= $update->action() ?> on <?= date('M, d h:m', strtotime($update->created)) ?></li>
<?php   }    
      }
?>
  
</ul>
<div class="sidebar">
    <div class="leaderboards">
        <div class="donation-count">
            <h2>$<?= $total_pledges ?></h2>
            <p>Donations</p>
        </div>
        <h3>Top Raisers</h3>
        <?= $people_leader ?>
        
        <?= $recruit_leader ?>
        
        <h3>Top Recruiters</h3>
        <?= $city_leader ?>
        <h3>Top User Cities</h3>
        <?= $user_city_leader ?>
        
    </div><!-- /leaderboards -->
    <div class="leaderboards">
        <div id="feeddiv"></div>
        <a id="blog-link" href="<?= url::site('/blog/') ?>">Read it all on the blog</a>
    </div><!-- /leaderboards -->
</div>