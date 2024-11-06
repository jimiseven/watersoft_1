<?php
include 'conexion.php';

if (isset($_GET['usuario_id'])) {
    $usuario_id = $_GET['usuario_id'];
    // Obtener el medidor asociado al usuario
    $query = "SELECT medidor_id FROM medidores WHERE usuario_id = $usuario_id";
    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        $medidor = $result->fetch_assoc();
        $medidor_id = $medidor['medidor_id'];

        // Obtener la última lectura de consumo para el medidor
        $lectura_query = "SELECT lectura_actual FROM consumos WHERE medidor_id = $medidor_id ORDER BY fecha_lectura DESC LIMIT 1";
        $lectura_result = $conexion->query($lectura_query);

        if ($lectura_result->num_rows > 0) {
            $lectura = $lectura_result->fetch_assoc();
            $medidor['lectura_anterior'] = $lectura['lectura_actual'];
        } else {
            $medidor['lectura_anterior'] = 0; // Si no hay registros previos, poner 0 como valor inicial
        }

        echo json_encode($medidor);
    } else {
        echo json_encode(['medidor_id' => null, 'lectura_anterior' => 0]);
    }
}
?>
