create database api

use api

create table if not exists usuario(
    ID_USUARIO int auto_increment primary key,
	nombre varchar(20) not null,    	
	dni varchar(50) not null unique,	
	correo varchar(30) not null unique,
	rol int not null,	
	password varchar(500) not null,
	IDToken varchar(500) not null,
	fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)