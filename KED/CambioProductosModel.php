<?php
require_once("abarroteslauraDB.php");

class CambioProductos {
    private $conexion;

    public function __construct(){
        $db = new Database();
        $this->conexion = $db->connect();
    }

    public function buscarPorCodigo($cod_producto){
        $sql = "SELECT * FROM productos WHERE cod_producto = :cod_producto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(['cod_producto' => $cod_producto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($datos){
        $sql = "UPDATE productos SET 
                    nombre = :nombre,
                    costo = :costo,
                    utilidad = :utilidad,
                    precio = :precio,
                    inventario = :inventario,
                    id_departamento = :id_departamento,
                    id_proveedor = :id_proveedor
                WHERE cod_producto = :cod_producto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            'nombre' => $datos['nombre'],
            'costo' => $datos['costo'],
            'utilidad' => $datos['utilidad'],
            'precio' => $datos['precio'],
            'inventario' => $datos['inventario'],
            'id_departamento' => $datos['id_departamento'],
            'id_proveedor' => $datos['id_proveedor'],
            'cod_producto' => $datos['cod_producto']
        ]);
        return $stmt->rowCount();
    }
}
?>
