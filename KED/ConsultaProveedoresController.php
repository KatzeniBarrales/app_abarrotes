<?php
require_once("ConsultaProveedoresModel.php");

$modelo = new ConsultaProveedoresModel();
$proveedores = [];
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["buscar"])) {
        $id = trim($_POST["id_proveedor"] ?? "");

        if ($id !== "") {
            $proveedores = $modelo->buscarPorID($id);

            if (empty($proveedores)) {
                $mensaje = "No se encontraron proveedores con ese ID.";
            }
        } else {
            $mensaje = "Por favor ingresa un id
             para buscar.";
        }
    } elseif (isset($_POST["mostrar_todos"])) {
        // Mostrar todos si se presiona un botón específico
        $proveedores = $modelo->obtenerTodos();
    }
} else {
    // Si es la primera vez que se carga, también se muestran todos
    $proveedores = $modelo->obtenerTodos();
}
?>
