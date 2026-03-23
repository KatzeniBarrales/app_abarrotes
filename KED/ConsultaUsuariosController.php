<?php
require_once("ConsultaUsuariosModel.php");

$id_usuario = "";
$usuariosModel = new ConsultaUsuarios();
$lista = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["buscar"])) {
        $id_usuario = $_POST["id_usuario"] ?? "";
        if ($id_usuario !== "") {
            $usuario = $usuariosModel->buscarPorID($id_usuario);
            $lista = $usuario ? [$usuario] : [];
        }
    }
    if (isset($_POST["todo"])) {
        $lista = $usuariosModel->obtenerTodos();
    }
}
?>
