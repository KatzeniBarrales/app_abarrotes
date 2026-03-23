<?php
session_start();
require_once("abarroteslauraDB.php");
$db = new Database();
$conexion = $db->connect();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<script>alert('El carrito está vacío.'); window.location.href = 'ventas.php';</script>";
    exit;
}

try {
    $conexion->beginTransaction();

    $id_usuario = $_SESSION['usuario_id'] ?? 1;
    $fecha = date('Y-m-d H:i:s');
    $total = 0;

    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    // Insertar venta
    $stmtVenta = $conexion->prepare("
        INSERT INTO ventas (id_usuario, fecha, total) 
        VALUES (:id_usuario, :fecha, :total)
    ");
    $stmtVenta->execute([
        'id_usuario' => $id_usuario,
        'fecha' => $fecha,
        'total' => $total
    ]);
    $id_venta = $conexion->lastInsertId();

    // Insertar detalle de la venta
    $stmtDetalle = $conexion->prepare("
        INSERT INTO detalle_venta 
        (id_venta, id_usuario, id_producto, cantidad, precio_unitario, subtotal)
        VALUES 
        (:id_venta, :id_usuario, :id_producto, :cantidad, :precio_unitario, :subtotal)
    ");

    foreach ($_SESSION['carrito'] as $item) {
        if (!isset($item['id_producto'])) {
            throw new Exception("Producto sin ID: " . json_encode($item));
        }

        $subtotal = $item['precio'] * $item['cantidad'];

        $stmtDetalle->execute([
            'id_venta' => $id_venta,
            'id_usuario' => $id_usuario,
            'id_producto' => $item['id_producto'],
            'cantidad' => $item['cantidad'],
            'precio_unitario' => $item['precio'],
            'subtotal' => $subtotal
        ]);
    }

    $conexion->commit();

    $_SESSION['carrito'] = []; // Limpiar carrito

    echo "<script>alert('Venta registrada correctamente.'); window.location.href = 'ventas.php';</script>";
} catch (Exception $e) {
    $conexion->rollBack();
    echo "<script>alert('Error al registrar la venta: " . $e->getMessage() . "'); window.location.href = 'ventas.php';</script>";
}
