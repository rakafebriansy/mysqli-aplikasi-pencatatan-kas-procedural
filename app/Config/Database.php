<?php

function getConnection(): mysqli|bool
{
    $config = getConfig('test');
    $mysqli = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
    return $mysqli;
}
function getConfig(string $env): array|bool
{
    if($env == 'test') {
        return [
                'host' => 'localhost',
                'username' => 'root',
                'password' => '',
                'database' => 'aplikasi_kas'
            ];
        } else if ($env == 'prod') {
            return [
                'host' => '',
                'username' => '',
                'password' => '',
                'database' => 'aplikasi_kas'
            ];
    }
    return false;
}