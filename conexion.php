<?php
// Datos de conexión a la base de datos
$servername = "193.203.166.204"; // Nombre del servidor
$username = "u295424300_Pablo"; 
$password = "w-^9t7rEx7N7"; // Contraseña por defecto de XAMPP
$database = "u295424300_cargaexpressdb"; // Nombre de la base de datos 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
