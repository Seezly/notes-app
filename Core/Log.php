<?php

namespace Core;

class Log
{

    public static function create($connection, $action, $user_id, $ip_address, $endpoint)
    {
        $sql = "INSERT INTO logs (action, user_id, ip_address, endpoint) VALUES (:action, :user_id, :ip_address, :endpoint)";

        $args = [
            "action" => $action,
            "user_id" => $user_id,
            "ip_address" => $ip_address,
            "endpoint" => $endpoint
        ];

        $connection->insert($sql, $args);
    }
}
