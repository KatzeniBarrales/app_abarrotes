<?php
include_once("abarroteslauraDB.php");

class ConsultaDepartamentosModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function obtenerTodos() {
        $query = $this->db->connect()->query("SELECT * FROM departamentos");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorNombre($nombre) {
        $query = $this->db->connect()->prepare("SELECT * FROM departamentos WHERE nombre LIKE ?");
        $query->execute(["%" . $nombre . "%"]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
