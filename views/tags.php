<?php

require_once asset('views/partials/head.php');
require_once asset('views/components/nav.php');
require_once asset('views/components/header.php');
require_once asset('views/components/pagination.php');
require_once asset('views/components/tag_card.php');
require_once asset('views/components/modal.php');
?>

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <?php $data['tags'] ? TagCard($data['tags']) : require_once asset('views/components/empty_state.php') ?>
    <?php require_once asset('views/components/add_tag.php') ?>
    <?php \App\Middlewares\Auth::isAdmin() ? RestoreModal('tag') : DeleteModal('tag'); ?>
    <?php isset($data['pagination']) ? Pagination($data['pagination']) : '' ?>
</div>

<?php
require_once asset('views/partials/footer.php');
?>