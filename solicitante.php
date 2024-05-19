<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

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
        .operarios-list {
            display: flex;
            flex-wrap: wrap;
        }
        .operario {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            width: calc(33.333% - 40px);
            box-sizing: border-box;
            text-align: center;
        }
        .operario img {
            max-width: 100%;
            height: auto;
        }
        @media (max-width: 768px) {
            .operario {
                width: calc(50% - 40px);
            }
        }
        @media (max-width: 480px) {
            .operario {
                width: calc(100% - 40px);
            }
        }
    </style>
</head>
<body>

</body>
</html>
