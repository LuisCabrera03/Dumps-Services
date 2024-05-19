<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Obtener el ID de usuario de la cookie
$id_usuario = isset($_COOKIE['usuario_id']) ? $_COOKIE['usuario_id'] : null;

if ($id_usuario) {
    // Consulta para verificar si el usuario ya ha llenado su perfil de operario
    $sql_verificar_perfil = "SELECT COUNT(*) AS total FROM operarios WHERE id_usuario = $id_usuario";
    $resultado_verificar_perfil = mysqli_query($conn, $sql_verificar_perfil);

    if ($resultado_verificar_perfil) {
        $fila_verificar_perfil = mysqli_fetch_assoc($resultado_verificar_perfil);
        $total_perfiles = $fila_verificar_perfil['total'];

        // Verificar si el usuario tiene un perfil de operario
        if ($total_perfiles > 0) {
            // El usuario tiene un perfil de operario, continuar con la consulta del perfil
            $sql_perfil = "SELECT usuarios.*, operarios.*, usuarios.correo AS email
                FROM usuarios 
                LEFT JOIN operarios ON usuarios.id = operarios.id_usuario 
                WHERE usuarios.id = $id_usuario";

            $resultado_perfil = mysqli_query($conn, $sql_perfil);

            if ($resultado_perfil) {
                // Verificar si hay datos
                if (mysqli_num_rows($resultado_perfil) > 0) {
                    $perfil = mysqli_fetch_assoc($resultado_perfil);

                    // Incluir el archivo de encabezado con el botón de "Tus Solicitudes"
                    include 'header.php';

                    // Mostrar los datos del perfil de usuario
                    echo "<h2>Perfil de Usuario</h2>";
                    echo "<p>Nombre: " . $perfil['nombre'] . "</p>";
                    echo "<p>Correo electrónico: " . $perfil['email'] . "</p>";
                    echo "<p>Teléfono: " . $perfil['telefono'] . "</p>";

                    // Mostrar los datos del perfil de operario si existen
                    if (!empty($perfil['id_operario'])) {
                        echo "<h2>Perfil de Operario</h2>";
                        echo "<p>Marca del Motocarro: " . $perfil['marca_motocarro'] . "</p>";
                        echo "<p>Modelo del Motocarro: " . $perfil['modelo_motocarro'] . "</p>";
                        echo "<p>Año del Motocarro: " . $perfil['año_motocarro'] . "</p>";
                        echo "<p>Placa del Motocarro: " . $perfil['placa_motocarro'] . "</p>";
                    }

                    echo "<a href='solicitud_operario.php'>Tus Solicitudes</a>";

                    // Puedes agregar más campos y estilos según sea necesario
                } else {
                    // No se encontraron registros para este usuario
                    echo "No se encontraron registros para este usuario.";
                }
            } else {
                // Error al ejecutar la consulta del perfil
                echo "Error al obtener el perfil del usuario: " . mysqli_error($conn);
            }
        } else {
            // El usuario no tiene un perfil de operario, mostrar el formulario para llenar el perfil
            include 'header.php';
            echo <<<HTML
            <h2>Completa tu Perfil de Operario</h2>
            <form action="guardar_perfil_operario.php" method="post">
                <label for="marca_motocarro">Marca del Motocarro:</label>
                <input type="text" id="marca_motocarro" name="marca_motocarro" required><br><br>

                <label for="modelo_motocarro">Modelo del Motocarro:</label>
                <input type="text" id="modelo_motocarro" name="modelo_motocarro" required><br><br>

                <label for="año_motocarro">Año del Motocarro:</label>
                <input type="text" id="año_motocarro" name="año_motocarro" required><br><br>

                <label for="placa_motocarro">Placa del Motocarro:</label>
                <input type="text" id="placa_motocarro" name="placa_motocarro" required><br><br>

                <button type="submit">Guardar Perfil</button>
            </form>
HTML;
        }
    } else {
        // Error al ejecutar la consulta para verificar el perfil
        echo "Error al verificar el perfil del usuario: " . mysqli_error($conn);
    }

    include 'footer.php';
} else {
    // El usuario no está autenticado
    echo "Error: ID de usuario no disponible.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
