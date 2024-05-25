<?php
include 'conexion.php';
include 'header.php';

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

// Consulta para obtener el número de mensajes por fecha
$sql3 = "SELECT DATE(fecha_envio) AS fecha, COUNT(id) AS num_mensajes 
         FROM mensajes 
         GROUP BY DATE(fecha_envio)";
$result3 = $conn->query($sql3);

// Consulta para obtener la distribución de estados de las solicitudes
$sql4 = "SELECT estado, COUNT(id) AS num_solicitudes 
         FROM solicitudes 
         GROUP BY estado";
$result4 = $conn->query($sql4);

// Consulta para obtener usuarios activos
$sql5 = "SELECT usuarios.nombre, COUNT(mensajes.id) AS num_mensajes 
         FROM usuarios 
         LEFT JOIN mensajes ON usuarios.id = mensajes.id_usuario 
         WHERE mensajes.fecha_envio >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
         GROUP BY usuarios.id";
$result5 = $conn->query($sql5);

// Consulta para obtener operarios con calificación promedio
$sql6 = "SELECT operarios.id_operario, AVG(calificacion) AS calificacion_promedio 
         FROM operarios 
         GROUP BY operarios.id_operario";
$result6 = $conn->query($sql6);

// Consulta para obtener la distribución de usuarios por rol
$sql7 = "SELECT rol, COUNT(id) AS num_usuarios 
         FROM usuarios 
         GROUP BY rol";
$result7 = $conn->query($sql7);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2, h3 {
            text-align: center;
            color: #0056b3;
        }

        a {
            display: block;
            width: 200px;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .chart-container {
            margin: 20px auto;
            text-align: center;
            max-width: 800px;
        }

        canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%;
        }
    </style>
</head>
<body>
    <h2>Panel de Control</h2>
    <a href="admin_usuarios.php">Gestión de usuarios</a>

    <div class="chart-container">
        <h3>Número de mensajes por usuario:</h3>
        <canvas id="mensajesChart"></canvas>
    </div>

    <div class="chart-container">
        <h3>Número de solicitudes por operario:</h3>
        <canvas id="solicitudesChart"></canvas>
    </div>

    <div class="chart-container">
        <h3>Número de mensajes por fecha:</h3>
        <canvas id="mensajesPorFechaChart"></canvas>
    </div>

    <div class="chart-container">
        <h3>Distribución de estados de las solicitudes:</h3>
        <canvas id="estadosSolicitudesChart"></canvas>
    </div>

    <div class="chart-container">
        <h3>Distribución de usuarios por rol:</h3>
        <canvas id="usuariosPorRolChart"></canvas>
    </div>

    <div>
        <h3>Usuarios activos (última semana):</h3>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Número de Mensajes</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row5 = $result5->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row5["nombre"]; ?></td>
                    <td><?php echo $row5["num_mensajes"]; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div>
        <h3>Operarios con calificación promedio:</h3>
        <table>
            <thead>
                <tr>
                    <th>Operario</th>
                    <th>Calificación Promedio</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row6 = $result6->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row6["id_operario"]; ?></td>
                    <td><?php echo $row6["calificacion_promedio"]; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        const createChart = (ctx, type, labels, data, label, backgroundColor, borderColor) => {
            return new Chart(ctx, {
                type: type,
                plugins: [ChartDataLabels],
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        datalabels: {
                            color: 'white',
                            display: function(context) {
                                return context.dataset.data[context.dataIndex] > 0;
                            },
                            font: {
                                weight: 'bold'
                            },
                            formatter: Math.round
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutBounce'
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        };

        <?php
        // Datos para los gráficos
        $labels1 = [];
        $data1 = [];
        while ($row = $result->fetch_assoc()) {
            $labels1[] = "'" . $row['nombre'] . "'";
            $data1[] = $row['num_mensajes'];
        }

        $labels2 = [];
        $data2 = [];
        while ($row2 = $result2->fetch_assoc()) {
            $labels2[] = "'" . $row2['id_operario'] . "'";
            $data2[] = $row2['num_solicitudes'];
        }

        $labels3 = [];
        $data3 = [];
        while ($row3 = $result3->fetch_assoc()) {
            $labels3[] = "'" . $row3['fecha'] . "'";
            $data3[] = $row3['num_mensajes'];
        }

        $labels4 = [];
        $data4 = [];
        while ($row4 = $result4->fetch_assoc()) {
            $labels4[] = "'" . $row4['estado'] . "'";
            $data4[] = $row4['num_solicitudes'];
        }

        $labels5 = [];
        $data5 = [];
        while ($row7 = $result7->fetch_assoc()) {
            $labels5[] = "'" . $row7['rol'] . "'";
            $data5[] = $row7['num_usuarios'];
        }
        ?>

        createChart(
            document.getElementById('mensajesChart').getContext('2d'),
            'bar',
            [<?php echo implode(',', $labels1); ?>],
            [<?php echo implode(',', $data1); ?>],
            'Número de Mensajes',
            'rgba(54, 162, 235, 0.2)',
            'rgba(54, 162, 235, 1)'
        );

        createChart(
            document.getElementById('solicitudesChart').getContext('2d'),
            'bar',
            [<?php echo implode(',', $labels2); ?>],
            [<?php echo implode(',', $data2); ?>],
            'Número de Solicitudes',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 1)'
        );

        createChart(
            document.getElementById('mensajesPorFechaChart').getContext('2d'),
            'line',
            [<?php echo implode(',', $labels3); ?>],
            [<?php echo implode(',', $data3); ?>],
            'Número de Mensajes',
            'rgba(75, 192, 192, 0.2)',
            'rgba(75, 192, 192, 1)'
        );

        createChart(
            document.getElementById('estadosSolicitudesChart').getContext('2d'),
            'pie',
            [<?php echo implode(',', $labels4); ?>],
            [<?php echo implode(',', $data4); ?>],
            'Distribución de Estados de las Solicitudes',
            [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ]
        );

        createChart(
            document.getElementById('usuariosPorRolChart').getContext('2d'),
            'bar',
            [<?php echo implode(',', $labels5); ?>],
            [<?php echo implode(',', $data5); ?>],
            'Número de Usuarios',
            'rgba(255, 206, 86, 0.2)',
            'rgba(255, 206, 86, 1)'
        );
    </script>
</body>
</html>
