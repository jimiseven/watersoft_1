<?php
include 'conexion.php';

// Consulta para obtener los nombres y IDs de los usuarios registrados
$usuarios_query = "SELECT usuario_id, nombre FROM usuarios";
$usuarios_result = $conexion->query($usuarios_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario_id = $_POST['usuario_id'];
    $numero_medidor = $_POST['numero_medidor'];
    $fecha_instalacion = $_POST['fecha_instalacion'];
    $ubicacion = $_POST['ubicacion'];

    // Insertar el nuevo medidor en la base de datos
    $sql = "INSERT INTO medidores (usuario_id, numero_medidor, fecha_instalacion, ubicacion) VALUES ('$usuario_id', '$numero_medidor', '$fecha_instalacion', '$ubicacion')";
    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Medidor registrado exitosamente'); window.location.href = 'index.php';</script>";
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
    <title>Registrar Medidor - WATERREG</title>
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
            <div class="container form-container">
                <h2 class="text-primary text-center">Registrar Nuevo Medidor</h2>
                <form action="registrar_medidor.php" method="POST">
                    <div class="mb-3">
                        <label for="usuario_id" class="form-label">Seleccionar Usuario</label>
                        <select class="form-control" id="usuario_id" name="usuario_id" required>
                            <option value="" disabled selected>Seleccione un usuario</option>
                            <?php while ($usuario = $usuarios_result->fetch_assoc()) { ?>
                                <option value="<?php echo $usuario['usuario_id']; ?>">
                                    <?php echo $usuario['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="numero_medidor" class="form-label">Número de Medidor</label>
                        <input type="text" class="form-control" id="numero_medidor" name="numero_medidor" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_instalacion" class="form-label">Fecha de Instalación</label>
                        <input type="date" class="form-control" id="fecha_instalacion" name="fecha_instalacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Medidor</button>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
