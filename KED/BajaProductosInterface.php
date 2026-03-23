<?php
session_start();
require_once("abarroteslauraDB.php");
require_once("BajaProductosController.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuarioNombre = $_SESSION['usuario_nombre'] ?? 'Invitado';
$usuarioID = $_SESSION['usuario_id'];

$mensaje = "";
$tipoMensaje = "";
$producto = null;
$cod_producto = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['buscar'])) {
        $cod_producto = trim($_POST['cod_producto']);
        if ($cod_producto !== "") {
            $producto = $bajaProducto->buscarPorCodigo($cod_producto);
            if (!$producto) {
                $mensaje = "No se encontró ningún producto con ese código.";
                $tipoMensaje = "warning";
            }
        }
    } elseif (isset($_POST['eliminar'])) {
        $id_producto = $_POST['id_producto'] ?? "";
        if ($id_producto !== "") {
            $filasEliminadas = $bajaProducto->eliminarPorId($id_producto);
            if ($filasEliminadas > 0) {
                $mensaje = "Producto eliminado correctamente.";
                $tipoMensaje = "success";
                $producto = null;
                $cod_producto = "";
            } else {
                $mensaje = "No se pudo eliminar el producto o ya fue eliminado.";
                $tipoMensaje = "danger";
            }
        } else {
            $mensaje = "ID de producto inválido para eliminar.";
            $tipoMensaje = "danger";
        }
    }
}

