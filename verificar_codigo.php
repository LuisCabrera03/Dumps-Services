<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $correo = $_POST['correo'];
    $nueva_contrasena = $_POST['nueva_contrasena'];  // No hashear la contraseña

    // Verificar si el código es válido y no ha expirado
    $sql_verificar_codigo = "SELECT * FROM restablecer_password WHERE correo = '$correo' AND codigo = '$codigo' AND expira > NOW()";
    $resultado_verificar_codigo = mysqli_query($conn, $sql_verificar_codigo);

    if (mysqli_num_rows($resultado_verificar_codigo) > 0) {
        // Actualizar la contraseña del usuario
        $sql_actualizar_contrasena = "UPDATE usuarios SET contrasena = '$nueva_contrasena' WHERE correo = '$correo'";
        if (mysqli_query($conn, $sql_actualizar_contrasena)) {
            // Eliminar el código usado de la tabla de restablecimiento
            $sql_eliminar_codigo = "DELETE FROM restablecer_password WHERE correo = '$correo' AND codigo = '$codigo'";
            mysqli_query($conn, $sql_eliminar_codigo);

            // Redirigir al usuario a la página de inicio de sesión
            header('Location: login.php');
            exit();
        } else {
            echo "Error al actualizar la contraseña: " . mysqli_error($conn);
        }
    } else {
        echo "Código inválido o expirado.";
    }
}
mysqli_close($conn);
?>
