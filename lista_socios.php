<?php
include 'conexion.php';

// Consulta para obtener los datos de la tabla usuarios
$query = "SELECT usuario_id, nombre, direccion AS zona, estado AS observaciones FROM usuarios";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Socios - WATERREG</title>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">Lista de Socios</h2>
                <a href="registrar_socio.php" class="btn btn-primary">Nuevo Socio</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Zona</th>
                        <th>Observaciones</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['zona']; ?></td>
                        <td><?php echo $row['observaciones']; ?></td>
                        <td>
                            <a href="informacion_socio.php?usuario_id=<?php echo $row['usuario_id']; ?>" class="btn btn-info">Información</a>
                        </td>
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
