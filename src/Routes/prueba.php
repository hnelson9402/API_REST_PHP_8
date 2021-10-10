<?php

use App\Config\Security;

$img = Security::uploadImage($_FILES,'prueba');

echo json_encode($img);