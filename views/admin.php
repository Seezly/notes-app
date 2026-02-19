<?php

require_once asset('views/partials/head.php');
require_once asset('views/components/nav.php');
require_once asset('views/components/stats_card.php');

?>

<div class="py-8 px-4 flex gap-x-4 justify-start items-center">
    <?= $stats ? StatsCard($stats) : 'Nothing here...' ?>
</div>

<?php
require_once asset('views/components/chart.php');
require_once asset('views/partials/footer.php');
?>