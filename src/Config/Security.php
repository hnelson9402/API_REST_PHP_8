<?php

namespace App\Config;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Bulletproof\Image;

class Security {

    private static $jwt_data;//Propiedad para guardar los datos decodificados del JWT 

    /************Acceder a la secret key del JWT*************/
    final public static function secretKey()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__,2));
        $dotenv->load();
        return $_ENV['SECRET_KEY'];
    }

    /********Encriptar la contraseña del usuario***********/
    final public static function createPassword(string $pw)
    {
        $pass = password_hash($pw,PASSWORD_DEFAULT);
        return $pass;
    }

    /*****************Validar que las contraseñas coincidan****************/
    final public static function validatePassword(string $pw , string $pwh)
    {
        if (password_verify($pw,$pwh)) {
            return true;
        } else {
            error_log('La contraseña es incorrecta');
            return false;
        }       
    }

    /************************Crear JWT***********************************/
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

    /*********************Validar que el JWT sea correcto********************/
    final public static function validateTokenJwt(array $token , string $key)
    {
        if (!isset($token['Authorization'])) {
            die(json_encode(ResponseHttp::status400('El token de acceso en requerido')));            
            exit;
        }

        try {
            $jwt = explode(" " ,$token['Authorization']);
            $data = JWT::decode($jwt[1],$key,array('HS256'));
            self::$jwt_data = $data;
            return $data;
            exit;
        } catch (\Exception $e) {
            error_log('Token invalido o expiro');
            die(json_encode(ResponseHttp::status401('Token invalido o expirado')));
        }
    }

    /***************Devolver los datos del JWT decodificados****************/
    final public static function getDataJwt()
    {
        $jwt_decoded_array = json_decode(json_encode(self::$jwt_data),true);
        return $jwt_decoded_array['data'];
        exit;
    }

    /***********Subir Imagen al servidor**************/
    final public static function uploadImage($file,$name)
    {
        $file = new Image($file);
 
        $file->setMime(array('png','jpg','jpeg'));//formatos admitidos
        $file->setSize(10000,500000);//Tamaño admitidos es Bytes
        $file->setDimension(200,200);//Dimensiones admitidas en Pixeles
        $file->setLocation('public/Images');//Ubicación de la carpeta

        if ($file[$name]) {
            $upload = $file->upload();            
            if ($upload) {
                $imgUrl = UrlBase::urlBase .'/public/Images/'. $upload->getName().'.'.$upload->getMime();
                return $imgUrl;               
            } else {
                die(json_encode(ResponseHttp::status400($file->getError())));               
            }
        }
    }
}