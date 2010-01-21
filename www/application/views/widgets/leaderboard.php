<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h3><?= $type ?> Leaderboard</h3>
<table cellpadding="5" cellspacing="0" border="1">
<thead><tr><th>Rank</th><th><?= $type ?></th><th><?= $total_type ?></th></tr></thead>
<tbody>
<?php for ($i=0; $i < count($leaders); $i++) { ?>
<tr><td><?= $i + 1 ?></td><td><?= $leaders[$i][0] ?></td><td><?= $leaders[$i][1] ?></td></tr>
<?php } ?>
</tbody>
</table>