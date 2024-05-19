<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Obtener el ID de solicitud y el mensaje del formulario
$id_solicitud = isset($_POST['id_solicitud']) ? $_POST['id_solicitud'] : null;
$mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : null;
$id_usuario = isset($_COOKIE['usuario_id']) ? $_COOKIE['usuario_id'] : null;

if ($id_solicitud && $mensaje && $id_usuario) {
    // Insertar el mensaje en la base de datos
    $sql_insertar = "INSERT INTO mensajes (id_solicitud, id_usuario, mensaje, fecha_envio) 
                     VALUES ('$id_solicitud', '$id_usuario', '$mensaje', NOW())";

    if (mysqli_query($conn, $sql_insertar)) {
        // Redirigir de nuevo al chat
        header("Location: chat.php?id_solicitud=$id_solicitud");
        exit;
    } else {
        echo "Error al guardar el mensaje: " . mysqli_error($conn);
    }
} else {
    echo "Error: ID de solicitud, mensaje o usuario no disponibles.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
