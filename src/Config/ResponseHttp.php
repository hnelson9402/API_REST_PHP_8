<?php

namespace App\Config;

class ResponseHttp {

    public static $message = array(
        'status' => '',
        'message' => ''
    );

    /*********************CORS Producción**********************/ 
    final public static function headerHttpPro($method,$origin)
    {
        if (!isset($origin)) {
            die(json_encode(ResponseHttp::status401('No tiene autorizacion para consumir esta API')));
        }

        $list = ['http://nibiru.test'];        

        if (in_array($origin,$list)){

            if ($method == 'OPTIONS') {
                header("Access-Control-Allow-Origin: $origin");
                header('Access-Control-Allow-Methods: GET,PUT,POST,PATCH,DELETE');
                header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization"); 
                exit(0);
            } else {
                header("Access-Control-Allow-Origin: $origin");
                header('Access-Control-Allow-Methods: GET,PUT,POST,PATCH,DELETE');
                header("Allow: GET, POST, OPTIONS, PUT, PATCH , DELETE");
                header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization"); 
                header('Content-Type: application/json'); 
            }
        } else {
            die(json_encode(ResponseHttp::status401('No tiene autorizacion para consumir esta API')));
        }       
    }

    /*********************CORS Desarrollo**********************/
    final public static function headerHttpDev($method)
    {
        if ($method == 'OPTIONS') {
            exit(0);
        }

        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET,PUT,POST,PATCH,DELETE');
        header("Allow: GET, POST, OPTIONS, PUT, PATCH , DELETE");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization"); 
        header('Content-Type: application/json'); 
    }

    public static function status200($res)
    {
        http_response_code(200);
        self::$message['status'] = 'ok';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status201(string $res = 'Recurso creado')
    {
        http_response_code(201);
        self::$message['status'] = 'ok';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status400(string $res = 'solicitud enviada incompleta o en formato incorrecto')
    {
        http_response_code(400);
        self::$message['status'] = 'error';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status401(string $res = 'No tiene privilegios para acceder al recurso solicitado')
    {
        http_response_code(401);
        self::$message['status'] = 'error';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status404(string $res = 'Parece que estas perdido por favor verifica la documentación')
    {
        http_response_code(404);
        self::$message['status'] = 'error';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status500(string $res = 'Error interno del servidor')
    {
        http_response_code(500);
        self::$message['status'] = 'error';
        self::$message['message'] = $res;
        return self::$message;
    }
}
