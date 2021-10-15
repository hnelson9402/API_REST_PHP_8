<?php

use App\Config\ResponseHttp;
use App\Controllers\UserController;

/*************Parametros enviados por la URL*******************/
$params  = explode('/' ,$_GET['route']);

/*************Instancia del controlador de usuario**************/
$app = new UserController();

/*************Rutas***************/
$app->getAll('user/');
$app->getUser("user/{$params[1]}/");
$app->postSave('user/');
$app->patchPassword('user/password/');
$app->deleteUser('user/');

/****************Error 404*****************/
echo json_encode(ResponseHttp::status404());