<?php

require_once asset('views/partials/head.php');
require_once asset('views/components/nav.php');
require_once asset('views/components/header.php');
require_once asset('views/components/pagination.php');
require_once asset('views/components/user_card.php');
require_once asset('views/components/modal.php');
?>

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <?php $data['users'] ? UserCard($data['users']) : "We don't have any users... yet." ?>
    <?php \App\Middlewares\Auth::isAdmin() ? RestoreModal('user') : DeleteModal('user'); ?>
    <?php isset($data['pagination']) ? Pagination($data['pagination']) : '' ?>
</div>

<?php
require_once asset('views/partials/footer.php');
?>