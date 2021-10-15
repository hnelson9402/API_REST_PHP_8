<?php

use App\Config\ResponseHttp;
use App\Controllers\UserController;

/*************Parametros enviados por la URL*******************/
$params  = explode('/' , $_GET['route']);

/*************Instancia del controlador de usuario**************/
$app = new UserController();

/***********************Rutas*********************/
$app->getLogin("auth/{$params[1]}/{$params[2]}/");

/****************Error 404*****************/
echo json_encode(ResponseHttp::status404());