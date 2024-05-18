<?php
// Iniciar sesión
session_start();

// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    // Si el usuario ya está autenticado, redirigirlo a la página correspondiente según su rol
    switch ($_SESSION['rol']) {
        case 'solicitante_transporte':
            header("Location: solicitante.php");
            exit();
        case 'operador_logistico':
            header("Location: operario.php");
            exit();
        case 'administrador':
            header("Location: admin/admin.php");
            exit();
        default:
            // En caso de que el rol no esté definido o sea incorrecto, mostrar mensaje de error
            $mensaje = "Rol de usuario no válido.";
    }
}

// Verificar si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado los datos de usuario y contraseña
    if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
        // Obtener los valores de usuario y contraseña del formulario
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        // Consulta para verificar las credenciales del usuario en la base de datos
        $sql = "SELECT * FROM usuarios WHERE correo = '$usuario' AND contrasena = '$contrasena'";
        $resultado = $conn->query($sql);

        // Verificar si se encontraron registros que coincidan con las credenciales
        if ($resultado->num_rows > 0) {
            // Obtener información del usuario
            $usuario_info = $resultado->fetch_assoc();

            // Guardar información del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario_info['id'];
            $_SESSION['rol'] = $usuario_info['rol'];

            // Crear cookie para recordar la sesión
            setcookie("usuario_id", $usuario_info['id'], time() + (86400 * 30), "/"); // 86400 segundos = 1 día

            // Redirigir según el rol del usuario
            switch ($usuario_info['rol']) {
                case 'solicitante_transporte':
                    header("Location: solicitante.php");
                    exit();
                case 'operador_logistico':
                    header("Location: operario.php");
                    exit();
                case 'administrador':
                    header("Location: admin/admin.php");
                    exit();
                default:
                    // En caso de que el rol no esté definido o sea incorrecto, mostrar mensaje de error
                    $mensaje = "Rol de usuario no válido.";
            }
        } else {
            // Las credenciales no son válidas, mostrar mensaje de error
            $mensaje = "Usuario o contraseña incorrectos";
        }
    } else {
        // Los datos de usuario y contraseña no se enviaron correctamente, mostrar mensaje de error
        $mensaje = "Por favor, ingresa usuario y contraseña";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Dump Services</title>
</head>
<body>

    
    <h2>Iniciar Sesión</h2>
    
    <?php
    // Mostrar mensaje de error si existe alguno
    if (isset($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="usuario">Usuario (Correo Electrónico):</label>
        <input type="email" id="usuario" name="usuario" required><br><br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br><br>
        <button type="submit">Ingresar</button>        
        <a href="createAcount.php">Crea tu cuenta</a>
    </form>
    
    <?php
    // Incluir el pie de página
    include 'footer.php';
    ?>
</body>
</html>
