<?php
session_start();
require_once("abarroteslauraDB.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuarioNombre = $_SESSION['usuario_nombre'] ?? 'Invitado';
$usuarioID = $_SESSION['usuario_id'];

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['carrito'] = [];
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST['accion'] ?? '';

    switch ($accion) {
        case 'agregar':
            $cod_producto = $_POST["codigo"] ?? '';
            if ($cod_producto) {
                $stmt = $db->connect()->prepare("SELECT id_producto, cod_producto, nombre, precio FROM productos WHERE cod_producto = :cod_producto");
                $stmt->execute(['cod_producto' => $cod_producto]);
                $producto = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($producto) {
                    $yaExiste = false;
                    foreach ($_SESSION['carrito'] as $index => $item) {
                        if ($item['cod_producto'] === $producto['cod_producto']) {
                            $_SESSION['carrito'][$index]['cantidad'] += 1;
                            $yaExiste = true;
                            break;
                        }
                    }
                    if (!$yaExiste) {
                        $producto['cantidad'] = 1;
                        $_SESSION['carrito'][] = $producto;
                    }
                } else {
                    $error = "Producto no encontrado.";
                }
            }
            break;

        case 'eliminar':
            $indice = $_POST['eliminar'] ?? null;
            if ($indice !== null && isset($_SESSION['carrito'][$indice])) {
                unset($_SESSION['carrito'][$indice]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
            }
            break;

        case 'reiniciar':
            $_SESSION['carrito'] = [];
            break;

        case 'guardar_venta':
            if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
                $error = "No hay productos en el carrito para registrar la venta.";
                break;
            }

            try {
                $conexion = $db->connect();
                $conexion->beginTransaction();

                $id_usuario = $_SESSION['usuario_id'];
                date_default_timezone_set('America/Mexico_City');
                $fecha = date('Y-m-d H:i:s');
                $total_venta = 0;

                foreach ($_SESSION['carrito'] as $item) {
                    $total_venta += $item['precio'] * $item['cantidad'];
                }

                $stmtVenta = $conexion->prepare("
                    INSERT INTO ventas (id_usuario, fecha, total) 
                    VALUES (:id_usuario, :fecha, :total)
                ");
                $stmtVenta->execute([
                    ':id_usuario' => $id_usuario,
                    ':fecha' => $fecha,
                    ':total' => $total_venta
                ]);
                $id_venta = $conexion->lastInsertId();

                $stmtDetalle = $conexion->prepare("
                    INSERT INTO detalle_venta 
                    (id_venta, id_usuario, id_producto, cantidad, precio_unitario, subtotal)
                    VALUES 
                    (:id_venta, :id_usuario, :id_producto, :cantidad, :precio_unitario, :subtotal)
                ");

                foreach ($_SESSION['carrito'] as $item) {
                    if (!isset($item['id_producto'])) {
                        throw new Exception("Producto sin ID: " . json_encode($item));
                    }

                    $subtotal = $item['precio'] * $item['cantidad'];

                    $stmtDetalle->execute([
                        ':id_venta' => $id_venta,
                        ':id_usuario' => $id_usuario,
                        ':id_producto' => $item['id_producto'],
                        ':cantidad' => $item['cantidad'],
                        ':precio_unitario' => $item['precio'],
                        ':subtotal' => $subtotal
                    ]);
                }

                $conexion->commit();

                $_SESSION['carrito'] = []; 
                $_SESSION['venta_realizada'] = true;

                header("Location: ventas.php");
                exit;

            } catch (Exception $e) {
                $conexion->rollBack();
                $error = "Error al registrar la venta: " . $e->getMessage();
            }
            break;
    }
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ventas - Abarrotes Laura</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: url('principalverduras.png') no-repeat center center fixed;
      background-size: cover;
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
      max-width: 1000px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    }

    .btn-custom {
      background-color: #3f1c00;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-family: 'Oswald', sans-serif;
      border: none;
    }

    .btn-custom:hover {
      background-color: #542100;
    }

    .menu-btn {
      background-color: #90A955;
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
  </style>
</head>
<body>

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

  <div class="container my-4 d-flex justify-content-center gap-4 flex-wrap">
    <a href="ConsultaProductosInterface.php" class="btn menu-btn">PRODUCTOS</a>
    <a href="ConsultaProveedoresInterface.php" class="btn menu-btn">PROVEEDORES</a>
    <a href="ConsultaDepartamentosInterface.php" class="btn menu-btn">DEPARTAMENTOS</a>
    <a href="AltaUsuarios.php" class="btn menu-btn">USUARIOS</a>
    <a href="DetalleVentaInterface.php" class="btn menu-btn">CONSULTAR VENTAS</a>
    <a href="Principal.php" class="btn menu-btn">MENÚ DE INICIO</a>
  </div>

  <div class="main-content mt-4">
    <h2 class="mb-3 text-center">Registro de Venta</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="ventas.php" class="mb-3">
        <input type="hidden" name="accion" value="agregar" />
        <div class="input-group">
            <input type="text" name="codigo" class="form-control" placeholder="Código del producto" required />
            <button class="btn btn-custom" type="submit">Agregar</button>
        </div>
    </form>

    <?php if (!empty($_SESSION['carrito'])): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['carrito'] as $index => $item):
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?= htmlspecialchars($item['cod_producto']) ?></td>
                    <td><?= htmlspecialchars($item['nombre']) ?></td>
                    <td>$<?= number_format($item['precio'], 2) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td>$<?= number_format($subtotal, 2) ?></td>
                    <td>
                        <form method="post" action="ventas.php" style="display:inline;">
                            <input type="hidden" name="accion" value="eliminar" />
                            <input type="hidden" name="eliminar" value="<?= $index ?>" />
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="text-end">Total: $<?= number_format($total, 2) ?></h4>

        <form method="post" action="ventas.php" class="d-inline" id="formCobrar">
            <input type="hidden" name="accion" value="guardar_venta" />
            <button type="button" class="btn btn-success" id="btnCobrar">
                Cobrar
            </button>
        </form>

        <form method="post" action="ventas.php" class="mt-3">
            <input type="hidden" name="accion" value="reiniciar" />
            <button type="submit" class="btn btn-warning">Nueva Venta</button>
        </form>

    <?php else: ?>
        <p class="text-center text-dark fw-bold">No hay productos en la venta.</p>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // SweetAlert para venta realizada con éxito
      <?php if (!empty($_SESSION['venta_realizada'])): ?>
        Swal.fire({
          icon: 'success',
          title: 'VENTA REALIZADA CON ÉXITO',
          confirmButtonColor: '#3f1c00'
        });
        <?php unset($_SESSION['venta_realizada']); ?>
      <?php endif; ?>

      const btnCobrar = document.getElementById("btnCobrar");
      const formCobrar = document.getElementById("formCobrar");
      if (btnCobrar && formCobrar) {
        btnCobrar.addEventListener("click", function (e) {
          Swal.fire({
            title: "¿Confirmas realizar la venta?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#aaa",
            confirmButtonText: "Sí, cobrar",
            cancelButtonText: "Cancelar"
          }).then((result) => {
            if (result.isConfirmed) {
              formCobrar.submit();
            }
          });
        });
      }
    });
  </script>
</body>
</html>
