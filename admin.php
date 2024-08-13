<?php
session_start();
include 'conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Consultas SQL para gráficos
$sqlMensajes = "SELECT usuarios.nombre, COUNT(mensajes.id) AS num_mensajes 
                FROM usuarios 
                LEFT JOIN mensajes ON usuarios.id = mensajes.id_usuario 
                GROUP BY usuarios.id";
$resultMensajes = $conn->query($sqlMensajes);

$sqlSolicitudes = "SELECT operarios.id_operario, COUNT(solicitudes.id) AS num_solicitudes 
                   FROM operarios 
                   LEFT JOIN solicitudes ON operarios.id_operario = solicitudes.id_operario 
                   GROUP BY operarios.id_operario";
$resultSolicitudes = $conn->query($sqlSolicitudes);

$sqlMensajesPorFecha = "SELECT DATE(fecha_envio) AS fecha, COUNT(id) AS num_mensajes 
                        FROM mensajes 
                        GROUP BY DATE(fecha_envio)";
$resultMensajesPorFecha = $conn->query($sqlMensajesPorFecha);

$sqlEstadosSolicitudes = "SELECT estado, COUNT(id) AS num_solicitudes 
                          FROM solicitudes 
                          GROUP BY estado";
$resultEstadosSolicitudes = $conn->query($sqlEstadosSolicitudes);

$sqlUsuariosPorRol = "SELECT rol, COUNT(id) AS num_usuarios 
                      FROM usuarios 
                      GROUP BY rol";
$resultUsuariosPorRol = $conn->query($sqlUsuariosPorRol);

// Obtener saludo basado en la hora
date_default_timezone_set('America/Bogota');
$hora = date('H');
$saludo = '';

