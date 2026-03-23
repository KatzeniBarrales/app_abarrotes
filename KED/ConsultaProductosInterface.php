<?php
session_start();
require_once("abarroteslauraDB.php");
require_once("ConsultaProductosController.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuarioNombre = $_SESSION['usuario_nombre'] ?? 'Invitado';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Consulta de Productos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tipografías y estilos -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

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
      max-width: 1100px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
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
    }

    .menu-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      background-color: #244018;
    }

    .btn-action {
      font-family: 'Oswald', sans-serif;
    }
  </style>
</head>
<body>

  <!-- Encabezado fijo -->
  <div class="top-bar">
    <div class="container-fluid h-100">
      <div class="row h-100 align-items-center">
        <div class="col-3 ps-4">
          <img src="abarrotes_logo.png" alt="Logo" class="logo">
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

  <!-- Botones de navegación -->
  <div class="container my-4 d-flex justify-content-center gap-4 flex-wrap">
    <a href="ventas.php" class="btn menu-btn">VENTAS</a>
    <a href="ConsultaProductosInterface.php" class="btn menu-btn">PRODUCTOS</a>
    <a href="ConsultaProveedoresInterface.php" class="btn menu-btn">PROVEEDORES</a>
    <a href="ConsultaDepartamentosInterface.php" class="btn menu-btn">DEPARTAMENTOS</a>
    <a href="AltaUsuarios.php" class="btn menu-btn">USUARIOS</a>
    <a href="Principal.php" class="btn menu-btn">MENÚ DE INICIO</a>
  </div>

  <!-- Contenido principal -->
  <div class="main-content">
    <h2 class="mb-4 text-center">BUSCAR PRODUCTO</h2>

    <form action="" method="POST" class="mb-4">
      <div class="mb-3">
        <label for="cod_producto" class="form-label">Buscar por código:</label>
        <input type="text" name="cod_producto" id="cod_producto" class="form-control" value="<?= htmlspecialchars($cod_producto ?? '') ?>">
      </div>
      <div class="d-flex gap-2">
        <button type="submit" name="buscar" class="btn btn-primary btn-action">Buscar</button>
        <button type="submit" name="todo" class="btn btn-secondary btn-action">Mostrar todos</button>
      </div>
    </form>

    <?php if (count($lista) > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-dark text-center">
            <tr>
              <th>ID</th>
              <th>Código</th>
              <th>Nombre</th>
              <th>Costo</th>
              <th>Utilidad</th>
              <th>Precio</th>
              <th>Inventario</th>
              <th>Proveedor</th>
              <th>Departamento</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($lista as $producto): ?>
              <tr>
                <td><?= $producto['id_producto']; ?></td>
                <td><?= $producto['cod_producto']; ?></td>
                <td><?= $producto['nombre']; ?></td>
                <td>$<?= number_format($producto['costo'], 2); ?></td>
                <td>$<?= number_format($producto['utilidad'], 2); ?></td>
                <td>$<?= number_format($producto['precio'], 2); ?></td>
                <td><?= $producto['inventario']; ?></td>
                <td><?= $producto['nombre_proveedor']; ?></td>
                <td><?= $producto['nombre_departamento']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
      <p class="mt-3 text-danger fw-bold">¡No se encontraron productos!</p>
    <?php endif; ?>

    <div class="d-flex justify-content-center gap-2 mt-4 flex-wrap">
      <a href="ProductosAlta.php" class="btn btn-success btn-action">Nuevo producto</a>
      <a href="CambioProductosInterface.php" class="btn btn-primary btn-action">Modificar producto</a>
      <a href="BajaProductosInterface.php" class="btn btn-danger btn-action">Eliminar</a>
    </div>
  </div>

</body>
</html>
