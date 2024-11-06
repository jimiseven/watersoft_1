<?php
// Datos de conexión
$host = 'localhost'; // Cambia esto si tu servidor no es localhost
$usuario = 'root'; // Reemplaza con tu usuario de MySQL
$contraseña = ''; // Reemplaza con tu contraseña de MySQL
$nombre_bd = 'waterinfo_2';

// Crear la conexión
$conexion = new mysqli($host, $usuario, $contraseña, $nombre_bd);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// echo "Conexión exitosa a la base de datos.";

// Cerrar la conexión
// $conexion->close();
?>
