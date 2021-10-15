<?php

use App\Config\ResponseHttp;
use App\Controllers\ProductController;

/*************Parametros enviados por la URL*******************/
$params  = explode('/' ,$_GET['route']);

/*************Instancia del controlador de Producto**************/
$app = new ProductController();

/***********************Rutas*********************/
$app->getAll('product/');
$app->postSave('product/');
$app->delete('product/');

/****************Error 404*****************/
echo json_encode(ResponseHttp::status404());