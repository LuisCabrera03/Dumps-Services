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
                    echo "<input type='submit' name='entregado' value='Marcar como entregado'>";
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
