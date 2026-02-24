<?php

require_once asset('views/partials/head.php');
require_once asset('views/components/nav.php');
require_once asset('views/components/header.php');
require_once asset('views/components/note_card.php');
require_once asset('views/components/pagination.php');
require_once asset('views/components/modal.php');
?>

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-start rounded-md overflow-hidden mb-8">
        <?php require_once asset('views/components/search.php') ?>
        <?php require_once asset('views/components/filter.php') ?>
    </div>
    <?php $data['notes'] ? NoteCard($data['notes']) : require_once asset('views/components/empty_state.php') ?>
    <?php require_once asset('views/components/add_card.php') ?>
    <?php \App\Middlewares\Auth::isAdmin() ? RestoreModal('note') : DeleteModal('note'); ?>
    <?php isset($data['pagination']) ? Pagination($data['pagination']) : '' ?>
</div>

<?php
require_once asset('views/partials/footer.php');
?>