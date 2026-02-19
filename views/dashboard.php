<?php

require_once asset('views/partials/head.php');
require_once asset('views/components/nav.php');
require_once asset('views/components/header.php');
require_once asset('views/components/note_card.php');

?>

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <?php $notes ? NoteCard($notes) : require_once asset('views/components/empty_state.php') ?>
    <?php require_once asset('views/components/add_card.php') ?>
    <?php require_once asset('views/components/modal.php') ?>
</div>

<?php
require_once asset('views/partials/footer.php');
?>