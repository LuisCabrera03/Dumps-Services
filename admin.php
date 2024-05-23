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
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
            margin-bottom: 20px;
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
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h2>Panel de Control</h2>
<a href="admin_usuarios.php">Gestion de usuarios</a>
    <div style="text-align: center;">
        <h3>Número de mensajes por usuario:</h3>
        <canvas id="mensajesChart"></canvas>
    </div>

    <div style="text-align: center;">
        <h3>Número de solicitudes por operario:</h3>
        <canvas id="solicitudesChart"></canvas>
    </div>

    <div style="text-align: center;">
        <h3>Número de mensajes por fecha:</h3>
        <canvas id="mensajesPorFechaChart"></canvas>
    </div>

    <div style="text-align: center;">
        <h3>Distribución de estados de las solicitudes:</h3>
        <canvas id="estadosSolicitudesChart"></canvas>
    </div>

    <div>
        <h3>Usuarios activos (última semana):</h3>
        <table>
            <tr>
                <th>Usuario</th>
                <th>Número de Mensajes</th>
            </tr>
            <?php
            while ($row5 = $result5->fetch_assoc()) {
                echo "<tr><td>" . $row5["nombre"] . "</td><td>" . $row5["num_mensajes"] . "</td></tr>";
            }
            ?>
        </table>
    </div>

    <div>
        <h3>Operarios con calificación promedio:</h3>
        <table>
            <tr>
                <th>Operario</th>
                <th>Calificación Promedio</th>
            </tr>
            <?php
            while ($row6 = $result6->fetch_assoc()) {
                echo "<tr><td>" . $row6["id_operario"] . "</td><td>" . $row6["calificacion_promedio"] . "</td></tr>";
            }
            ?>
        </table>
    </div>

    <div style="text-align: center;">
        <h3>Distribución de usuarios por rol:</h3>
        <canvas id="usuariosPorRolChart"></canvas>
    </div>

    <script>
        var ctx1 = document.getElementById('mensajesChart').getContext('2d');
        var ctx2 = document.getElementById('solicitudesChart').getContext('2d');
        var ctx3 = document.getElementById('mensajesPorFechaChart').getContext('2d');
        var ctx4 = document.getElementById('estadosSolicitudesChart').getContext('2d');
        var ctx5 = document.getElementById('usuariosPorRolChart').getContext('2d');

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

        // Datos para el gráfico de mensajes por fecha
        $labels3 = [];
        $data3 = [];
        while ($row3 = $result3->fetch_assoc()) {
            $labels3[] = "'" . $row3['fecha'] . "'";
            $data3[] = $row3['num_mensajes'];
        }

        // Datos para el gráfico de distribución de estados de las solicitudes
        $labels4 = [];
        $data4 = [];
        while ($row4 = $result4->fetch_assoc()) {
            $labels4[] = "'" . $row4['estado'] . "'";
            $data4[] = $row4['num_solicitudes'];
        }

        // Datos para el gráfico de usuarios por rol
        $labels5 = [];
        $data5 = [];
        while ($row7 = $result7->fetch_assoc()) {
            $labels5[] = "'" . $row7['rol'] . "'";
            $data5[] = $row7['num_usuarios'];
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

        var mensajesPorFechaChart = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: [<?php echo implode(',', $labels3); ?>],
                datasets: [{
                    label: 'Número de Mensajes',
                    data: [<?php echo implode(',', $data3); ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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

        var estadosSolicitudesChart = new Chart(ctx4, {
            type: 'pie',
            data: {
                labels: [<?php echo implode(',', $labels4); ?>],
                datasets: [{
                    label: 'Distribución de Estados de las Solicitudes',
                    data: [<?php echo implode(',', $data4); ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });

        var usuariosPorRolChart = new Chart(ctx5, {
            type: 'bar',
            data: {
                labels: [<?php echo implode(',', $labels5); ?>],
                datasets: [{
                    label: 'Número de Usuarios',
                    data: [<?php echo implode(',', $data5); ?>],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
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
