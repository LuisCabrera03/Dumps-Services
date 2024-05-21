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
        $telefono = $_POST['telefono'];

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
                $sql_insertar_usuario = "INSERT INTO usuarios (nombre, apellidos, fecha_nacimiento, tipo_documento, numero_documento, correo, rol, contrasena, telefono) VALUES ('$nombre', '$apellidos', '$fecha_nacimiento', '$tipo_documento', '$numero_documento', '$correo', '$rol', '$contrasena', '$telefono')";

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Variables CSS */
        :root {
            --primary-color: #00132B; /* Color primario */
            --secondary-color: #3B4149; /* Color secundario */
            --background-color: #f2f2f2; /* Color de fondo */
            --text-color: #333; /* Color de texto */
            --input-background: #fff; /* Color de fondo de input */
            --link-color: #064575; /* Color de enlaces */
            --font-family: 'Roboto', sans-serif; /* Fuente principal */
            --transition-speed: 0.3s; /* Velocidad de transición */
        }

        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; /* Para que el padding no afecte al tamaño total */
        }

        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Altura completa de la ventana */
            margin: 0;
            padding: 20px;
        }

        .container {
            background: var(--input-background);
            padding: 20px; /* Reducir padding para hacer el contenedor más pequeño */
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px; /* Reducir tamaño máximo del contenedor */
            animation: slideIn var(--transition-speed) ease-out;
            border-left: 5px solid var(--primary-color);
            border-right: 5px solid var(--secondary-color);
        }

        h2 {
            text-align: center;
            margin-bottom: 15px; /* Reducir margen inferior */
            color: var(--primary-color);
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        h2:after {
            content: "";
            width: 50px;
            height: 3px;
            background: var(--secondary-color);
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .form-group {
            margin-bottom: 15px; /* Reducir margen inferior */
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background: #f9f9f9;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 10px rgba(59, 65, 73, 0.2);
            background: #fff;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .form-group button:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .form-group button:active {
            transform: translateY(-1px);
        }

        .form-group p {
            margin-top: 10px;
            text-align: center;
            color: var(--primary-color);
            font-weight: bold;
        }

        /* Animaciones */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Crear Cuenta</h2>

        <?php
        // Mostrar mensajes de éxito o error
        if (!empty($mensaje)) {
            echo "<p>$mensaje</p>";
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="nombre">Nombres:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="tipo_documento">Tipo de Documento:</label>
                <select id="tipo_documento" name="tipo_documento" required>
                    <option value="CC">Cédula de Ciudadanía</option>
                    <option value="CE">Cédula de Extranjería</option>
                </select>
            </div>
            <div class="form-group">
                <label for="numero_documento">Número de Documento:</label>
                <input type="text" id="numero_documento" name="numero_documento" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <option value="operador_logistico">Operador Logístico</option>
                    <option value="solicitante_transporte">Solicitante de Transporte</option>
                </select>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <div class="form-group">
                <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
            </div>
            <div class="form-group">
                <button type="submit">Crear Cuenta</button>
            </div>
        </form>
    </div>
</body>
</html>