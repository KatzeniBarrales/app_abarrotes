<?php
include_once("abarroteslauraDB.php");

$nombre = "";
$mensaje = "";
$id_departamento = "";

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] != "POST" || isset($_POST["nuevo_departamento"])) {
    $query = $db->connect()->query("SHOW TABLE STATUS LIKE 'departamentos'");
    $tabla = $query->fetch();
    $id_departamento = $tabla['Auto_increment'];

$nombre = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {
    $nombre  = $_POST["nombre"] ?? "";

    $query = $db->connect()->prepare(
        "INSERT INTO departamentos (nombre)
         VALUES (?)"
    );

        $result = $query->execute([$nombre]);

    if ($result) {
        $mensaje = "EL DEPARTAMENTO FUE DADO DE ALTA";

        $query = $db->connect()->query("SHOW TABLE STATUS LIKE 'departamentos'");
        $tabla = $query->fetch();
        $id_departamentos = $tabla['Auto_increment'];

    $departamentos = "";
    } else {
        $mensaje = "NO SE PUDO REGISTRAR EL DEPARTAMENTO";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUEVO DEPARTAMENTO</title>
</head>
<body>
    <h1>NUEVO DEPARTAMENTO</h1>
    <?php if ($mensaje): ?>
        <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form action="" method="post" autocomplete="on">

       <div class="mb-2">
            <label for="id_departamento" class="form-label text-dark">ID:</label>
            <input type="text"  class="form-control" readonly value="<?php echo $id_departamento; ?>">
        </div>  
       <div class="mb-2">
            <label for="nombre" class="form-label text-dark">Nombre del departamento:</label>
            <input type="text" name="nombre" id="nombre" class="form-control"  value="<?php echo $nombre; ?>">
        </div>

        <div class="col-md-4">
             <input type="submit" name="guardar" value="Guardar" class="btn btn-success w-100">
        </div>
        <div class="col-md-4">
            <input type="submit" name="nuevo_departamento" value="Nuevo departamento" class="btn btn-secondary w-100">
        </div>
    </form>
</body>
</html>