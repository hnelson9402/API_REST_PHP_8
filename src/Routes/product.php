<?php

use App\Config\ResponseHttp;
use App\Controllers\ProductController;

$method  = strtolower($_SERVER['REQUEST_METHOD']);
$route   = $_GET['route'];
$params  = explode('/' , $route);
$data    = (empty($_POST)) ? json_decode(file_get_contents("php://input"),true) : $_POST;
$headers = getallheaders();

/*************Instancia del controlador de Producto**************/
$app = new ProductController($method,$route,$params,$data,$headers);

/***********************Rutas*********************/
$app->getAll('product/');
$app->postSave('product/');

/****************Error 404*****************/
echo json_encode(ResponseHttp::status404());