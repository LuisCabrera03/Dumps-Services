<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';
include 'header.php';

// Consulta para obtener el número de solicitudes del solicitante actual
$id_solicitante = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : (isset($_COOKIE['usuario_id']) ? $_COOKIE['usuario_id'] : null);
$num_solicitudes = 0;

if ($id_solicitante) {
    $sql_num_solicitudes = "SELECT COUNT(*) AS num_solicitudes FROM solicitudes WHERE id_solicitante = $id_solicitante";
    $resultado_num_solicitudes = mysqli_query($conn, $sql_num_solicitudes);

    if ($resultado_num_solicitudes) {
        $row = mysqli_fetch_assoc($resultado_num_solicitudes);
        $num_solicitudes = $row['num_solicitudes'];
    } else {
        // Error al ejecutar la consulta
        echo "Error al obtener el número de solicitudes: " . mysqli_error($conn);
    }
} else {
    // ID de solicitante de transporte no disponible
    echo "Error: ID de solicitante de transporte no disponible.";
}

// Botón para ver solicitudes
echo "<a href='solicitud.php' class='solicitud-button'>Ver Mis Solicitudes</a>";

// Consulta para obtener la información relevante de todos los operarios
$sql_operarios = "SELECT 
    usuarios.nombre, 
    usuarios.apellidos, 
    operarios.id_operario,
    operarios.marca_motocarro, 
    operarios.modelo_motocarro, 
    operarios.año_motocarro, 
    operarios.placa_motocarro, 
    operarios.foto_motocarro 
FROM operarios 
JOIN usuarios ON operarios.id_usuario = usuarios.id";

$resultado_operarios = mysqli_query($conn, $sql_operarios);

if ($resultado_operarios) {
    // Verificar si hay datos
    if (mysqli_num_rows($resultado_operarios) > 0) {
        echo "<h2>Lista de Operarios</h2>";
        echo "<div class='operarios-list'>";
        
        // Recorrer y mostrar los datos de cada operario
        while ($operario = mysqli_fetch_assoc($resultado_operarios)) {
            echo "<div class='operario'>";
            echo "<a href='solicitar_operario.php?id_operario=" . $operario['id_operario'] . "'>";
            echo "<img src='" . $operario['foto_motocarro'] . "' alt='Foto del Motocarro' style='width:200px;height:200px;'><br>";
            echo "<p><strong>Nombre:</strong> " . $operario['nombre'] . " " . $operario['apellidos'] . "</p>";
            echo "<p><strong>Marca del Motocarro:</strong> " . $operario['marca_motocarro'] . "</p>";
            echo "<p><strong>Modelo del Motocarro:</strong> " . $operario['modelo_motocarro'] . "</p>";
            echo "<p><strong>Año del Motocarro:</strong> " . $operario['año_motocarro'] . "</p>";
            echo "<p><strong>Placa del Motocarro:</strong> " . $operario['placa_motocarro'] . "</p>";
            echo "</a>";
            echo "</div><hr>";
        }
        
        echo "</div>";
    } else {
        // No se encontraron operarios
        echo "No se encontraron operarios.";
    }
} else {
    // Error al ejecutar la consulta
    echo "Error al obtener la lista de operarios: " . mysqli_error($conn);
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitante de Transporte - Lista de Operarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .operarios-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .operario {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            width: calc(33.333% - 20px);
            box-sizing: border-box;
            text-align: center;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .operario img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        @media (max-width: 768px) {
            .operario {
                width: calc(50% - 20px);
            }
        }
        @media (max-width: 480px) {
            .operario {
                width: calc(100% - 20px);
            }
        }
        .solicitud-button {
            margin-top: 10px;
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .solicitud-button:hover {
            background-color: #0056b3;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0056b3;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Operarios Disponibles</h2>
        <div class="operarios-list">
            <div class="operario">
                <img src="https://via.placeholder.com/300" alt="Operario 1">
                <h3>Nombre Operario 1</h3>
                <p>Descripción del operario y sus servicios.</p>
                <a href="#" class="solicitud-button">Solicitar Transporte</a>
            </div>
            <div class="operario">
                <img src="https://via.placeholder.com/300" alt="Operario 2">
                <h3>Nombre Operario 2</h3>
                <p>Descripción del operario y sus servicios.</p>
                <a href="#" class="solicitud-button">Solicitar Transporte</a>
            </div>
            <div class="operario">
                <img src="https://via.placeholder.com/300" alt="Operario 3">
                <h3>Nombre Operario 3</h3>
                <p>Descripción del operario y sus servicios.</p>
                <a href="#" class="solicitud-button">Solicitar Transporte</a>
            </div>
            <div class="operario">
                <img src="https://via.placeholder.com/300" alt="Operario 4">
                <h3>Nombre Operario 4</h3>
                <p>Descripción del operario y sus servicios.</p>
                <a href="#" class="solicitud-button">Solicitar Transporte</a>
            </div>
            <div class="operario">
                <img src="https://via.placeholder.com/300" alt="Operario 5">
                <h3>Nombre Operario 5</h3>
                <p>Descripción del operario y sus servicios.</p>
                <a href="#" class="solicitud-button">Solicitar Transporte</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
