<?php
require_once("abarroteslauraDB.php");

class ConsultaProductos {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function buscarPorCodigo($cod_producto) {
        $query = $this->db->prepare("
            SELECT p.*, 
                   pr.nombre AS nombre_proveedor, 
                   d.nombre AS nombre_departamento
            FROM productos p
            JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
            JOIN departamentos d ON p.id_departamento = d.id_departamento
            WHERE p.cod_producto = :cod_producto
        ");
        $query->execute(['cod_producto' => $cod_producto]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTodos() {
        $query = $this->db->prepare("
            SELECT p.*, 
                   pr.nombre AS nombre_proveedor, 
                   d.nombre AS nombre_departamento
            FROM productos p
            JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor
            JOIN departamentos d ON p.id_departamento = d.id_departamento
            ORDER BY p.cod_producto ASC
        ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
