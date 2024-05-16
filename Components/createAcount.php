<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Variables para almacenar mensajes de éxito o error
$mensaje = '';

// Verificar si se ha enviado el formulario de creación de cuenta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado los datos necesarios
    if (isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['fecha_nacimiento']) && isset($_POST['tipo_documento']) && isset($_POST['numero_documento']) && isset($_POST['correo']) && isset($_POST['rol']) && isset($_POST['contrasena']) && isset($_POST['confirmar_contrasena'])) {
        // Obtener los valores del formulario
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $tipo_documento = $_POST['tipo_documento'];
        $numero_documento = $_POST['numero_documento'];
        $correo = $_POST['correo'];
        $rol = $_POST['rol'];
        $contrasena = $_POST['contrasena'];
        $confirmar_contrasena = $_POST['confirmar_contrasena'];

        // Verificar si las contraseñas coinciden
        if ($contrasena !== $confirmar_contrasena) {
            $mensaje = "Las contraseñas no coinciden.";
        } else {
            // Consulta para verificar si el usuario ya existe en la base de datos
            $sql_verificar_usuario = "SELECT id FROM usuarios WHERE correo = '$correo'";
            $resultado_verificar_usuario = $conn->query($sql_verificar_usuario);

            if ($resultado_verificar_usuario->num_rows > 0) {
                // El usuario ya existe, mostrar mensaje de error
                $mensaje = "Ya existe una cuenta asociada a este correo electrónico.";
            } else {
                // El usuario no existe, proceder con la creación de la cuenta
                $sql_insertar_usuario = "INSERT INTO usuarios (nombre, apellidos, fecha_nacimiento, tipo_documento, numero_documento, correo, rol, contrasena) VALUES ('$nombre', '$apellidos', '$fecha_nacimiento', '$tipo_documento', '$numero_documento', '$correo', '$rol', '$contrasena')";

                if ($conn->query($sql_insertar_usuario) === TRUE) {
                    // La cuenta se creó correctamente, redirigir a login.php
                    header("Location: login.php");
                    exit(); // Es importante incluir exit() después de header() para evitar que se ejecute más código
                } else {
                    // Error al crear la cuenta, mostrar mensaje de error
                    $mensaje = "Error al crear la cuenta: " . $conn->error;
                }
            }
        }
    } else {
        // No se enviaron todos los datos necesarios, mostrar mensaje de error
        $mensaje = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Dump Services</title>
</head>
<body>
    <?php
    // Incluir el encabezado
    include 'header.php';
    ?>
    
    <h2>Crear Cuenta</h2>

    <?php
    // Mostrar mensajes de éxito o error
    if (!empty($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nombre">Nombres:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required><br><br>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>
        <label for="tipo_documento">Tipo de Documento:</label>
        <select id="tipo_documento" name="tipo_documento" required>
            <option value="CC">Cédula de Ciudadanía</option>
            <option value="CE">Cédula de Extranjería</option>
        </select><br><br>
        <label for="numero_documento">Número de Documento:</label>
        <input type="text" id="numero_documento" name="numero_documento" required><br><br>
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required><br><br>
        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
            <option value="operador_logistico">Operador Logístico</option>
            <option value="solicitante_transporte">Solicitante de Transporte</option>
        </select><br><br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br><br>
        <label for="confirmar_contrasena">Confirmar Contraseña:</label>
        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required><br><br>
        <button type="submit">Crear Cuenta</button>
    </form>
    
    <?php
    // Incluir el pie de página
    include 'footer.php';
    ?>
</body>
</html>
