<?php
require_once("ConsultaDepartamentosModel.php");

$modelo = new ConsultaDepartamentosModel();
$departamentos = [];
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscar"])) {
    $nombre = trim($_POST["nombre"] ?? "");
    
    if ($nombre !== "") {
        $departamentos = $modelo->buscarPorNombre($nombre);

        if (empty($departamentos)) {
            $mensaje = "No se encontraron departamentos con ese nombre.";
        }
    } else {
        $mensaje = "Por favor ingresa un nombre para buscar.";
    }
} else {
    $departamentos = $modelo->obtenerTodos();
}
