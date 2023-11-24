<?php

namespace App\Helpers;
use Config;
use DB;

class DatabaseConnection
{
    public static function setConnection($connectionName,$params)
    {
        config(["database.connections.$connectionName" => [
            'driver' => $params->db_driver,
            'url' => '',
            'host' => $params->db_host,
            'port' => $params->db_port,
            'database' => $params->db_name,
            'username' => $params->db_user,
            'password' => $params->db_password,
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
            'db_rewrite_host' =>  $params->db_rewrite_host,
            'db_rewrite_search' => $params->db_rewrite_search,
            'db_rewrite_replace' => $params->db_rewrite_replace,
        ]]);

        return DB::connection($connectionName);
    }
}
