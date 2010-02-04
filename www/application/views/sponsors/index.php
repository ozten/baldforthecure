<h1>Official Sponsors</h1>
<p>A huge thanks to our sponsors</p>
<ul>
<?php foreach($sponsors as $sponsor) { ?>
        <li>
        <img src="/i/<?= $sponsor->flickr_id ?>.jpg" width="<?= $sponsor->width ?>"
                                             height="<?= $sponsor->height ?>" alt="<?= $sponsor->name ?>" /><br/>
        <?= $sponsor->url ?>
        </li>
<?php } ?>
</ul>