<?php

function Pagination($data)
{

    echo "<div class='absolute bottom-8 right-32 max-w-md mx-auto flex bg-white rounded-md overflow-hidden'>";

    if ($data['current_page'] > 1) {
        $prev = $data['current_page'] - 1;
        echo "<a href='?page=$prev' class='block text-gray-400 hover:text-gray-800 hover:bg-gray-200 py-2 px-4 transition duration-200'>&laquo;</a>";
    }

    if ($data['start_page'] > 1) {
        echo "<a href='?page=1' class='block text-gray-400 hover:text-gray-800 hover:bg-gray-200 py-2 px-4 transition duration-200'>1</a>";

        if ($data['start_page'] > 2) {
            echo "<span class='block text-gray-400 hover:text-gray-800 hover:bg-gray-200 py-2 px-4 transition duration-200'>...</span>";
        }
    }

    for ($i = $data['start_page']; $i <= $data['end_page']; $i++) {

        $active = $i == $data['current_page']
            ? "bg-indigo-500 text-white"
            : "";

        echo "<a href='?page=$i' class='block text-gray-400 hover:text-gray-800 hover:bg-gray-200 py-2 px-4 transition duration-200 $active'>$i</a>";
    }

    if ($data['end_page'] < $data['num_pages']) {

        if ($data['end_page'] < $data['num_pages'] - 1) {
            echo "<span class='block text-gray-400 hover:text-gray-800 hover:bg-gray-200 py-2 px-4 transition duration-200'>...</span>";
        }

        echo "<a href='?page={$data['num_pages']}' class='block text-gray-400 hover:text-gray-800 hover:bg-gray-200 py-2 px-4 transition duration-200'>{$data['num_pages']}</a>";
    }

    // Next Button
    if ($data['current_page'] < $data['num_pages']) {
        $next = $data['current_page'] + 1;
        echo "<a href='?page=$next' class='block text-gray-400 hover:text-gray-800 hover:bg-gray-200 py-2 px-4 transition duration-200'>&raquo;</a>";
    }
    echo "</div>";
}
