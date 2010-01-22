<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h1><?php echo html::specialchars($title) ?></h1>
<p>Hey there...</p>
<div class="sidebar">
    <div class="leaderboards">
        <div class="donation-count">
            <h2>$7,500</h2>
            <p>Donations</p>
        </div>
        <h3>Top Raisers</h3>
        <?= $people_leader ?>
        
        <?= $recruit_leader ?>
        <h3>Top Recruiters</h3>
        <?= $city_leader ?>
    </div><!-- /leaderboards -->
    <div class="leaderboards">
        <h2>Recent News</h2>
        <h3>Headline of a recent blog post</h3>
        <p>Some copy here.</p>
        <h3>Another Headline of a recent blog post</h3>
        <p>Some other copy here.</p>
        <a href="#">Subscribe</a>
    </div><!-- /leaderboards -->
</div>