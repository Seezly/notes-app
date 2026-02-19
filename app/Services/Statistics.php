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
                    (SELECT COUNT(*) FROM $table WHERE created_at < DATE_SUB(NOW(), INTERVAL $first_period $period_unit) AND created_at >= DATE_SUB(NOW(), INTERVAL $second_period $period_unit)) AS {$table}_before_first_period)";

        $data = $this->connection->query($sql)->getAll();

        return [
            'title' => $title,
            'value' => $data[0]["total_{$table}"],
            'first_period_value' => $data[0]["{$table}_first_period"],
            'before_first_period_value' => $data[0]["{$table}_before_first_period"],
            'percentage' => ($data[0]["total_{$table}"] > 0) ? round((($data[0]["{$table}_first_period"] - $data[0]["{$table}_before_first_period"]) / $data[0]["total_{$table}"]) * 100, 2) : 0,
            'trend' => ($data[0]["{$table}_first_period"] >= $data[0]["{$table}_before_first_period"]) ? 'up' : 'down',
            'period' => $first_period,
            'period_unit' => $period_unit
        ];
    }

    public function getTableAvg($title, $table, $table_two, $first_period = '7', $second_period = '14', $period_unit = 'DAY')
    {
        $sql = "
            (SELECT
            (SELECT AVG({$table}_count) AS avg_{$table}
            FROM (
                SELECT COUNT(n.id) AS {$table}_count
                FROM $table_two u
                LEFT JOIN $table n ON u.id = n.user_id
                GROUP BY u.id
            ) AS sub) AS avg,
            (SELECT AVG({$table}_count) AS avg_{$table}_first_period
            FROM (
                SELECT COUNT(n.id) AS {$table}_count
                FROM $table_two u
                LEFT JOIN $table n ON u.id = n.user_id
                WHERE n.created_at >= DATE_SUB(NOW(), INTERVAL $first_period $period_unit)
                GROUP BY u.id
            ) AS sub) AS avg_first_period,
            (SELECT AVG({$table}_count) AS avg_{$table}_before_first_period
            FROM (
                SELECT COUNT(n.id) AS {$table}_count
                FROM $table_two u
                LEFT JOIN $table n ON u.id = n.user_id
                WHERE n.created_at < DATE_SUB(NOW(), INTERVAL $first_period $period_unit) AND n.created_at >= DATE_SUB(NOW(), INTERVAL $second_period $period_unit)
                GROUP BY u.id
            ) AS sub) AS avg_before_first_period)
        ";

        $data = $this->connection->query($sql)->getAll();

        return [
            'title' => $title,
            'value' => number_format($data[0]["avg"], 2) ?? null,
            'first_period_value' => $data[0]["avg_first_period"] ?? null,
            'before_first_period_value' => $data[0]["avg_before_first_period"] ?? null,
            'percentage' => ($data[0]["avg"] > 0) ? round((($data[0]["avg_first_period"] - $data[0]["avg_before_first_period"]) / $data[0]["avg"]) * 100, 2) : 0,
            'trend' => ($data[0]["avg_first_period"] >= $data[0]["avg_before_first_period"]) ? 'up' : 'down',
            'period' => $first_period,
            'period_unit' => $period_unit
        ];
    }

    public function getPercentageData($title, $table, $table_two, $first_period = '7', $second_period = '14', $period_unit = 'DAY')
    {
        $sql = "
            (SELECT
            (SELECT 
                (COUNT(DISTINCT n.user_id) * 100.0 / COUNT(DISTINCT u.id)) 
                AS percentage_{$table}_with_{$table_two}
            FROM {$table} u
            LEFT JOIN {$table_two} n ON u.id = n.user_id) AS percentage_{$table}_with_{$table_two},
            (SELECT 
                (COUNT(DISTINCT n.user_id) * 100.0 / COUNT(DISTINCT u.id)) 
                AS percentage_{$table}_with_{$table_two}
            FROM {$table} u
            LEFT JOIN {$table_two} n ON u.id = n.user_id
            WHERE n.created_at >= DATE_SUB(NOW(), INTERVAL $first_period $period_unit)
            GROUP BY u.id
            ) AS percentage_{$table}_with_{$table_two}_fp,
            (SELECT 
                (COUNT(DISTINCT n.user_id) * 100.0 / COUNT(DISTINCT u.id)) 
                AS percentage_{$table}_with_{$table_two}
            FROM {$table} u
            LEFT JOIN {$table_two} n ON u.id = n.user_id
            WHERE n.created_at < DATE_SUB(NOW(), INTERVAL $first_period $period_unit) AND n.created_at >= DATE_SUB(NOW(), INTERVAL $second_period $period_unit)
            GROUP BY u.id
            ) AS percentage_{$table}_with_{$table_two}_bfp
            )
        ";

        $data = $this->connection->query($sql)->getAll();

        return [
            'title' => $title,
            'value' => number_format($data[0]["percentage_{$table}_with_{$table_two}"], 2) ?? null,
            'first_period_value' => $data[0]["percentage_{$table}_with_{$table_two}_fp"] ?? null,
            'before_first_period_value' => $data[0]["percentage_{$table}_with_{$table_two}_bfp"] ?? null,
            'percentage' => ($data[0]["percentage_{$table}_with_{$table_two}"] > 0) ? round((($data[0]["percentage_{$table}_with_{$table_two}_fp"] - $data[0]["percentage_{$table}_with_{$table_two}_bfp"]) / $data[0]["avg"]) * 100, 2) : 0,
            'trend' => ($data[0]["percentage_{$table}_with_{$table_two}_fp"] >= $data[0]["percentage_{$table}_with_{$table_two}_bfp"]) ? 'up' : 'down',
            'period' => $first_period,
            'period_unit' => $period_unit
        ];
    }

    public function getChartData($table_one, $table_two, $column = 'created_at', $period = '30', $period_unit = 'DAY')
    {
        $tableOneSql = "
            SELECT COUNT(*) AS count, DATE($column) AS day FROM $table_one WHERE $column >= DATE_SUB(NOW(), INTERVAL $period $period_unit) GROUP BY day
            ";

        $tableTwoSql = "
            SELECT COUNT(*) AS count, DATE($column) AS day FROM $table_two WHERE $column >= DATE_SUB(NOW(), INTERVAL $period $period_unit) GROUP BY day
        ";

        $tableOneData = $this->connection->query($tableOneSql)->getAll();
        $tableTwoData = $this->connection->query($tableTwoSql)->getAll();

        $daysOne = isset($tableOneData[0]['day']) && is_array($tableOneData[0]['day']) ? $tableOneData[0]['day'] : [];
        $daysTwo = isset($tableTwoData[0]['day']) && is_array($tableTwoData[0]['day']) ? $tableTwoData[0]['day'] : [];
        $labels = array_merge($daysOne, $daysTwo);

        $chart = [
            'labels' => $labels,
            'title_one' => ucfirst($table_one),
            'title_two' => ucfirst($table_two),
            'dataTableOne' => coordinates($tableOneData),
            'dataTableTwo' => coordinates($tableTwoData),
        ];

        return $chart;
    }
}
