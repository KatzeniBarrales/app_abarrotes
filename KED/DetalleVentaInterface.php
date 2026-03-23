<?php
require_once("abarroteslauraDB.php");
$db = new Database();
$conexion = $db->connect();

$sql = "SELECT 
            v.id_venta,
            u.nombres AS usuario,
            v.fecha,
            v.descuento,
            v.total AS total_venta,
            p.nombre AS producto,
            dv.cantidad,
            dv.precio_unitario,
            dv.subtotal
        FROM ventas v
        JOIN usuarios u ON v.id_usuario = u.id_usuario
        JOIN detalle_venta dv ON v.id_venta = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id_producto
        ORDER BY v.id_venta DESC, dv.id_detalle ASC";

$ventas = $conexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Consulta de Ventas</h2>

    <?php
    $ventaActual = null;
    foreach ($ventas as $venta) {
        if ($ventaActual !== $venta['id_venta']) {
            if ($ventaActual !== null) {
                echo "</tbody></table><hr>";
            }

            $ventaActual = $venta['id_venta'];
            echo "<h5>Venta #{$venta['id_venta']} | Usuario: {$venta['usuario']} | Fecha: {$venta['fecha']}</h5>";
            echo "<p>Descuento: {$venta['descuento']} | Total: {$venta['total_venta']}</p>";
            echo "<table class='table table-bordered'>
                    <thead class='table-dark'>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Total Venta</th>
                        </tr>
                    </thead>
                    <tbody>";
        }

        echo "<tr>
                <td>{$venta['producto']}</td>
                <td>{$venta['cantidad']}</td>
                <td>$" . number_format($venta['precio_unitario'], 2) . "</td>
                <td>$" . number_format($venta['subtotal'], 2) . "</td>
                 <td><strong>$" . number_format($venta['total_venta'], 1) . "</strong></td>
              </tr>";
    }

    if (!empty($ventas)) {
        echo "</tbody></table>";
    } else {
        echo "<p>No hay ventas registradas.</p>";
    }
    ?>
</div>
</body>
</html>
