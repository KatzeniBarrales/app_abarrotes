<?php
require_once("CambioUsuariosModel.php");

$mensaje = "";
$usuario = [];

$modelo = new CambioUsuarios();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["buscar"])) {
        $id_usuario = trim($_POST["id_usuario"]);
        $usuario = $modelo->buscarPorID($id_usuario);
        if (!$usuario) {
            $mensaje = "Usuario no encontrado.";
        }
    }

    if (isset($_POST["actualizar"])) {
        $datos = [
            "id_usuario" => $_POST["id_usuario"],
            "contrasena" => $_POST["contrasena"],
            "nombres" => $_POST["nombres"],
            "apellidos" => $_POST["apellidos"],
            "direccion" => $_POST["direccion"],
            "correo" => $_POST["correo"],
            "turno" => $_POST["turno"],
            "puesto" => $_POST["puesto"]
        ];

        $resultado = $modelo->actualizar($datos);
        if ($resultado > 0) {
            $mensaje = "Usuario actualizado correctamente.";
            $usuario = $modelo->buscarPorID($datos["id_usuario"]);
        } else {
            $mensaje = "No se pudo actualizar el usuario o no hubo cambios.";
            $usuario = $datos;
        }
    }
}
?>
