<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si el usuario ya ha llenado su perfil de operario
$id_usuario = $_COOKIE['usuario_id'];
$sql_verificar_perfil = "SELECT COUNT(*) AS total FROM operarios WHERE id_usuario = $id_usuario";
$resultado_verificar_perfil = mysqli_query($conn, $sql_verificar_perfil);

if ($resultado_verificar_perfil) {
    $fila = mysqli_fetch_assoc($resultado_verificar_perfil);
    $total_registros = $fila['total'];

    if ($total_registros > 0) {
        // El usuario ya ha llenado su perfil de operario, mostrar mensaje de bienvenida
        echo "¡Hola Operario! Bienvenido de nuevo.";
    } else {
        // El usuario no ha llenado su perfil de operario, mostrar el formulario
        include 'perfil_operario.php';
    }
} else {
    echo "Error al verificar el perfil del operario: " . mysqli_error($conn);
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
