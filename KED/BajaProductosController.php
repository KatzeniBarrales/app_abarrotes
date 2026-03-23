<?php
require_once("abarroteslauraDB.php");
require_once("BajaProductosClase.php");

$mensaje = "";
$tipoMensaje = "";
$producto = null;
$cod_producto = "";

$db = new Database();
$conn = $db->connect();
$bajaProducto = new BajaProductos($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['buscar'])) {
        $cod_producto = trim($_POST['cod_producto'] ?? '');
        if ($cod_producto !== "") {
            $producto = $bajaProducto->buscarPorCodigo($cod_producto);
            if (!$producto) {
                //$mensaje = "No se encontró ningún producto con ese código.";
                $tipoMensaje = "warning";
            }
        } else {
            $mensaje = "Por favor ingrese un código de producto.";
            $tipoMensaje = "danger";
        }
    } elseif (isset($_POST['eliminar'])) {
        $id_producto = $_POST['id_producto'] ?? '';
        if ($id_producto !== "") {
            $filasEliminadas = $bajaProducto->eliminarPorId($id_producto);
            if ($filasEliminadas > 0) {
                $mensaje = "Producto eliminado correctamente.";
                $tipoMensaje = "success";
                $producto = null;
                $cod_producto = '';
            } else {
                $mensaje = "No se pudo eliminar el producto o ya fue eliminado.";
                $tipoMensaje = "danger";
            }
        } else {
            $mensaje = "ID de producto inválido para eliminar.";
            $tipoMensaje = "danger";
        }
    }
}
?>
