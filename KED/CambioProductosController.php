<?php
require_once("CambioProductosModel.php");

$mensaje = "";
$producto = [];
$departamentos = [];
$proveedores = [];

$db = new Database();
$conexion = $db->connect();

$departamentos = $conexion->query("SELECT id_departamento, nombre FROM departamentos")->fetchAll(PDO::FETCH_ASSOC);
$proveedores = $conexion->query("SELECT id_proveedor, nombre FROM proveedores")->fetchAll(PDO::FETCH_ASSOC);

$modelo = new CambioProductos();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["buscar"])) {
        $cod_producto = trim($_POST["cod_producto"]);
        $producto = $modelo->buscarPorCodigo($cod_producto);
        if (!$producto) {
            $mensaje = "Producto no encontrado.";
        }
    }

    if (isset($_POST["actualizar"])) {
        $datos = [
            "cod_producto" => $_POST["cod_producto"],
            "nombre" => $_POST["nombre"],
            "costo" => $_POST["costo"],
            "utilidad" => $_POST["utilidad"],
            "precio" => $_POST["precio"],
            "inventario" => $_POST["inventario"],
            "id_departamento" => $_POST["id_departamento"],
            "id_proveedor" => $_POST["id_proveedor"]
        ];

        $resultado = $modelo->actualizar($datos);
        if ($resultado > 0) {
            $mensaje = "PRODUCTO ACTUALIZADO CON ÉXITO";
            $producto = $modelo->buscarPorCodigo($datos["cod_producto"]);
        } else {
            $mensaje = "No se pudo actualizar el producto o no hubo cambios.";
            $producto = $datos;
        }
    }
}
?>
