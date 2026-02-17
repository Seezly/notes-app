<?php

function StatsCard($data)
{
    echo "<div class='bg-white rounded-lg shadow-md p-4 mb-4'>
            <h2 class='text-lg font-semibold mb-2'>{$data['title']}</h2>
            <p class='text-gray-700'>{$data['value']}</p>
            <small class='text-gray-500'>{$data['percentage']}% {$data['trend']} in the last {$data['period']} {$data['period_unit']}</small>
        </div>";
}

function NoteCard($notes)
{
    $priority_class = [
        'low' => 'bg-green-100 text-green-800',
        'medium' => 'bg-yellow-100 text-yellow-800',
        'high' => 'bg-red-100 text-red-800',
    ];
    foreach ($notes as $note) {
        echo "<div class='bg-white rounded-lg shadow-md p-4 mb-4'>
                <div class='flex items-center justify-between mb-2'>
                    <span class='text-sm text-gray-500'>{$note['date']}</span>
                    <h2 class='text-lg font-semibold'>{$note['name']}</h2>
                    <span class='inline-block px-2 py-1 text-xs font-semibold rounded-full {$priority_class[$note['priority']]}'>{$note['priority']}</span>
                </div>
                <div class='mt-2'>
                    <p class='text-gray-700'>{$note['body']}</p>
                </div>
                <div class='mt-4 flex space-x-2'>
                    <button command='show-modal' commandfor='dialog' class='bg-blue-500 hover:bg-blue-700 text-white font-medium py-1 px-2 rounded' data-id='{$note['id']}' data-action='edit'>Edit</button>
                    <button command='show-modal' commandfor='delete-note-confirm' class='bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded' data-id='{$note['id']}'>Delete</button>
                </div>
            </div>";
    }
}
