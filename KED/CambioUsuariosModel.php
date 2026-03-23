<?php
require_once("abarroteslauraDB.php");

class CambioUsuarios {
    private $conexion;

    public function __construct() {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    public function buscarPorID($id_usuario) {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($datos) {
        $sql = "UPDATE usuarios SET 
                    contrasena = :contrasena,
                    nombres = :nombres,
                    apellidos = :apellidos,
                    direccion = :direccion,
                    correo = :correo,
                    turno = :turno,
                    puesto = :puesto
                WHERE id_usuario = :id_usuario";
        $stmt = $this->conexion->prepare($sql);

        $hash = password_hash($datos['contrasena'], PASSWORD_DEFAULT);

        $stmt->execute([
            'contrasena' => $hash,
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'direccion' => $datos['direccion'],
            'correo' => $datos['correo'],
            'turno' => $datos['turno'],
            'puesto' => $datos['puesto'],
            'id_usuario' => $datos['id_usuario']
        ]);

        return $stmt->rowCount();
    }
}
?>
