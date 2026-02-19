<?php

namespace App\Services;

class Statistics
{
    protected $connection;
    protected $table;
    protected $secondTable;

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
