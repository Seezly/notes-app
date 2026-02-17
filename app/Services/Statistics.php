<?php

namespace App\Services;

class Statistics
{
    protected $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getTableStats($title, $table, $first_period = '7', $second_period = '14', $period_unit = 'DAY')
    {
        $sql = "(SELECT 
                    (SELECT COUNT(*) FROM {$table}) AS total_{$table},
                    (SELECT COUNT(*) FROM $table WHERE created_at >= DATE_SUB(NOW(), INTERVAL $first_period $period_unit)) AS {$table}_first_period,
                    (SELECT COUNT(*) FROM $table WHERE created_at < DATE_SUB(NOW(), INTERVAL $first_period $period_unit) AND created_at >= DATE_SUB(NOW(), INTERVAL $second_period $period_unit)) AS {$table}_before_first_period";

        $data = $this->connection->query($sql)->getAll();
    }
}
