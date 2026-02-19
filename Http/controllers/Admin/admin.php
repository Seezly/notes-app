<?php

use App\Services\Statistics;

$title = ucfirst('admin');

$noteStats = new Statistics($connection);
$userStats = new Statistics($connection);

$stats[] = $noteStats->getTableStats('Total Notes', 'notes');
$stats[] = $userStats->getTableStats('Total Users', 'users');
$stats[] = $userStats->getTableAvg('Notes per User', 'notes', 'users');
$stats[] = $userStats->getPercentageData('% Users With Notes', 'users', 'notes');

$chart_data = (new Statistics($connection))->getChartData('notes', 'users');

return view('admin', [
    'title' => $title,
    'stats' => $stats,
    'chart_data' => $chart_data
]);
