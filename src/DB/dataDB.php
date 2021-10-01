<?php

use App\DB\ConnectionDB;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,2));
$dotenv->load();

$data = array(
    'user' => $_ENV['USER'],
    'password' => $_ENV['PASSWORD'],
    'DB' => $_ENV['DB'],
    'IP' => $_ENV['IP'],
    'port' => $_ENV['PORT']
);

$host = 'mysql:host='.$data['IP'].';'.'port='.$data['port'].';'.'dbname='.$data['DB'];
ConnectionDB::from($host,$data['user'],$data['password']);