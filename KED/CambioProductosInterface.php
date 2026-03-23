<?php
session_start();
require_once("abarroteslauraDB.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuarioNombre = $_SESSION['usuario_nombre'] ?? 'Invitado';
$usuarioID = $_SESSION['usuario_id'];

require_once("CambioProductosController.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Modificar Producto</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald:wght@200..700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

  <style>
    body {
      background-color: #90A955;
      font-family: 'Open Sans', sans-serif;
      margin: 0;
      padding-top: 90px;
    }

    .top-bar {
      background-color: #ECF39E;
      height: 70px;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .logo {
      height: 50px;
    }

    .top-title {
      font-family: 'Oswald', sans-serif;
      font-size: 24px;
      color: black;
      margin: 0;
    }

    .user-info {
      font-weight: bold;
      font-size: 16px;
      text-align: right;
    }

    .main-content {
      background-color: #ffffffee;
      padding: 30px;
      border-radius: 10px;
      margin: auto;
      max-width: 900px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    }

    h2 {
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

    input.form-control,
    select.form-control {
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
    }

    .menu-btn {
      background-color: #2d501f;
      color: white;
      padding: 12px 30px;
      border-radius: 6px;
      font-family: 'Oswald', sans-serif;
      font-weight: 600;
      font-size: 15px;
      letter-spacing: 2px;
      text-transform: uppercase;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      text-decoration: none;
      margin: 5px;
      text-align: center;
      display: inline-block;
    }

    .menu-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      background-color: #244018;
    }

    .nav-secondary {
      max-width: 900px;
      margin: 10px auto 30px;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
    }

    .alert {
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Encabezado fijo -->
  <div class="top-bar">
    <div class="container-fluid h-100">
      <div class="row h-100 align-items-center">
        <div class="col-3 ps-4">
          <img src="abarrotes_logo.png" alt="Logo" class="logo" />
        </div>
        <div class="col-6 text-center">
          <h3 class="top-title">ABARROTES LAURA</h3>
        </div>
        <div class="col-3 text-end pe-4 user-info">
          Usuario: <?= htmlspecialchars($usuarioNombre) ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Menú de navegación principal -->
  <div class="container my-4 d-flex justify-content-center gap-4 flex-wrap">
    <a href="ventas.php" class="btn menu-btn">VENTAS</a>
    <a href="ConsultaProductosInterface.php" class="btn menu-btn">PRODUCTOS</a>
    <a href="ConsultaProveedoresInterface.php" class="btn menu-btn">PROVEEDORES</a>
    <a href="AltaUsuarios.php" class="btn menu-btn">USUARIOS</a>
    <a href="Principal.php" class="btn menu-btn">MENÚ DE INICIO</a>
  </div>

  <!-- Menú secundario -->
  <div class="nav-secondary">
    <a href="ProductosAlta.php" class="btn btn-primary">NUEVO PRODUCTO</a>
    <a href="ConsultaProductosInterface.php" class="btn btn-warning">BUSCAR PRODUCTO</a>
    <a href="BajaProductosInterface.php" class="btn btn-danger">ELIMINAR PRODUCTO</a>
  </div>

  <!-- Contenido principal -->
  <div class="main-content">
    <h2>Modificar Producto</h2>

    <?php if (!empty($mensaje) && $mensaje !== "PRODUCTO ACTUALIZADO CON ÉXITO"): ?>
      <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="post">
      <label for="cod_producto">Código del Producto:</label>
      <input
        type="text"
        name="cod_producto"
        id="cod_producto"
        class="form-control"
        required
        value="<?= isset($_POST["cod_producto"]) ? htmlspecialchars($_POST["cod_producto"]) : '' ?>"
      />
      <button type="submit" name="buscar" class="btn-custom">Buscar</button>
    </form>
    <hr>

    <?php if (!empty($producto)): ?>
      <form method="post">
        <input type="hidden" name="cod_producto" value="<?= htmlspecialchars($producto["cod_producto"]) ?>" />

        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" required value="<?= htmlspecialchars($producto["nombre"]) ?>" />

        <label>Costo:</label>
        <input type="number" name="costo" step="0.01" class="form-control" required value="<?= htmlspecialchars($producto["costo"]) ?>" />

        <label>Utilidad (%):</label>
        <input type="number" name="utilidad" step="0.01" class="form-control" required value="<?= htmlspecialchars($producto["utilidad"]) ?>" />

        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" class="form-control" readonly value="<?= htmlspecialchars($producto["precio"]) ?>" />

        <label>Inventario:</label>
        <input type="number" name="inventario" class="form-control" required value="<?= htmlspecialchars($producto["inventario"]) ?>" />

        <label>Departamento:</label>
        <select name="id_departamento" class="form-control" required>
          <option value="">Selecciona</option>
          <?php foreach ($departamentos as $dep): ?>
            <option value="<?= $dep["id_departamento"] ?>" <?= $dep["id_departamento"] == $producto["id_departamento"] ? 'selected' : '' ?>>
              <?= htmlspecialchars($dep["nombre"]) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label>Proveedor:</label>
        <select name="id_proveedor" class="form-control" required>
          <option value="">Selecciona</option>
          <?php foreach ($proveedores as $prov): ?>
            <option value="<?= $prov["id_proveedor"] ?>" <?= $prov["id_proveedor"] == $producto["id_proveedor"] ? 'selected' : '' ?>>
              <?= htmlspecialchars($prov["nombre"]) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <button type="submit" name="actualizar" class="btn-custom">Guardar Cambios</button>
      </form>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      <?php if (!empty($mensaje) && $mensaje === "PRODUCTO ACTUALIZADO CON ÉXITO"): ?>
        Swal.fire({
          icon: 'success',
          title: 'PRODUCTO ACTUALIZADO CON ÉXITO',
          confirmButtonColor: '#3f1c00'
        });
      <?php endif; ?>

      const costoInput = document.querySelector('input[name="costo"]');
      const utilidadInput = document.querySelector('input[name="utilidad"]');
      const precioInput = document.querySelector('input[name="precio"]');

      function calcularPrecio() {
        const costo = parseFloat(costoInput.value) || 0;
        const utilidad = parseFloat(utilidadInput.value) || 0;
        const precio = costo + (costo * utilidad) / 100;
        precioInput.value = precio.toFixed(2);
      }

      costoInput.addEventListener("input", calcularPrecio);
      utilidadInput.addEventListener("input", calcularPrecio);
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</html>
