<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Consulta para obtener los datos del usuario
    $sql = "SELECT * FROM usuarios WHERE id = $userId";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if ($user && $user['rol'] === 'operador_logistico') {
        // Consulta para obtener los datos adicionales del operario logístico
        $sql_operario = "SELECT * FROM operarios WHERE id_usuario = $userId";
        $result_operario = $conn->query($sql_operario);
        $operario = $result_operario->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuario</title>
    <style>
        .container {
            width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2, h3 {
            text-align: center;
        }
        .detail {
            margin-bottom: 10px;
        }
        .password-container {
            display: flex;
            align-items: center;
        }
        .password-container input {
            border: none;
            background: none;
            outline: none;
        }
        .toggle-btn {
            margin-left: 10px;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
        .image-container img {
            width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleButton = document.getElementById("toggle-btn");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Ocultar";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Mostrar";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Detalles del Usuario</h2>
        <?php if ($user): ?>
            <div class="detail"><strong>ID:</strong> <?php echo $user['id']; ?></div>
            <div class="detail"><strong>Nombre:</strong> <?php echo $user['nombre']; ?></div>
            <div class="detail"><strong>Apellidos:</strong> <?php echo $user['apellidos']; ?></div>
            <div class="detail"><strong>Fecha de Nacimiento:</strong> <?php echo $user['fecha_nacimiento']; ?></div>
            <div class="detail"><strong>Tipo de Documento:</strong> <?php echo $user['tipo_documento']; ?></div>
            <div class="detail"><strong>Número de Documento:</strong> <?php echo $user['numero_documento']; ?></div>
            <div class="detail"><strong>Correo:</strong> <?php echo $user['correo']; ?></div>
            <div class="detail"><strong>Rol:</strong> <?php echo $user['rol']; ?></div>
            <div class="detail"><strong>Teléfono:</strong> <?php echo $user['telefono']; ?></div>
            <div class="detail password-container">
                <strong>Contraseña:</strong>
                <input type="password" id="password" value="<?php echo $user['contrasena']; ?>" readonly>
                <span id="toggle-btn" class="toggle-btn" onclick="togglePassword()">Mostrar</span>
            </div>
            <?php if ($user['rol'] === 'operador_logistico' && $operario): ?>
                <h3>Detalles del Operario Logístico</h3>
                <div class="detail"><strong>Marca del Motocarro:</strong> <?php echo $operario['marca_motocarro']; ?></div>
                <div class="detail"><strong>Modelo del Motocarro:</strong> <?php echo $operario['modelo_motocarro']; ?></div>
                <div class="detail"><strong>Año del Motocarro:</strong> <?php echo $operario['año_motocarro']; ?></div>
                <div class="detail"><strong>Placa del Motocarro:</strong> <?php echo $operario['placa_motocarro']; ?></div>
                <div class="detail"><strong>Dirección del Domicilio:</strong> <?php echo $operario['direccion_domicilio']; ?></div>
                <div class="detail"><strong>Certificado de Antecedentes Judiciales:</strong> 
                    <div class="image-container">
                        <img src="<?php echo $operario['certificado_antecedentes_judiciales']; ?>" alt="Certificado de Antecedentes Judiciales">
                    </div>
                </div>
                <div class="detail"><strong>Certificado de Seguridad Social:</strong> 
                    <div class="image-container">
                        <img src="<?php echo $operario['certificado_seguridad_social']; ?>" alt="Certificado de Seguridad Social">
                    </div>
                </div>
                <div class="detail"><strong>Licencia de Conducción:</strong> 
                    <div class="image-container">
                        <img src="<?php echo $operario['licencia_conduccion']; ?>" alt="Licencia de Conducción">
                    </div>
                </div>
                <div class="detail"><strong>Seguro del Vehículo:</strong> 
                    <div class="image-container">
                        <img src="<?php echo $operario['seguro_vehiculo']; ?>" alt="Seguro del Vehículo">
                    </div>
                </div>
                <div class="detail"><strong>Calificación:</strong> <?php echo $operario['calificacion']; ?></div>
                <div class="detail"><strong>Otros Detalles:</strong> <?php echo $operario['otros_detalles']; ?></div>
            <?php endif; ?>
        <?php else: ?>
            <p>No se encontró el usuario.</p>
        <?php endif; ?>
        <a href="admin_usuarios.php">Volver</a>
    </div>
</body>
</html>
