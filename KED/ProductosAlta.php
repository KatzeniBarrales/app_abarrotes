<?php
include_once("abarroteslauraDB.php");
session_start();

$usuarioNombre = $_SESSION['usuario_nombre'] ?? '';

$cod_producto = $nombre = $costo = $utilidad = $precio = $inventario = "";
$mensaje = "";
$id_producto = "";

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] != "POST" || isset($_POST["nuevo_producto"])) {
    $query = $db->connect()->query("SHOW TABLE STATUS LIKE 'productos'");
    $tabla = $query->fetch();
    $id_producto = $tabla['Auto_increment'];

    $query = $db->connect()->query("SELECT id_departamento, nombre FROM departamentos");
    $departamentos = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $db->connect()->query("SELECT id_proveedor, nombre FROM proveedores");
    $proveedores = $query->fetchAll(PDO::FETCH_ASSOC);

    $cod_producto = $nombre = $costo = $utilidad = $precio = $inventario = "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {
    $cod_producto    = $_POST["cod_producto"];
    $nombre  = $_POST["nombre"] ?? "";
    $costo = $_POST["costo"];
    $utilidad   = $_POST["utilidad"];
    $precio = $_POST["precio"];
    $inventario    = $_POST["inventario"];
    $id_departamento = $_POST['id_departamento'];
    $id_proveedor = $_POST['id_proveedor'];

    $query = $db->connect()->prepare(
        "INSERT INTO productos (cod_producto, nombre, costo, utilidad, precio, inventario, id_departamento, id_proveedor)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $result = $query->execute([
        $cod_producto, $nombre, $costo, $utilidad, $precio,
        $inventario, $id_departamento, $id_proveedor
    ]);

    if ($result) {
        $mensaje = "EL PRODUCTO FUE DADO DE ALTA";

        $query = $db->connect()->query("SHOW TABLE STATUS LIKE 'productos'");
        $tabla = $query->fetch();
        $id_producto = $tabla['Auto_increment'];

        $cod_producto = $nombre = $costo = $utilidad = $precio = $inventario = "";
    } else {
        $mensaje = "NO SE PUDO REGISTRAR EL PRODUCTO";
    }

    $query = $db->connect()->query("SELECT id_departamento, nombre FROM departamentos");
    $departamentos = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $db->connect()->query("SELECT id_proveedor, nombre FROM proveedores");
    $proveedores = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Alta de Productos</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald:wght@200..700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

  <style>
    body {
      background: #4F772D;
      font-family: 'Open Sans', sans-serif;
    }

    .top-bar {
      background-color: #ECF39E;
      padding: 10px 0;
      height: 70px;
    }

    .logo {
      height: 50px;
    }

    .top-title {
      font-family: 'Oswald', sans-serif;
      font-size: 24px;
      color: black;
      text-align: center;
      margin: 0;
    }

    .container {
      max-width: 800px;
      margin-top: 40px;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .form-title {
      font-family: 'Oswald', sans-serif;
      text-align: center;
      font-size: 32px;
      margin-bottom: 30px;
      color: #3f1c00;
    }

    label {
      font-weight: bold;
      color: #3f1c00;
    }

    input.form-control, select.form-control {
      background-color: #d5e0a4;
      border-radius: 5px;
      border: 1px solid #ccc;
      padding: 10px;
      font-size: 14px;
      margin-bottom: 20px;
    }

    input[readonly] {
      background-color: #c7d48a;
    }

    .btn-custom {
      background-color: #3f1c00;
      color: white;
      padding: 12px;
      border-radius: 5px;
      font-family: 'Oswald', sans-serif;
      width: 100%;
      border: none;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }

    .btn-custom:hover {
      background-color: #542100;
      color: white;
    }

    .alert {
      text-align: center;
    }

    .btn-group-extra > .btn {
      margin-right: 10px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-3 d-flex align-items-center">
          <img src="abarrotes_logo.png" alt="Logo" class="logo">
          <span style="font-family: 'Oswald', sans-serif; font-size: 16px; color: #3f1c00; margin-left: 10px;">EL ABARROTE CONECTADO</span>
        </div>
        <div class="col-6">
          <h3 class="top-title">ABARROTES LAURA</h3>
        </div>
        <div class="col-3 d-flex align-items-center justify-content-end">
          <?php if ($usuarioNombre): ?>
            <span style="font-family: 'Oswald', sans-serif; font-size: 16px; color: #3f1c00;">Usuario: <?php echo htmlspecialchars($usuarioNombre); ?></span>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="mb-4">
      <h2 class="form-title m-0">ALTA DE PRODUCTOS</h2>
    </div>

    <?php if ($mensaje && $mensaje !== "EL PRODUCTO FUE DADO DE ALTA"): ?>
      <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form action="" method="POST" autocomplete="on">
      <div class="mb-3">
        <label for="id_producto">ID Asignado</label>
        <input type="text" class="form-control" id="id_producto" value="<?php echo $id_producto; ?>" readonly />
      </div>

      <div class="mb-3">
        <label for="cod_producto">Código del producto</label>
        <input type="text" name="cod_producto" id="cod_producto" class="form-control" value="<?php echo htmlspecialchars($cod_producto); ?>" required autofocus />
      </div>

      <div class="mb-3">
        <label for="nombre">Nombre del producto</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre); ?>" required />
      </div>

      <div class="mb-3">
        <label for="costo">Precio de costo</label>
        <input type="number" step="0.01" name="costo" id="costo" class="form-control" value="<?php echo htmlspecialchars($costo); ?>" required />
      </div>

      <div class="mb-3">
        <label for="utilidad">Utilidad (%)</label>
        <input type="number" step="0.01" name="utilidad" id="utilidad" class="form-control" value="<?php echo htmlspecialchars($utilidad); ?>" required />
      </div>

      <div class="mb-3">
        <label for="precio">Precio de venta</label>
        <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="<?php echo htmlspecialchars($precio); ?>" readonly />
      </div>

      <div class="mb-3">
        <label for="id_departamento">Departamento</label>
        <select name="id_departamento" id="id_departamento" class="form-control" required>
          <option value="">Selecciona un departamento</option>
          <?php foreach ($departamentos as $dep): ?>
            <option value="<?php echo $dep['id_departamento']; ?>" <?php echo (isset($_POST['id_departamento']) && $_POST['id_departamento'] == $dep['id_departamento']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($dep['nombre']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="id_proveedor">Proveedor</label>
        <select name="id_proveedor" id="id_proveedor" class="form-control" required>
          <option value="">Selecciona un proveedor</option>
          <?php foreach ($proveedores as $prov): ?>
            <option value="<?php echo $prov['id_proveedor']; ?>" <?php echo (isset($_POST['id_proveedor']) && $_POST['id_proveedor'] == $prov['id_proveedor']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($prov['nombre']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="inventario">Cantidad en inventario</label>
        <input type="number" name="inventario" id="inventario" class="form-control" value="<?php echo htmlspecialchars($inventario); ?>" required />
      </div>

      <button type="submit" name="guardar" class="btn-custom">Guardar</button>

      <div class="btn-group-extra d-flex flex-wrap gap-2 mt-3">
        <a href="CambioProductosInterface.php" class="btn btn-primary flex-grow-1">Modificar Producto</a>
        <a href="ConsultaProductosInterface.php" class="btn btn-info flex-grow-1">Buscar Producto</a>
        <a href="BajaProductosInterface.php" class="btn btn-danger flex-grow-1">Eliminar Producto</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // SweetAlert para alta exitosa
      <?php if ($mensaje === "EL PRODUCTO FUE DADO DE ALTA"): ?>
        Swal.fire({
          icon: 'success',
          title: 'EL PRODUCTO FUE DADO DE ALTA',
          confirmButtonColor: '#3f1c00'
        });
      <?php endif; ?>

      const costoInput = document.getElementById("costo");
      const utilidadInput = document.getElementById("utilidad");
      const precioInput = document.getElementById("precio");

      function calcularPrecioVenta() {
        const costo = parseFloat(costoInput.value) || 0;
        const utilidad = parseFloat(utilidadInput.value) || 0;
        const precioVenta = costo + (costo * utilidad / 100);
        precioInput.value = precioVenta.toFixed(2);
      }

      costoInput.addEventListener("input", calcularPrecioVenta);
      utilidadInput.addEventListener("input", calcularPrecioVenta);
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</html>
