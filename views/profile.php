<?php

require_once asset('views/partials/head.php');
require_once asset('views/components/nav.php');
require_once asset('views/components/header.php');
?>

<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <form class="flex flex-col justify-center items-start gap-4 mb-8" action="/profile" method="POST">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <h2 class="text-gray-400 text-xl font-bold">Profile information</h2>
        <div>
            <label class="text-gray-400 font-medium" for="user_name">Name:</label>
            <input class="rounded-md py-1 px-2 ml-3" type="text" name="user_name" id="user_name" value="<?= $data['username'] ?>">
        </div>
        <div>
            <label class="text-gray-400 font-medium" for="email">Email:</label>
            <input class="rounded-md py-1 px-2 ml-3" type="email" name="email" id="email" value="<?= $data['email'] ?>">
        </div>
        <div>
            <label class="text-gray-400 font-medium" for="password">Password:</label>
            <input class="rounded-md py-1 px-2 ml-3" type="password" name="password" id="password">
        </div>
        <div>
            <label class="text-gray-400 font-medium" for="confirm_password">Confirm password:</label>
            <input class="rounded-md py-1 px-2 ml-3" type="password" name="confirm_password" id="confirm_password">
        </div>
        <div>
            <button class="rounded-md py-2 px-4 bg-gray-800 hover:bg-red-800 text-gray-200 transition duration-200">Cancel</button>
            <button class="rounded-md py-2 px-4 bg-indigo-900 hover:bg-indigo-800 text-gray-200 transition duration-200">Save</button>
        </div>
    </form>
    <hr>
    <form action="/profile" method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mt-8">
            <p class="text-sm text-gray-400">Please, be careful. This action can be permanent.</p>
            <button class="mt-2 rounded-md py-2 px-4 bg-red-900 hover:bg-red-800 text-gray-200 transition duration-200">Delete account</button>
        </div>
    </form>
</div>

<?php
require_once asset('views/partials/footer.php');
?>