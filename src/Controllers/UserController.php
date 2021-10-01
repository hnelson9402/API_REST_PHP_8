<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\Models\UserModel;

class UserController {   

    private static $validate_rol = '/^[1,2,3]{1,1}$/';
    private static $validate_number = '/^[0-9]+$/';
    private static $validate_text = '/^[a-zA-Z]+$/';
    
    public function __construct(
        private string $method,
        private string $route,
        private array  $params,
        private $data,
        private $headers
    )
    {}  
    
    /************************************Login***********************************************/
    final public function getLogin(string $endPoint)
    {
        if ($this->method == 'get' && $endPoint == $this->route) {
            $email = strtolower($this->params[1]);
            $password = $this->params[2];

            if(empty($email) || empty($password)){  
                echo json_encode(ResponseHttp::status400('Todos los campos son necesarios'));
            }else if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
                echo json_encode(ResponseHttp::status400('Formato de correo invalido'));
            }else{
                UserModel::setEmail($email);
                UserModel::setPassword($password);
                echo json_encode(UserModel::login());           
            }  
        exit;
        }
    }

    /**********************Consultar todos los usuarios*********************/
    final public function getAll(string $endPoint)
    {
        if ($this->method == 'get' && $endPoint == $this->route) {
            Security::validateTokenJwt($this->headers,Security::secretKey());
            echo json_encode(UserModel::getAll());
            exit;
        }    
    }

    /**********************Consultar un usuario por DNI*******************************/
    final public function getUser(string $endPoint)
    {
        if ($this->method == 'get' && $endPoint == $this->route) {
            Security::validateTokenJwt($this->headers,Security::secretKey());
            $dni = $this->params[1];
            if (!isset($dni)) {
                echo json_encode(ResponseHttp::status400('El campo DNI es requerido'));
            }else if (!preg_match(self::$validate_number, $dni)) {
                echo json_encode(ResponseHttp::status400('El DNI soo admite números'));
            } else {
                UserModel::setDni($dni);
                echo json_encode(UserModel::getUser());
                exit;
            }  
            exit;
        }    
    }

    /***************************************Registrar usuario*************************************************/
    final public function postSave(string $endPoint)
    {
       if ($this->method == 'post' && $endPoint == $this->route) {
        Security::validateTokenJwt($this->headers,Security::secretKey()); 

        if (empty($this->data['name']) || empty($this->data['dni']) || empty($this->data['email']) || 
        empty($this->data['rol']) || empty($this->data['password']) || empty($this->data['confirmPassword'])) {
            echo json_encode(ResponseHttp::status400('Todos los campos son requeridos'));
        } else if (!preg_match(self::$validate_text, $this->data['name'])) {
            echo json_encode(ResponseHttp::status400('El campo nombre solo admite texto'));
        } else if (!preg_match(self::$validate_number, $this->data['dni'])) {
            echo json_encode(ResponseHttp::status400('El campo Dni solo admite números'));
        } else if (!filter_var($this->data['email'] , FILTER_VALIDATE_EMAIL)) {
            echo json_encode(ResponseHttp::status400('Formato de correo incorrecto'));
        } else if (!preg_match(self::$validate_rol, $this->data['rol'])) {
            echo json_encode(ResponseHttp::status400('Rol invalido'));
        } else if (strlen($this->data['password']) < 8 || strlen($this->data['confirmPassword']) < 8 ) {
            echo json_encode(ResponseHttp::status400('La contraseña debe tener un minimo de 8 caracteres'));
        } else if ($this->data['password'] !== $this->data['confirmPassword']) {
            echo json_encode(ResponseHttp::status400('Las contraseñas no coinciden'));
        } else {            
             new UserModel($this->data); 
             echo json_encode(UserModel::postSave());               
        }                
        exit;
       }
    }   

     /***************************************************Actualizar contraseña de usuario*********************************************/
     final public function patchPassword(string $endPoint)
     {        
         if ($this->method == 'patch' && $this->route == $endPoint){
             Security::validateTokenJwt($this->headers,Security::secretKey());
 
             $jwtUserData = Security::getDataJwt();                  
 
             if (empty($this->data['oldPassword']) || empty($this->data['newPassword']) || empty($this->data['confirmNewPassword'])) {
                 echo json_encode(ResponseHttp::status400('Todos los campos son requeridos'));
             } else if (!UserModel::validateUserPassword($jwtUserData['IDToken'],$this->data['oldPassword'])) {
                 echo json_encode(ResponseHttp::status400('La contraseña antigua no coincide'));
             } else if (strlen($this->data['newPassword']) < 8 || strlen($this->data['confirmNewPassword']) < 8 ) {
                 echo json_encode(ResponseHttp::status400('La contraseña debe tener un minimo de 8 caracteres'));
             }else if ($this->data['newPassword'] !== $this->data['confirmNewPassword']){
                 echo json_encode(ResponseHttp::status400('Las contraseñas no coinciden'));
             } else {
                 UserModel::setIDToken($jwtUserData['IDToken']);
                 UserModel::setPassword($this->data['newPassword']); 
                 echo json_encode(UserModel::patchPassword());
             } 
             exit;
         }        
     } 
     
    /****************************************Eliminar usuario******************************/
    final public function deleteUser(string $endPoint)
    {
        if ($this->method == 'delete' && $this->route == $endPoint){
            Security::validateTokenJwt($this->headers,Security::secretKey());

            if (empty($this->data['IDToken'])) {
                echo json_encode(ResponseHttp::status400('Todos los campos son requeridos'));
            } else {
                UserModel::setIDToken($this->data['IDToken']);
                echo json_encode(UserModel::deleteUser());
            }
        exit;
        }
    }
}
