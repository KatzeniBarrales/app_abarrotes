<?php
require_once("ConsultaProductosModel.php");

$cod_producto = "";
$productos = new ConsultaProductos();
$lista = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["buscar"])) {
        $cod_producto = $_POST["cod_producto"] ?? "";
        $lista = $productos->buscarPorCodigo($cod_producto);
    }
    if (isset($_POST["todo"])) {
        $lista = $productos->obtenerTodos();
    }
}
?>
