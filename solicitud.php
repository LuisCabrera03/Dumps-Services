<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';
include 'header.php';

// Función para cancelar la solicitud
if (isset($_POST['cancelar'])) {
    $id_solicitud = $_POST['id_solicitud'];
    $sql_cancelar = "UPDATE solicitudes SET estado = 'Cancelado' WHERE id = $id_solicitud";
    if (mysqli_query($conn, $sql_cancelar)) {
        echo "Solicitud cancelada correctamente.";
    } else {
        echo "Error al cancelar la solicitud: " . mysqli_error($conn);
    }
}

// Función para marcar como entregado
if (isset($_POST['entregado'])) {
    $id_solicitud = $_POST['id_solicitud'];
    $sql_entregado = "UPDATE solicitudes SET estado = 'Entregado' WHERE id = $id_solicitud";
    if (mysqli_query($conn, $sql_entregado)) {
        echo "Solicitud marcada como entregada correctamente.";
    } else {
        echo "Error al marcar la solicitud como entregada: " . mysqli_error($conn);
    }
}

// Función para guardar la calificación
if (isset($_POST['submit_calificacion'])) {
    $id_solicitud = $_POST['id_solicitud'];
    $calificacion = $_POST['calificacion'];

    // Obtener el ID del operario asociado a la solicitud
    $sql_id_operario = "SELECT id_operario FROM solicitudes WHERE id = $id_solicitud";
    $resultado_id_operario = mysqli_query($conn, $sql_id_operario);
    $row = mysqli_fetch_assoc($resultado_id_operario);
    $id_operario = $row['id_operario'];

    // Obtener las calificaciones previas del operario
    $sql_calificaciones_previas = "SELECT calificacion FROM operarios WHERE id_operario = $id_operario";
    $resultado_calificaciones_previas = mysqli_query($conn, $sql_calificaciones_previas);

    $total_calificaciones = 0;
    $total_usuarios = 0;

    // Calcular el nuevo promedio
    while ($fila_calificacion = mysqli_fetch_assoc($resultado_calificaciones_previas)) {
        $total_calificaciones += $fila_calificacion['calificacion'];
        $total_usuarios++;
    }

    // Sumar la nueva calificación
    $total_calificaciones += $calificacion;
    $total_usuarios++;

    // Calcular el nuevo promedio
    $nuevo_promedio = $total_calificaciones / $total_usuarios;

    // Actualizar la calificación en la tabla de operarios
    $sql_guardar_calificacion = "UPDATE operarios SET calificacion = $nuevo_promedio WHERE id_operario = $id_operario";
    if (mysqli_query($conn, $sql_guardar_calificacion)) {
        echo "¡Gracias por tu calificación!";
    } else {
        echo "Error al guardar la calificación: " . mysqli_error($conn);
    }
}

// Consulta para obtener la información relevante de todas las solicitudes del solicitante actual
$id_solicitante = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : (isset($_COOKIE['usuario_id']) ? $_COOKIE['usuario_id'] : null);

if ($id_solicitante) {
    $sql_solicitudes = "SELECT * FROM solicitudes WHERE id_solicitante = $id_solicitante";
    $resultado_solicitudes = mysqli_query($conn, $sql_solicitudes);

    if ($resultado_solicitudes) {
        // Verificar si hay datos
        if (mysqli_num_rows($resultado_solicitudes) > 0) {
            echo "<h2>Lista de Solicitudes</h2>";
            echo "<div class='solicitudes-list'>";
            
            // Recorrer y mostrar los datos de cada solicitud
            while ($solicitud = mysqli_fetch_assoc($resultado_solicitudes)) {
                echo "<div class='solicitud'>";
                echo "<p><strong>Dirección de acarreo:</strong> " . $solicitud['direccion_acarreo'] . "</p>";
                echo "<p><strong>Detalles de acarreo:</strong> " . $solicitud['detalles_acarreo'] . "</p>";
                echo "<p><strong>Estado:</strong> " . $solicitud['estado'] . "</p>";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='id_solicitud' value='" . $solicitud['id'] . "'>";
                if ($solicitud['estado'] == 'Espera') {
                    echo "<input type='submit' name='cancelar' value='Cancelar'>";
                } elseif ($solicitud['estado'] == 'Aceptado') {
                    echo "<input type='submit' name='entregado' value='Pedido Recibido'>";
                }

                // Aquí se mostrará el formulario de calificación si el estado es "Entregado"
                if ($solicitud['estado'] == 'Entregado') {
                    // Obtener la calificación actual del operario
                    $id_operario = $solicitud['id_operario'];
                    $sql_calificacion_operario = "SELECT calificacion FROM operarios WHERE id_operario = $id_operario";
                    $resultado_calificacion_operario = mysqli_query($conn, $sql_calificacion_operario);
                    $calificacion_operario = mysqli_fetch_assoc($resultado_calificacion_operario)['calificacion'];

                    echo "<div>";
                    echo "<label for='nueva_calificacion'>Calificación (1-5):</label>";
                    echo "<input type='radio' name='nueva_calificacion' value='1' " . ($calificacion_operario == 1 ? "checked" : "") . ">1";
                    echo "<input type='radio' name='nueva_calificacion' value='2' " . ($calificacion_operario == 2 ? "checked" : "") . ">2";
                    echo "<input type='radio' name='nueva_calificacion' value='3' " . ($calificacion_operario == 3 ? "checked" : "") . ">3";
                    echo "<input type='radio' name='nueva_calificacion' value='4' " . ($calificacion_operario == 4 ? "checked" : "") . ">4";
                    echo "<input type='radio' name='nueva_calificacion' value='5' " . ($calificacion_operario == 5 ? "checked" : "") . ">5";
                    echo "</div>";
                    echo "<input type='submit' name='submit_nueva_calificacion' value='Cambiar Calificación'>";
                }

                echo "</form>";
                echo "<a href='chat.php?id_solicitud=" . $solicitud['id'] . "&id_operario=" . $solicitud['id_operario'] . "'>Chatear con el operador</a>";
                echo "</div><hr>";
            }
            
            echo "</div>";
        } else {
            // No se encontraron solicitudes
            echo "No se encontraron solicitudes.";
        }
    } else {
        // Error al ejecutar la consulta
        echo "Error al obtener la lista de solicitudes: " . mysqli_error($conn);
    }
} else {
    // ID de solicitante de transporte no disponible
    echo "Error: ID de solicitante de transporte no disponible.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitante de Transporte - Lista de Solicitudes</title>
    <style>
        .solicitudes-list {
            margin-top: 20px;
        }
        .solicitud {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

</body>
</html>
<?php
    include 'footer.php';
?>
