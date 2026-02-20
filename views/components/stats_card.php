<?php

function StatsCard($stats)
{
    foreach ($stats as $stat) {

        $units = strtolower($stat['period_unit']) . "s";

        echo
        "<div class='min-w-[20%] bg-white rounded-lg shadow-md p-4 mb-4'>
            <h2 class='text-lg font-semibold mb-2'>" . htmlspecialchars($stat['title']) . "</h2>
            <p class='text-gray-700'>" . htmlspecialchars($stat['value']) . "</p>
            <small class='text-gray-500'>" . htmlspecialchars($stat['percentage']) . "% " . htmlspecialchars($stat['trend']) . " in the last " . htmlspecialchars($stat['period']) . " " . htmlspecialchars($units) . "</small>
        </div>";
    }
}
