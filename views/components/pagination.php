<?php

function Pagination($data)
{

    $i = 1;
    echo "<div class='absolute bottom-8 right-32 max-w-md mx-auto flex bg-white rounded-md overflow-hidden'>";
    while ($i <= $data) {
        echo "<a class='block text-gray-400 hover:text-gray-800 hover:bg-gray-200 py-2 px-4' href='" . getUri() . "?page={$i}" . "'>{$i}</a>";
        $i++;
    }
    echo "</div>";
}
