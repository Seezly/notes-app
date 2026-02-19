<?php

function StatsCard($stats)
{
    foreach ($stats as $stat) {

        $stat['period_unit'] = strtolower($stat['period_unit']) . "s";

        echo
        "<div class='min-w-[20%] bg-white rounded-lg shadow-md p-4 mb-4'>
            <h2 class='text-lg font-semibold mb-2'>{$stat['title']}</h2>
            <p class='text-gray-700'>{$stat['value']}</p>
            <small class='text-gray-500'>{$stat['percentage']}% {$stat['trend']} in the last {$stat['period']} {$stat['period_unit']}</small>
        </div>";
    }
}
