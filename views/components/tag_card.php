<?php

function TagCard($tags)
{
    echo "<div class='flex justify-start flex-wrap items-center gap-[5%]'>";
    foreach ($tags as $tag) {
        echo "
                <div class='bg-white w-full sm:max-w-[15%] rounded-lg shadow-md p-4 mb-4'>
                    <div class='flex items-center justify-between mb-2'>
                        <h2 class='text-lg font-semibold'>" . (htmlspecialchars($tag['name']) ?? '') . "</h2>
                    </div>
                    <div class='mt-4 flex space-x-2'>
                    ";
        if (!App\Middlewares\Auth::isAdmin()) {
            echo "<button command='show-modal' commandfor='dialog' class='bg-blue-500 hover:bg-blue-700 text-white font-medium py-1 px-2 rounded' data-id='" . htmlspecialchars($tag['id']) . "' data-action='edit'>Edit</button>
                        <button command='show-modal' commandfor='delete-tag-confirm' class='bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded' data-id='" . htmlspecialchars($tag['id']) . "'>Delete</button>
                    ";
        }
        if (App\Middlewares\Auth::isAdmin()) {
            if ($tag['deleted_at'] !== null) {
                echo "<button command='show-modal' commandfor='restore-tag-confirm' class='bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded' data-id='" . htmlspecialchars($tag['id']) . "' data-token='" . $_SESSION['csrf_token'] . "'>Restore</button>";
            }
            echo "<span class='inline-block px-2 py-1 text-xs font-semibold rounded-full bg-indigo-500 text-white'>" . htmlspecialchars($tag['username']) . " - " . htmlspecialchars($tag['user_id']) . "</span>";
        }
        echo "
                    </div>
                </div>";
    }
    echo "</div>";
}
