<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex flex-col items-center justify-center h-96 bg-gray-900 rounded-lg border-2 border-gray-700 border-dashed">
    <p class="text-white text-xl mb-6">No notes available.</p>

    <p class="text-white text-2xl mb-3 font-bold">Would you like to create a new note?</p>
    <button command="show-modal" commandfor="dialog" class="bg-purple-900 hover:bg-purple-700 text-white text-xl px-4 py-2 rounded transition duration-200 cursor-pointer">Add Note</button>
    <?php require_once asset('views/components/add_card.php') ?>
</div>