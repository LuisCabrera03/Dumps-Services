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
if (isset($_POST['submit_nueva_calificacion'])) {
    $id_solicitud = $_POST['id_solicitud'];
    $calificacion = $_POST['nueva_calificacion'];

    // Obtener el ID del operario asociado a la solicitud
    $sql_id_operario = "SELECT id_operario FROM solicitudes WHERE id = $id_solicitud";
    $resultado_id_operario = mysqli_query($conn, $sql_id_operario);
    $row = mysqli_fetch_assoc($resultado_id_operario);
    $id_operario = $row['id_operario'];

    // Comprobar si ya existe una calificación para esta solicitud y operario
    $sql_check_calificacion = "SELECT * FROM calificaciones WHERE id_operario = $id_operario AND id_solicitud = $id_solicitud";
    $resultado_check_calificacion = mysqli_query($conn, $sql_check_calificacion);

    if (mysqli_num_rows($resultado_check_calificacion) > 0) {
        // Actualizar la calificación existente
        $sql_actualizar_calificacion = "UPDATE calificaciones SET calificacion = $calificacion WHERE id_operario = $id_operario AND id_solicitud = $id_solicitud";
        if (mysqli_query($conn, $sql_actualizar_calificacion)) {
            echo "Calificación actualizada correctamente.";
        } else {
            echo "Error al actualizar la calificación: " . mysqli_error($conn);
        }
    } else {
        // Insertar una nueva calificación
        $sql_insertar_calificacion = "INSERT INTO calificaciones (id_operario, id_solicitud, calificacion) VALUES ($id_operario, $id_solicitud, $calificacion)";
        if (mysqli_query($conn, $sql_insertar_calificacion)) {
            echo "¡Gracias por tu calificación!";
        } else {
            echo "Error al guardar la calificación: " . mysqli_error($conn);
        }
    }

    // Obtener el nuevo promedio de calificaciones para el operario
    $sql_calcular_promedio = "SELECT AVG(calificacion) as promedio_calificacion FROM calificaciones WHERE id_operario = $id_operario";
    $resultado_promedio = mysqli_query($conn, $sql_calcular_promedio);
    $promedio_calificacion = mysqli_fetch_assoc($resultado_promedio)['promedio_calificacion'];

    // Actualizar el promedio de calificaciones en la tabla de operarios
    $sql_actualizar_promedio = "UPDATE operarios SET calificacion = $promedio_calificacion WHERE id_operario = $id_operario";
    if (mysqli_query($conn, $sql_actualizar_promedio)) {
        echo "Promedio de calificación actualizado correctamente.";
    } else {
        echo "Error al actualizar el promedio de calificación: " . mysqli_error($conn);
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
                    // Obtener la calificación actual del operario para la solicitud específica
                    $id_operario = $solicitud['id_operario'];
                    $sql_calificacion_actual = "SELECT calificacion FROM calificaciones WHERE id_operario = $id_operario AND id_solicitud = " . $solicitud['id'];
                    $resultado_calificacion_actual = mysqli_query($conn, $sql_calificacion_actual);
                    $calificacion_actual = mysqli_fetch_assoc($resultado_calificacion_actual)['calificacion'];

                    echo "<div>";
                    echo "<label for='nueva_calificacion'>Calificación (1-5):</label>";
                    for ($i = 1; $i <= 5; $i++) {
                        $checked = ($calificacion_actual == $i) ? "checked" : "";
                        echo "<input type='radio' name='nueva_calificacion' value='$i' $checked>$i";
                    }
                    echo "</div>";
                    echo "<input type='submit' name='submit_nueva_calificacion' value='Calificar'>";
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
