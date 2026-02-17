<?php

require_once asset('views/partials/head.php');
require_once asset('views/components/nav.php');

?>

<div>
    <?= StatsCard($stats) ?? 'Nothing here...' ?>?>
</div>

<?php
require_once asset('views/partials/footer.php');
?>