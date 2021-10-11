<?php

namespace App\DB;

use App\Config\ResponseHttp;

require __DIR__ . '/dataDB.php';

class ConnectionDB {

    private static $host = '';
    private static $user = '';
    private static $password = '';

    final public static function from($host,$user,$password)
    {
        self::$host     = $host;
        self::$user     = $user;
        self::$password = $password;
    }

    final public static function getConnection()
    {
        try {
            $opt = [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC];
            $dsn = new \PDO(self::$host,self::$user,self::$password,$opt);
            $dsn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            //error_log('conexion exitosa');
            return $dsn;
        } catch (\PDOException $p) {
            error_log('Error de conexion :' . $p);
            die(json_encode(ResponseHttp::status500()));
        }
    }

}