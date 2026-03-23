<?php
    class BajaUsuarios{
        private $conn;
        public function __construct($db){
            $this->conn = $db;
        }

        public function buscarPorId($id_usuario){
            $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
            $stmt->execute(['id_usuario'=>$id_usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function eliminarPorId($id_usuario){
            $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
            $stmt->execute(['id_usuario'=>$id_usuario]);
            return $stmt->rowCount();
        }
    }
?>