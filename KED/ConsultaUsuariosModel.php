<?php
require_once("abarroteslauraDB.php");

class ConsultaUsuarios {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function buscarPorID($id_usuario) {
        $query = $this->db->prepare("
            SELECT * 
            FROM usuarios 
            WHERE id_usuario = :id_usuario
        ");
        $query->execute(['id_usuario' => $id_usuario]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerTodos() {
        $query = $this->db->prepare("
            SELECT * 
            FROM usuarios 
            ORDER BY id_usuario ASC
        ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
