<?php
include 'conexion.php';

// Validar si factura_id fue proporcionado en la URL
if (!isset($_GET['factura_id']) || empty($_GET['factura_id'])) {
    die("Error: El ID de la factura no fue proporcionado.");
}

$factura_id = intval($_GET['factura_id']);

// Verificar si la factura existe
$factura_query = "
    SELECT 
        usuarios.nombre AS socio,
        usuarios.telefono AS ci,
        usuarios.direccion AS zona,
        DATE_FORMAT(consumos.fecha_lectura, '%M') AS mes,
        consumos.consumo_m3 AS consumo,
        facturacion.monto AS pago
    FROM facturacion
    LEFT JOIN consumos ON facturacion.consumo_id = consumos.consumo_id
    LEFT JOIN medidores ON consumos.medidor_id = medidores.medidor_id
    LEFT JOIN usuarios ON medidores.usuario_id = usuarios.usuario_id
    WHERE facturacion.factura_id = $factura_id";

$factura_result = $conexion->query($factura_query);
$factura = $factura_result->fetch_assoc();

if (!$factura) {
    die("Error: No se encontró información para la factura proporcionada.");
}

// Manejar el envío del formulario de pago
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pago_query = "INSERT INTO pagos (factura_id, fecha_pago, monto_pagado, metodo_pago) 
                   VALUES ('$factura_id', NOW(), '{$factura['pago']}', 'Efectivo')";
    $actualizar_factura_query = "UPDATE facturacion SET estado = 'pagado' WHERE factura_id = $factura_id";

    if ($conexion->query($pago_query) === TRUE && $conexion->query($actualizar_factura_query) === TRUE) {
        echo "<script>alert('Pago realizado exitosamente'); window.location.href = 'index.php';</script>";
    } else {
        die("Error al realizar el pago: " . $conexion->error);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pago - WATERREG</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h3 class="text-primary">Cobrar</h3>
    <p><strong>Socio:</strong> <?php echo $factura['socio']; ?></p>
    <p><strong>CI:</strong> <?php echo $factura['ci']; ?></p>
    <p><strong>Zona:</strong> <?php echo $factura['zona']; ?></p>
    <p><strong>Mes:</strong> <?php echo $factura['mes']; ?></p>
    <p><strong>Consumo:</strong> <?php echo $factura['consumo'] . " m³"; ?></p>
    <p><strong>Pago:</strong> <?php echo "Bs " . $factura['pago']; ?></p>

    <form method="POST">
        <button type="submit" class="btn btn-primary w-100">Registrar Pago</button>
    </form>
</div>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
