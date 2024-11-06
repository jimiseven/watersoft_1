<?php
include 'conexion.php';

// Obtener lista de usuarios
$usuarios_query = "SELECT usuario_id, nombre FROM usuarios";
$usuarios_result = $conexion->query($usuarios_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario_id = $_POST['usuario_id'];
    $lectura_anterior = $_POST['lectura_anterior'];
    $lectura_actual = $_POST['lectura_actual'];
    $consumo_m3 = $lectura_actual - $lectura_anterior;
    $observaciones = $_POST['observaciones'];
    $fecha_lectura = date("Y-m-d");

    // Obtener el medidor_id del usuario
    $medidor_query = "SELECT medidor_id FROM medidores WHERE usuario_id = $usuario_id";
    $medidor_result = $conexion->query($medidor_query);
    $medidor = $medidor_result->fetch_assoc();

    if ($medidor) {
        $medidor_id = $medidor['medidor_id'];

        // Insertar el nuevo registro de consumo
        $insert_query = "INSERT INTO consumos (medidor_id, fecha_lectura, lectura_anterior, lectura_actual, consumo_m3, observaciones) VALUES ('$medidor_id', '$fecha_lectura', '$lectura_anterior', '$lectura_actual', '$consumo_m3', '$observaciones')";
        if ($conexion->query($insert_query) === TRUE) {
            echo "<script>alert('Consumo registrado exitosamente'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $insert_query . "<br>" . $conexion->error;
        }
    } else {
        echo "<script>alert('No se encontró un medidor asociado al usuario seleccionado.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Consumo - WATERREG</title>
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
                    <a class="nav-link active" href="registrar_consumo.php">Lecturador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pagos</a>
                </li>
            </ul>
        </nav>

        <!-- Contenido principal -->
        <main class="col-md-10 p-4">
            <div class="container form-container">
                <h2 class="text-primary text-center">Registrar Consumo</h2>
                <form action="registrar_consumo.php" method="POST">
                    <div class="mb-3">
                        <label for="usuario_id" class="form-label">Seleccionar Usuario</label>
                        <select class="form-control" id="usuario_id" name="usuario_id" required onchange="cargarMedidor()">
                            <option value="" disabled selected>Seleccione un usuario</option>
                            <?php while ($usuario = $usuarios_result->fetch_assoc()) { ?>
                                <option value="<?php echo $usuario['usuario_id']; ?>">
                                    <?php echo $usuario['nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="medidor_id" class="form-label">Medidor Asociado</label>
                        <input type="text" class="form-control" id="medidor_id" name="medidor_id" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lectura_anterior" class="form-label">Lectura Anterior (m³)</label>
                        <input type="number" step="0.01" class="form-control" id="lectura_anterior" name="lectura_anterior" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lectura_actual" class="form-label">Lectura Actual (m³)</label>
                        <input type="number" step="0.01" class="form-control" id="lectura_actual" name="lectura_actual" required>
                    </div>
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Consumo</button>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
// Función para cargar el medidor asociado y la última lectura de consumo para el usuario seleccionado
function cargarMedidor() {
    const usuarioId = document.getElementById('usuario_id').value;

    if (usuarioId) {
        fetch(`obtener_medidor.php?usuario_id=${usuarioId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('medidor_id').value = data.medidor_id || 'Sin medidor';
                document.getElementById('lectura_anterior').value = data.lectura_anterior || 0;
            })
            .catch(error => console.error('Error al obtener el medidor y la lectura anterior:', error));
    } else {
        document.getElementById('medidor_id').value = '';
        document.getElementById('lectura_anterior').value = '';
    }
}
</script>
</body>
</html>
