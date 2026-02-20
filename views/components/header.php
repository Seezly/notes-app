<header class="relative after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-white"><?= isset($title) ? $title : 'Dashboard' ?></h1>
        <?php if (getURI() === '/dashboard' && $data) : ?>
            <button command="show-modal" commandfor="dialog" class="bg-purple-900 hover:bg-purple-700 text-white text-xl px-4 py-2 rounded transition duration-200 cursor-pointer">Add Note</button>
        <?php endif; ?>
    </div>
</header>