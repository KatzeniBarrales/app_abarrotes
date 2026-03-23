<?php
include_once("abarroteslauraDB.php");

class ConsultaProveedoresModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function obtenerTodos() {
        $query = $this->db->connect()->query("SELECT * FROM proveedores");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorID($id) {
        $query = $this->db->connect()->prepare("SELECT * FROM proveedores WHERE id_proveedor LIKE ?");
        $query->execute(["%" . $id . "%"]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
