<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Obtener los datos del formulario
$id_operario = $_POST['id_operario'];
$direccion_acarreo = $_POST['direccion_acarreo'];
$detalles_acarreo = $_POST['detalles_acarreo'];

// Aquí puedes agregar lógica adicional, como guardar la solicitud en la base de datos
$sql_solicitud = "INSERT INTO solicitudes (id_operario, direccion_acarreo, detalles_acarreo) VALUES ('$id_operario', '$direccion_acarreo', '$detalles_acarreo')";

if (mysqli_query($conn, $sql_solicitud)) {
    echo "Solicitud de acarreo enviada correctamente.";
} else {
    echo "Error al enviar la solicitud de acarreo: " . mysqli_error($conn);
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
