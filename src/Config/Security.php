<?php

namespace App\Config;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;

class Security {

    private static $jwt_data; 

    final public static function secretKey()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__,2));
        $dotenv->load();
        return $_ENV['SECRET_KEY'];
    }

    final public static function createPassword(string $pw)
    {
        $pass = password_hash($pw,PASSWORD_DEFAULT);
        return $pass;
    }

    final public static function validatePassword(string $pw , string $pwh)
    {
       if (password_verify($pw,$pwh)) {
           return true;
       } else {
           error_log('La contraseña es incorrecta');
           return false;
       }
       
    }

    final public static function createTokenJwt(string $key , array $data)
    {
         $payload = array (
             "iat" => time(),
             "exp" => time() + (60*60*6),
             "data" => $data
         );
         $jwt = JWT::encode($payload,$key);
         return $jwt;
    }

    final public static function validateTokenJwt(array $token , string $key)
    {
        if (!isset($token['authorization'])) {
            die(json_encode(ResponseHttp::status400('El token de acceso en requerido')));            
            exit;
        }

        try {
            $jwt = explode(" " ,$token['authorization']);
            $data = JWT::decode($jwt[1],$key,array('HS256'));
            self::$jwt_data = $data;
            return $data;
            exit;
        } catch (\Exception $e) {
            error_log('Token invalido o expiro');
            die(json_encode(ResponseHttp::status401('Token invalido o expirado')));
        }
    }

    final public static function getDataJwt()
    {
        $jwt_decoded_array = json_decode(json_encode(self::$jwt_data),true);
        return $jwt_decoded_array['data'];
        exit;
    }
}