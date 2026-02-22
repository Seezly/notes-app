<?php

function NoteCard($notes)
{
    $priority_class = [
        'low' => 'bg-green-100 text-green-800',
        'medium' => 'bg-yellow-100 text-yellow-800',
        'high' => 'bg-red-100 text-red-800',
    ];
    echo "<div class='flex justify-start flex-wrap items-center gap-[5%]'>";
    foreach ($notes as $note) {
        echo "
                <div class='bg-white w-full sm:max-w-[30%] rounded-lg shadow-md p-4 mb-4'>
                    <div class='flex items-center justify-between mb-2'>
                        <span class='text-sm text-gray-500'>" . (htmlspecialchars(date_format(date_create($note['date']), "m-d-Y")) ?? date('yyyy-mm-dd')) . "</span>
                        <h2 class='text-lg font-semibold'>" . (htmlspecialchars($note['name']) ?? '') . "</h2>
                        <span class='inline-block px-2 py-1 text-xs font-semibold rounded-full " . ($priority_class[htmlspecialchars($note['priority'])] ?? "bg-green-100 text-green-800") . "'> " . htmlspecialchars($note['priority']) . "</span>
                    </div>
                    <div class='mt-2'>
                        <p class='text-gray-700'>" . (htmlspecialchars($note['body']) ?? '') . "</p>
                    </div>
                    <div class='mt-4 flex space-x-2 relative'>
                    ";
        if (!App\Middlewares\Auth::isAdmin()) {
            echo "<button command='show-modal' commandfor='dialog' class='bg-blue-500 hover:bg-blue-700 text-white font-medium py-1 px-2 rounded' data-id='" . htmlspecialchars($note['id']) . "' data-action='edit'>Edit</button>
                        <button command='show-modal' commandfor='delete-note-confirm' class='bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded' data-id='" . htmlspecialchars($note['id']) . "'>Delete</button>
                    ";
        }
        if (App\Middlewares\Auth::isAdmin()) {
            if ($note['deleted_at'] !== null) {
                echo "<button command='show-modal' commandfor='restore-note-confirm' class='bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded' data-id='" . htmlspecialchars($note['id']) . "' data-token='" . $_SESSION['csrf_token'] . "'>Restore</button>";
            }
            echo "<span class='inline-block px-2 py-1 text-xs font-semibold rounded-full bg-indigo-500 text-white'>" . htmlspecialchars($note['username']) . " - " . htmlspecialchars($note['user_id']) . "</span>";
        }
        echo "
                        <span class='inline-block px-2 py-1 text-xs font-semibold rounded-full bg-indigo-500 text-white flex absolute bottom-0 right-0'>" . htmlspecialchars($note['tag']) . "</span>
                    </div>
                </div>";
    }
    echo "</div>";
}
