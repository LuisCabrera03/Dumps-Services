<?php
include 'conexion.php';

// Consulta para obtener el número de mensajes por usuario
$sql = "SELECT usuarios.nombre, COUNT(mensajes.id) AS num_mensajes 
        FROM usuarios 
        LEFT JOIN mensajes ON usuarios.id = mensajes.id_usuario 
        GROUP BY usuarios.id";
$result = $conn->query($sql);

// Consulta para obtener el número de solicitudes por operario
$sql2 = "SELECT operarios.id_operario, COUNT(solicitudes.id) AS num_solicitudes 
         FROM operarios 
         LEFT JOIN solicitudes ON operarios.id_operario = solicitudes.id_operario 
         GROUP BY operarios.id_operario";
$result2 = $conn->query($sql2);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        canvas {
            margin: auto;
            display: block;
            max-width: 800px;
            max-height: 400px;
        }
    </style>
</head>
<body>
    <h2>Panel de Control</h2>

    <div style="text-align: center;">
        <h3>Número de mensajes por usuario:</h3>
        <canvas id="mensajesChart"></canvas>
    </div>

    <div style="text-align: center;">
        <h3>Número de solicitudes por operario:</h3>
        <canvas id="solicitudesChart"></canvas>
    </div>

    <script>
        var ctx1 = document.getElementById('mensajesChart').getContext('2d');
        var ctx2 = document.getElementById('solicitudesChart').getContext('2d');

        <?php
        // Datos para el gráfico de mensajes por usuario
        $labels1 = [];
        $data1 = [];
        while ($row = $result->fetch_assoc()) {
            $labels1[] = "'" . $row['nombre'] . "'";
            $data1[] = $row['num_mensajes'];
        }

        // Datos para el gráfico de solicitudes por operario
        $labels2 = [];
        $data2 = [];
        while ($row2 = $result2->fetch_assoc()) {
            $labels2[] = "'" . $row2['id_operario'] . "'";
            $data2[] = $row2['num_solicitudes'];
        }
        ?>

        var mensajesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [<?php echo implode(',', $labels1); ?>],
                datasets: [{
                    label: 'Número de Mensajes',
                    data: [<?php echo implode(',', $data1); ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var solicitudesChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [<?php echo implode(',', $labels2); ?>],
                datasets: [{
                    label: 'Número de Solicitudes',
                    data: [<?php echo implode(',', $data2); ?>],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
