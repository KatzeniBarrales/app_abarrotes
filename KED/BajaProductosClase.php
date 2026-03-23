<?php
class BajaProductos {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Devuelve el primer producto que encuentre con el código (fetch)
    public function buscarPorCodigo($cod_producto){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM productos WHERE cod_producto = :cod_producto LIMIT 1");
            $stmt->execute(['cod_producto' => $cod_producto]);
            return $stmt->fetch(PDO::FETCH_ASSOC);  // Solo 1 producto (el primero)
        } catch (PDOException $e) {
            // Aquí puedes registrar el error si quieres
            return false;
        }
    }

    // Eliminar producto por id_producto (clave primaria única)
    public function eliminarPorId($id_producto){
        try {
            $stmt = $this->conn->prepare("DELETE FROM productos WHERE id_producto = :id_producto");
            $stmt->execute(['id_producto' => $id_producto]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // Aquí puedes registrar el error si quieres
            return 0;
        }
    }
}
?>