if ($hora >= 6 && $hora < 12) {
    $saludo = '¡Buenos días!';
} elseif ($hora >= 12 && $hora < 18) {
    $saludo = '¡Buenas tardes!';
} else {
    $saludo = '¡Buenas noches!';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
        }

        .sidebar {
            background-color: #2c3e50;
            color: #ecf0f1;
            min-height: 100vh;
            padding: 20px;
        }

        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 10px 0;
        }

        .sidebar a:hover {
            background-color: #34495e;
            border-radius: 5px;
        }

        .sidebar .active {
            background-color: #34495e;
            border-radius: 5px;
        }

        .main-content {
            padding: 20px;
        }

        .card {
            border-radius: 10px;
            margin-bottom: 20px;
            color: white;
            padding: 20px;
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .card-orange {
            background: linear-gradient(60deg, #ffa726, #fb8c00);
            box-shadow: 0 4px 20px 0 rgba(255, 152, 0, 0.14), 0 7px 10px -5px rgba(255, 152, 0, 0.4);
        }

        .card-green {
            background: linear-gradient(60deg, #66bb6a, #43a047);
            box-shadow: 0 4px 20px 0 rgba(76, 175, 80, 0.14), 0 7px 10px -5px rgba(76, 175, 80, 0.4);
        }

        .card-red {
            background: linear-gradient(60deg, #ef5350, #e53935);
            box-shadow: 0 4px 20px 0 rgba(244, 67, 54, 0.14), 0 7px 10px -5px rgba(244, 67, 54, 0.4);
        }

        .card-blue {
            background: linear-gradient(60deg, #42a5f5, #1e88e5);
            box-shadow: 0 4px 20px 0 rgba(33, 150, 243, 0.14), 0 7px 10px -5px rgba(33, 150, 243, 0.4);
        }

        .card-content {
            font-size: 1.5rem;
        }

        .card-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .card-footer {
            text-align: right;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .chart-container {
            position: relative;
            height: 200px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="d-flex">
        <div class="sidebar p-3">
            <h3>Dashboard</h3>
            <a href="dashboard.php" class="active">Panel de Control</a>
            <a href="admin_usuarios.php">Gestión de Usuarios</a>
            <a href="perfil.php">Perfil</a>
            <a href="logout.php">Cerrar Sesión</a>
        </div>

        <!-- Main content -->
        <div class="flex-grow-1">
            <div class="main-content">
                <h4><?php echo $saludo; ?></h4>
                <p>Aquí está lo que está pasando con tu negocio hoy.</p>

                <div class="row">
                    <!-- Card 1 -->
                    <div class="col-md-4">
                        <div class="card card-orange">
                            <i class="fas fa-envelope card-icon"></i>
                            <div class="card-content">
                                <?php
                                $totalMensajes = 0;
                                while ($row = $resultMensajes->fetch_assoc()) {
                                    $totalMensajes += $row['num_mensajes'];
                                }
                                echo $totalMensajes;
                                ?>
                            </div>
                            <div class="card-subtitle">Total Mensajes</div>
                            <div class="card-footer">Actualización reciente</div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-md-4">
                        <div class="card card-green">
                            <i class="fas fa-tasks card-icon"></i>
                            <div class="card-content">
                                <?php
                                $totalSolicitudes = 0;
                                while ($row = $resultSolicitudes->fetch_assoc()) {
                                    $totalSolicitudes += $row['num_solicitudes'];
                                }
                                echo $totalSolicitudes;
                                ?>
                            </div>
                            <div class="card-subtitle">Total Solicitudes</div>
                            <div class="card-footer">Actualización reciente</div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-4">
                        <div class="card card-red">
                            <i class="fas fa-user-friends card-icon"></i>
                            <div class="card-content">
                                <?php
                                $totalUsuarios = 0;
                                while ($row = $resultUsuariosPorRol->fetch_assoc()) {
                                    $totalUsuarios += $row['num_usuarios'];
                                }
                                echo $totalUsuarios;
                                ?>
                            </div>
                            <div class="card-subtitle">Total Usuarios</div>
                            <div class="card-footer">Actualización reciente</div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Gráfico de líneas -->
                    <div class="col-md-8">
                        <div class="card card-blue">
                            <h5>Tráfico de Mensajes</h5>
                            <div class="chart-container">
                                <canvas id="mensajesPorFechaChart"></canvas>
                            </div>
                            <div class="card-footer">Últimos 7 días</div>
                        </div>
                    </div>
                    <!-- Gráfico de doughnut -->
                    <div class="col-md-4">
                        <div class="card card-green">
                            <h5>Distribución de Estados</h5>
                            <div class="chart-container">
                                <canvas id="estadosSolicitudesChart"></canvas>
                            </div>
                            <div class="card-footer">Estados de Solicitudes</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Función para crear gráficos
        const createChart = (ctx, type, labels, data, label, backgroundColor, borderColor) => {
            return new Chart(ctx, {
                type: type,
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
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        };

        <?php
        // Preparar datos para gráficos
        function prepararDatos($resultado, $labelCampo, $dataCampo)
        {
            $labels = [];
            $data = [];
            while ($row = $resultado->fetch_assoc()) {
                $labels[] = "'" . $row[$labelCampo] . "'";
                $data[] = $row[$dataCampo];
            }
            return [implode(',', $labels), implode(',', $data)];
        }

        list($labelsMensajesPorFecha, $dataMensajesPorFecha) = prepararDatos($resultMensajesPorFecha, 'fecha', 'num_mensajes');
        list($labelsEstadosSolicitudes, $dataEstadosSolicitudes) = prepararDatos($resultEstadosSolicitudes, 'estado', 'num_solicitudes');
        ?>

        // Gráfico: Tráfico de Mensajes
        createChart(
            document.getElementById('mensajesPorFechaChart').getContext('2d'),
            'line',
            [<?php echo $labelsMensajesPorFecha; ?>],
            [<?php echo $dataMensajesPorFecha; ?>],
            'Número de Mensajes',
            'rgba(54, 162, 235, 0.2)',
            'rgba(54, 162, 235, 1)'
        );

        // Gráfico: Distribución de Estados de Solicitudes
        createChart(
            document.getElementById('estadosSolicitudesChart').getContext('2d'),
            'doughnut',
            [<?php echo $labelsEstadosSolicitudes; ?>],
            [<?php echo $dataEstadosSolicitudes; ?>],
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
    </script>
</body>

</html>
