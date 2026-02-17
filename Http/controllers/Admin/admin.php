<?php

$title = ucfirst('admin');

$sql = "(SELECT 
            (SELECT COUNT(*) FROM notes) AS total_notes,
            (SELECT COUNT(*) FROM users) AS total_users,
            (SELECT COUNT(*) FROM notes WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)) AS notes_last_week,
            (SELECT COUNT(*) FROM notes WHERE created_at < DATE_SUB(NOW(), INTERVAL 7 DAY) AND created_at >= DATE_SUB(NOW(), INTERVAL 14 DAY)) AS notes_before_last_week,
            (SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)) AS users_last_week,
            (SELECT COUNT(*) FROM users WHERE created_at < DATE_SUB(NOW(), INTERVAL 7 DAY) AND created_at >= DATE_SUB(NOW(), INTERVAL 14 DAY)) AS users_before_last_week)";

$data = $connection->query($sql)->getAll();

$stats = [
    [
        'title' => 'Total Notes',
        'value' => $data[0]['total_notes'],
        'percentage' => ($data[0]['total_notes'] > 0) ? round((($data[0]['notes_last_week'] - $data[0]['notes_before_last_week']) / $data[0]['total_notes']) * 100, 2) : 0,
        'trend' => ($data[0]['notes_last_week'] >= $data[0]['notes_before_last_week']) ? 'up' : 'down',
        'period' => '7',
        'period_unit' => 'days'
    ],
    [
        'title' => 'Total Users',
        'value' => $data[0]['total_users'],
        'percentage' => ($data[0]['total_users'] > 0) ? round((($data[0]['users_last_week'] - $data[0]['users_before_last_week']) / $data[0]['total_users']) * 100, 2) : 0,
        'trend' => ($data[0]['users_last_week'] >= $data[0]['users_before_last_week']) ? 'up' : 'down',
        'period' => '7',
        'period_unit' => 'days'
    ],
];

$chart_data = [
    'labels' => ['Last Week', 'Before Last Week'],
    'notes' => [$data[0]['notes_last_week'], $data[0]['notes_before_last_week']],
    'users' => [$data[0]['users_last_week'], $data[0]['users_before_last_week']]
];

dd($stats);

return view('admin', [
    'title' => $title
]);
