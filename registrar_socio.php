<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $fecha_registro = $_POST['fecha_registro'];
    $estado = $_POST['estado'];

    // Insertar el nuevo socio en la base de datos
    $sql = "INSERT INTO usuarios (nombre, direccion, telefono, email, fecha_registro, estado) VALUES ('$nombre', '$direccion', '$telefono', '$email', '$fecha_registro', '$estado')";
    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Socio registrado exitosamente'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Socio - WATERREG</title>
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
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
                    <a class="nav-link active" href="registrar_socio.php">Socios</a>
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
            <div class="container form-container">
                <h2 class="text-primary text-center">Registrar Nuevo Socio</h2>
                <form action="registrar_socio.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                        <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Socio</button>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
