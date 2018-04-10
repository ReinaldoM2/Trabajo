<?php

//Definimos Los datos para conectarlos a la base de datos

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'reinaldo');
define('DB_PASSWORD', 'reinaldo123*');
define('DB_NAME', 'estudiantes');

// Intento de conexión a la base de datos

$link = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

//Revisamos Conexion

if ($link == false) {
	
	die("Error de conexion");
}

?>