<?php

namespace App\Models;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\DB\ConnectionDB;
use App\DB\Sql;

class ProductModel extends ConnectionDB{

    private static string $name;
    private static string $description;
    private static $stock;
    private static $file;
    private static string $url;
    private static string $imageName;
    private static string $IDtoken;    

    public function __construct(array $data, $file)
    {
        self::$name = $data['name'];
        self::$description = $data['description'];
        self::$stock = $data['stock'];
        self::$file = $file;
    }

    /************************Metodos Getter**************************/
    final public static function getName(){ return self::$name;}
    final public static function getDescription(){ return self::$description;}
    final public static function getStock(){ return self::$stock;}
    final public static function getFile(){ return self::$file;}
    final public static function getUrl(){ return self::$url;}
    final public static function getImageName(){ return self::$imageName;}
    final public static function getIDtoken(){ return self::$IDtoken;}

    /**********************************Metodos Setter***********************************/
    final public static function setName(string $name) { self::$name = $name;}
    final public static function setDescription(string $description) { self::$description = $description;}
    final public static function setStock(string $stock) { self::$stock = $stock;}
    final public static function setFile(string $file) { self::$file = $file;}
    final public static function setUrl(string $url) { self::$url = $url;} 
    final public static function setImageName(string $imageName) { self::$imageName = $imageName;}  
    final public static function setIDtoken(string $IDtoken) { self::$IDtoken = $IDtoken;}   

    /**************************Consultar todos los productos***************************/
    final public static function getAll()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT * FROM productos");
            $query->execute();
            $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $rs;
        } catch (\PDOException $e) {
            error_log("ProductModel::getAll -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
        }
    }
    
    /*********************Registrar Producto********************/
    final public static function postSave() 
    {
        if (Sql::exists("SELECT name FROM productos WHERE name = :name",":name",self::getName())) {  
            return ResponseHttp::status400('El Producto ya esta registrado');
        } else {
            try {
                $resImg = Security::uploadImage(self::getFile(),'product'); 
                self::setUrl($resImg['path']);
                self::setImageName($resImg['name']);
                self::setIDtoken(hash('md5',self::getName().self::getUrl()));

                $con = self::getConnection();
                $query = $con->prepare('INSERT INTO productos(name,description,stock,url,imageName,IDtoken) VALUES (:name,:description,:stock,:url,:imageName,:IDtoken)');
                $query->execute([
                    ':name'        => self::getName(),
                    ':description' => self::getDescription(),
                    ':stock'       => self::getStock(),
                    ':url'         => self::getUrl(),
                    ':imageName'   => self::getImageName(),
                    ':IDtoken'     => self::getIDtoken()
                ]); 
                
                if ($query->rowCount() > 0) {
                    return ResponseHttp::status200('Producto registrado');
                } else {
                    return ResponseHttp::status500('No se puede registrar el producto');
                }
            } catch (\PDOException $e) {
                error_log('ProductModel::postSave-> ' . $e);
                die(json_encode(ResponseHttp::status500('No se puede registrar el producto')));
            }  
        }    
    }

    /*******************************Eliminar producto**************************/
    final public static function delete()
    {
        try {
            $con   = self::getConnection();
            $query = $con->prepare("DELETE FROM productos WHERE IDToken = :IDToken");
            $query->execute([
                ':IDToken' => self::getIDToken()
            ]);

            if ($query->rowCount() > 0) {
                $name = self::getImageName();
                $imgLocal = unlink(__DIR__ . "/../../public/Images/$name");
                if ($imgLocal) {
                    return ResponseHttp::status200('Producto eliminado exitosamente');
                } else {
                    return ResponseHttp::status500('No se puede eliminar la imagen local');
                }                
            } else {
                return ResponseHttp::status500('No se puede eliminar el producto');
            }
        } catch (\PDOException $e) {
            error_log("ProductModel::delete -> " . $e);
            die(json_encode(ResponseHttp::status500('No se puede eliminar el producto')));
        }
    }
}