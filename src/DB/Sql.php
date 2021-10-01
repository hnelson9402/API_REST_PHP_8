<?php

namespace App\DB;

use App\Config\ResponseHttp;

class Sql extends ConnectionDB {

    public static function exists(string $request, string $condition , $param)
    {
       try {
           $con = self::getConnection();
           $query = $con->prepare($request);
           $query->execute([
               $condition => $param
           ]);
           $res = ($query->rowCount() == 0) ? false : true;
           return $res;
       } catch (\PDOException $e) {
           error_log('Sql::exists -> ' .$e);
           die(json_encode(ResponseHttp::status500()));
       }
    }
}