// AJAX handler para eliminar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_eliminar'])) {
    $id_producto = $_POST['id_producto'] ?? "";
    $response = [];
    if ($id_producto !== "") {
        $filasEliminadas = $bajaProducto->eliminarPorId($id_producto);
        if ($filasEliminadas > 0) {
            $response = [
                "success" => true,
                "message" => "Producto eliminado correctamente."
            ];
        } else {
            $response = [
                "success" => false,
                "message" => "No se pudo eliminar el producto o ya fue eliminado."
            ];
        }
    } else {
        $response = [
            "success" => false,
            "message" => "ID de producto inválido para eliminar."
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Eliminar Producto</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald:wght@200..700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    input.form-control {
      background-color: #d5e0a4;
      border-radius: 5px;
      border: 1px solid #ccc;
      padding: 10px;
      font-size: 14px;
      margin-bottom: 20px;
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
    table.table {
      background-color: #fff;
    }
    th {
      background-color: #ecf39e;
    }
  </style>
</head>
<body>

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

  <div class="container my-4 d-flex justify-content-center gap-4 flex-wrap">
    <a href="ventas.php" class="btn menu-btn">VENTAS</a>
    <a href="ConsultaProductosInterface.php" class="btn menu-btn">PRODUCTOS</a>
    <a href="ConsultaProveedoresInterface.php" class="btn menu-btn">PROVEEDORES</a>
    <a href="AltaUsuarios.php" class="btn menu-btn">USUARIOS</a>
    <a href="Principal.php" class="btn menu-btn">MENÚ DE INICIO</a>
  </div>

  <div class="nav-secondary">
    <a href="ProductosAlta.php" class="btn btn-primary">NUEVO PRODUCTO</a>
    <a href="ConsultaProductosInterface.php" class="btn btn-secondary">BUSCAR PRODUCTO</a>
    <a href="CambioProductosInterface.php" class="btn btn-warning">MODIFICAR PRODUCTO</a>
  </div>

  <div class="main-content">
    <h2>Eliminar Producto</h2>

      
    <form method="post" id="formBuscar">
      <label for="cod_producto">Código del Producto:</label>
      <input type="text" name="cod_producto" id="cod_producto" class="form-control" required value="<?= htmlspecialchars($cod_producto) ?>" />
      <button type="submit" name="buscar" class="btn-custom mt-2">Buscar</button>
    </form>

    <?php if ($producto): ?>
      <h4 class="mt-4">Datos del Producto</h4>
      <table class="table table-bordered">
        <tr><th>Código</th><td><?= htmlspecialchars($producto["cod_producto"]) ?></td></tr>
        <tr><th>Nombre</th><td><?= htmlspecialchars($producto["nombre"]) ?></td></tr>
        <tr><th>Costo</th><td><?= htmlspecialchars($producto["costo"]) ?></td></tr>
        <tr><th>Utilidad (%)</th><td><?= htmlspecialchars($producto["utilidad"]) ?></td></tr>
        <tr><th>Precio</th><td><?= htmlspecialchars($producto["precio"]) ?></td></tr>
        <tr><th>Inventario</th><td><?= htmlspecialchars($producto["inventario"]) ?></td></tr>
        <tr><th>Departamento</th><td><?= htmlspecialchars($producto["id_departamento"]) ?></td></tr>
        <tr><th>Proveedor</th><td><?= htmlspecialchars($producto["id_proveedor"]) ?></td></tr>
      </table>

      <form method="post" id="formEliminar">
        <input type="hidden" name="id_producto" value="<?= htmlspecialchars($producto["id_producto"]) ?>" />
        <button type="submit" name="eliminar" class="btn btn-danger w-100 mt-3">Eliminar Producto</button>
      </form>
    <?php endif; ?>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // SweetAlert para producto no encontrado
      <?php if ($mensaje && $tipoMensaje === "warning"): ?>
        Swal.fire({
          icon: 'warning',
          title: 'Producto no encontrado',
          text: <?= json_encode($mensaje) ?>
        });
      <?php endif; ?>

      const formEliminar = document.getElementById("formEliminar");
      <?php if ($producto): ?>
      // Pasar los datos del producto a JS
      const productoDatos = {
        codigo: "<?= htmlspecialchars($producto["cod_producto"]) ?>",
        nombre: "<?= htmlspecialchars($producto["nombre"]) ?>",
        costo: "<?= htmlspecialchars($producto["costo"]) ?>",
        utilidad: "<?= htmlspecialchars($producto["utilidad"]) ?>",
        precio: "<?= htmlspecialchars($producto["precio"]) ?>",
        inventario: "<?= htmlspecialchars($producto["inventario"]) ?>",
        departamento: "<?= htmlspecialchars($producto["id_departamento"]) ?>",
        proveedor: "<?= htmlspecialchars($producto["id_proveedor"]) ?>"
      };
      <?php endif; ?>
      if (formEliminar) {
        formEliminar.addEventListener("submit", function (e) {
          e.preventDefault();
          let detalles = "";
          if (typeof productoDatos !== "undefined") {
            detalles =
              `<b>Código:</b> ${productoDatos.codigo}<br>` +
              `<b>Nombre:</b> ${productoDatos.nombre}<br>` +
              `<b>Costo:</b> ${productoDatos.costo}<br>` +
              `<b>Utilidad (%):</b> ${productoDatos.utilidad}<br>` +
              `<b>Precio:</b> ${productoDatos.precio}<br>` +
              `<b>Inventario:</b> ${productoDatos.inventario}<br>` +
              `<b>Departamento:</b> ${productoDatos.departamento}<br>` +
              `<b>Proveedor:</b> ${productoDatos.proveedor}<br>`;
          }
          Swal.fire({
            title: "¿Estás seguro?",
            html: "Esta acción no se puede deshacer.<br><br><b>Producto a eliminar:</b><br>" + detalles,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#aaa",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
          }).then((result) => {
            if (result.isConfirmed) {
              // AJAX para eliminar sin recargar el diseño
              const formData = new FormData();
              formData.append('ajax_eliminar', '1');
              formData.append('id_producto', formEliminar.querySelector('[name="id_producto"]').value);
              fetch(window.location.href, {
                method: 'POST',
                body: formData
              })
              .then(response => response.json())
              .then(data => {
                Swal.fire({
                  icon: data.success ? 'success' : 'error',
                  title: data.success ? 'Eliminado' : 'Error',
                  text: data.message
                }).then(() => {
                  if (data.success) {
                    window.location.reload();
                  }
                });
              })
              .catch(() => {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'No se pudo eliminar el producto.'
                });
              });
            }
          });
        });
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
