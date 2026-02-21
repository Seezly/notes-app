<?php

function TagCard($tags)
{
    $priority_class = [
        'low' => 'bg-green-100 text-green-800',
        'medium' => 'bg-yellow-100 text-yellow-800',
        'high' => 'bg-red-100 text-red-800',
    ];
    echo "<div class='flex justify-start flex-wrap items-center gap-[5%]'>";
    foreach ($tags as $tag) {
        echo "
                <div class='bg-white w-full sm:max-w-[15%] rounded-lg shadow-md p-4 mb-4'>
                    <div class='flex items-center justify-between mb-2'>
                        <h2 class='text-lg font-semibold'>" . (htmlspecialchars($tag['name']) ?? '') . "</h2>
                    </div>
                    <div class='mt-4 flex space-x-2'>
                        <button command='show-modal' commandfor='dialog' class='bg-blue-500 hover:bg-blue-700 text-white font-medium py-1 px-2 rounded' data-id='" . htmlspecialchars($tag['id']) . "' data-action='edit'>Edit</button>
                        <button command='show-modal' commandfor='delete-tag-confirm' class='bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded' data-id='" . htmlspecialchars($tag['id']) . "'>Delete</button>
                    </div>
                </div>";
    }
    echo "</div>";
}
