<?php
require_once("abarroteslauraDB.php");
require_once("BajaUsuariosClase.php");

$db = new Database();
$conn = $db->connect();

$bajaUsuarios = new BajaUsuarios($conn);

$usuario = null;
$mensaje = "";
$tipoMensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['buscar'])) {
        $id_usuario = trim($_POST['id_usuario'] ?? "");
        if ($id_usuario !== "") {
            $usuario = $bajaUsuarios->buscarPorId($id_usuario);
            if (!$usuario) {
                $mensaje = "Usuario no encontrado.";
                $tipoMensaje = "warning";
            }
        } else {
            $mensaje = "Por favor ingrese un ID de usuario.";
            $tipoMensaje = "danger";
        }
    }

    if (isset($_POST['eliminar'])) {
        $id_usuario = trim($_POST['id_usuario'] ?? "");
        if ($id_usuario !== "") {
            $filasEliminadas = $bajaUsuarios->eliminarPorId($id_usuario);
            if ($filasEliminadas > 0) {
                $mensaje = "Usuario eliminado correctamente.";
                $tipoMensaje = "success";
                $usuario = null;
            } else {
                $mensaje = "No se pudo eliminar el usuario o no existe.";
                $tipoMensaje = "danger";
            }
        } else {
            $mensaje = "ID de usuario inválido para eliminar.";
            $tipoMensaje = "danger";
        }
    }
}
?>
