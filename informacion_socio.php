<?php
include 'conexion.php';

// Obtener el usuario_id de la URL
$usuario_id = $_GET['usuario_id'];

// Consulta para obtener la información del socio
$usuario_query = "SELECT nombre, telefono, direccion FROM usuarios WHERE usuario_id = $usuario_id";
$usuario_result = $conexion->query($usuario_query);
$usuario = $usuario_result->fetch_assoc();

// Consulta para obtener los datos de consumo del socio
$consumos_query = "
    SELECT 
        DATE_FORMAT(consumos.fecha_lectura, '%d %M') AS fecha_lectura,
        DATE_FORMAT(pagos.fecha_pago, '%d %M') AS fecha_pago,
        consumos.consumo_m3,
        facturacion.monto,
        facturacion.estado
    FROM consumos
    LEFT JOIN facturacion ON consumos.consumo_id = facturacion.consumo_id
    LEFT JOIN pagos ON facturacion.factura_id = pagos.factura_id
    WHERE consumos.medidor_id IN (SELECT medidor_id FROM medidores WHERE usuario_id = $usuario_id)";
$consumos_result = $conexion->query($consumos_query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Socio - WATERREG</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff; /* Fondo celeste claro */
        }
        .sidebar {
            background-color: #e3f2fd; /* Fondo de la barra lateral */
            min-height: 100vh;
        }
        .sidebar a {
            color: #007bff; /* Azul para resaltar */
            font-weight: bold;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #0056b3; /* Azul oscuro en hover */
        }
        .table th {
            background-color: #007bff; /* Azul para los encabezados */
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .text-primary {
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Barra lateral -->
        <nav class="col-md-2 sidebar p-3">
            <h4 class="text-primary">WATERREG</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Medidores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="lista_socios.php">Socios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registrar_consumo.php">Lecturador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pagos</a>
                </li>
            </ul>
        </nav>

        <!-- Contenido principal -->
        <main class="col-md-10 p-4">
            <h3 class="text-primary">Socio</h3>
            <p><strong>Nombre:</strong> <?php echo $usuario['nombre']; ?></p>
            <p><strong>CI:</strong> <?php echo $usuario['telefono']; ?></p>
            <p><strong>Zona:</strong> <?php echo $usuario['direccion']; ?></p>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Fecha Lectura</th>
                        <th>Fecha Pago</th>
                        <th>Consumo</th>
                        <th>Monto</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($consumo = $consumos_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo date("F", strtotime($consumo['fecha_lectura'])); ?></td>
                        <td><?php echo $consumo['fecha_lectura']; ?></td>
                        <td><?php echo $consumo['fecha_pago'] ?? 'N/A'; ?></td>
                        <td><?php echo $consumo['consumo_m3'] . " m³"; ?></td>
                        <td><?php echo "Bs " . $consumo['monto']; ?></td>
                        <td><?php echo $consumo['estado']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
