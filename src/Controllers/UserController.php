<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\Models\UserModel;
use Rakit\Validation\Validator;

class UserController extends BaseController{   
    
    /************************************Login***********************************************/
    final public function getLogin(string $endPoint)
    { 
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            $email = strtolower($this->getAttribute()[1]);
            $password = $this->getAttribute()[2];

            if(empty($email) || empty($password)){  
                echo json_encode(ResponseHttp::status400('Todos los campos son necesarios'));
            }else if(!self::validateEmail($email)){
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
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            Security::validateTokenJwt(Security::secretKey());
            echo json_encode(UserModel::getAll());
            exit;
        }    
    }

    /**********************Consultar un usuario por DNI*******************************/
    final public function getUser(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            Security::validateTokenJwt(Security::secretKey());
            $dni = $this->getAttribute()[1];
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
       if ($this->getMethod() == 'post' && $endPoint == $this->getRoute()) {
       // Security::validateTokenJwt(Security::secretKey()); 

        $validator = new Validator;
        
        $validation = $validator->validate($this->getParam(), [
            'name'               => 'required|regex:/^[a-zA-Z ]+$/',
            'dni'                => 'required|numeric',
            'email'              => 'required|email',            
            'rol'                => 'required|numeric|min:1|regex:/^[12]+$/',
            'password'           => 'required|min:8',
            'confirmPassword'    => 'required|same:password'   
        ]);      

        if ($validation->fails()) {            
            $errors = $validation->errors();            	
            echo json_encode(ResponseHttp::status400($errors->all()[0]));
        } else {            
            new UserModel($this->getParam());
            echo json_encode(UserModel::postSave());
        }              
                          
        exit;
       }
    }   

    /***************************************************Actualizar contraseña de usuario*********************************************/
    final public function patchPassword(string $endPoint)
    {        
        if ($this->getMethod() == 'patch' && $this->getRoute() == $endPoint){            
            Security::validateTokenJwt(Security::secretKey());

            $jwtUserData = Security::getDataJwt();                  

            if (empty($this->getParam()['oldPassword']) || empty($this->getParam()['newPassword']) || empty($this->getParam()['confirmNewPassword'])) {
                echo json_encode(ResponseHttp::status400('Todos los campos son requeridos'));
            } else if (!UserModel::validateUserPassword($jwtUserData['IDToken'],$this->getParam()['oldPassword'])) {
                echo json_encode(ResponseHttp::status400('La contraseña antigua no coincide'));
            } else if (strlen($this->getParam()['newPassword']) < 8 || strlen($this->getParam()['confirmNewPassword']) < 8 ) {
                echo json_encode(ResponseHttp::status400('La contraseña debe tener un minimo de 8 caracteres'));
            }else if ($this->getParam()['newPassword'] !== $this->getParam()['confirmNewPassword']){
                echo json_encode(ResponseHttp::status400('Las contraseñas no coinciden'));
            } else {
                UserModel::setIDToken($jwtUserData['IDToken']);
                UserModel::setPassword($this->getParam()['newPassword']); 
                echo json_encode(UserModel::patchPassword());
            } 
            exit;
        }        
    } 
     
    /****************************************Eliminar usuario******************************/
    final public function deleteUser(string $endPoint)
    {
        if ($this->getMethod() == 'delete' && $this->getRoute() == $endPoint){
            Security::validateTokenJwt(Security::secretKey());

            if (empty($this->getParam()['IDToken'])) {
                echo json_encode(ResponseHttp::status400('Todos los campos son requeridos'));
            } else {
                UserModel::setIDToken($this->getParam()['IDToken']);
                echo json_encode(UserModel::deleteUser());
            }
        exit;
        }
    }
}