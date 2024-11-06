<?php
include 'conexion.php';

// Consulta para obtener los datos de la tabla medidores
$query = "SELECT numero_medidor, fecha_instalacion, ubicacion FROM medidores";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Medidores - WATERREG</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Barra lateral -->
        <nav class="col-md-2 sidebar p-3">
            <h4 class="text-primary">WATERREG</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Medidores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lista_socios.php">Socios</a>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">Lista de Medidores</h2>
                <a href="registrar_medidor.php" class="btn btn-primary">Nuevo Medidor</a>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar">
                <button class="btn btn-outline-primary" type="button">Buscar</button>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>N° de medidor</th>
                        <th>Fecha registro</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['numero_medidor']; ?></td>
                        <td><?php echo date("d M Y", strtotime($row['fecha_instalacion'])); ?></td>
                        <td><?php echo $row['ubicacion']; ?></td>
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
