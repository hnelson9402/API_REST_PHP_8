<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\Models\ProductModel;

class ProductController extends BaseController{   

    /**********************Consultar todos los productos*********************/
    final public function getAll(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            Security::validateTokenJwt(Security::secretKey());
            echo json_encode(ProductModel::getAll());
            exit;
        }    
    }

    /************************************Registrar Producto***********************************************/
    final public function postSave(string $endPoint)
    {
        if ($this->getMethod() == 'post' && $endPoint == $this->getRoute()) {
            Security::validateTokenJwt(Security::secretKey());
            
            if (empty($this->getParam()['name']) || empty($this->getParam()['description']) || empty($this->getParam()['stock']) || empty($_FILES['product'])) {
                echo json_encode(ResponseHttp::status400('Todos los campos son requeridos'));
            } else if(!preg_match(self::$validate_text,$this->getParam()['name'])) {
                echo json_encode(ResponseHttp::status400('El campo Nombre solo admite texto'));
            } else if(!preg_match(self::$validate_description,$this->getParam()['description'])) {
                echo json_encode(ResponseHttp::status400('El campo Descripción solo admite texto y un máximo de 30 caracteres'));
            } else if(!preg_match(self::$validate_stock,$this->getParam()['stock'])) {
                echo json_encode(ResponseHttp::status400('El campo Stock solo admite números'));
            } else {
                new ProductModel($this->getParam(),$_FILES);
                echo json_encode(ProductModel::postSave());
            }
            exit;
        }
    }

    /************************************Borrar Producto***********************************************/
    final public function delete(string $endPoint)
    {
        if ($this->getMethod() == 'delete' && $endPoint == $this->getRoute()) {
            Security::validateTokenJwt(Security::secretKey());
            
            if (empty($this->getParam()['name']) || empty($this->getParam()['IDtoken'])) {
                echo json_encode(ResponseHttp::status400('Todos los campos son requeridos'));
            } else {
                ProductModel::setImageName($this->getParam()['name']);
                ProductModel::setIDtoken($this->getParam()['IDtoken']);
                echo json_encode(ProductModel::delete());
            }
            exit;
        }
    }
}