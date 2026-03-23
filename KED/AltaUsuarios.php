<?php
include_once("abarroteslauraDB.php");

$id_usuario = $contrasena = $nombres = $apellidos = $direccion = $correo = $turno = $puesto = "";
$mensaje = "";

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] != "POST" || isset($_POST["nuevo_usuario"])) {
    $query = $db->connect()->query("SHOW TABLE STATUS LIKE 'usuarios'");
    $tabla = $query->fetch();
    $id_usuario = $tabla['Auto_increment'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {
    $id_usuario = $_POST["id_usuario"];
    $contrasena = $_POST["contrasena"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $direccion = $_POST["direccion"];
    $correo = $_POST["correo"];
    $turno = $_POST["turno"];
    $puesto = $_POST["puesto"];

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $query = $db->connect()->prepare(
        "INSERT INTO usuarios (id_usuario, contrasena, nombres, apellidos, direccion, correo, turno, puesto)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $result = $query->execute([
        $id_usuario, $hash, $nombres, $apellidos, $direccion, $correo, $turno, $puesto
    ]);

    if ($result) {
        $mensaje = "USUARIO REGISTRADO CON ÉXITO";

        $query = $db->connect()->query("SHOW TABLE STATUS LIKE 'usuarios'");
        $tabla = $query->fetch();
        $id_usuario = $tabla['Auto_increment'];

        $contrasena = $nombres = $apellidos = $direccion = $correo = $turno = $puesto = "";
    } else {
        $mensaje = "NO SE PUDO REGISTRAR EL USUARIO";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Usuario</title>

  <!-- Tipografías -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald:wght@200..700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

  <style>
    body {
      background: #4F772D;
      font-family: 'Open Sans', sans-serif;
    }

    .container {
      max-width: 800px;
      margin-top: 40px;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-title {
      font-family: 'Oswald', sans-serif;
      text-align: center;
      font-size: 32px;
      margin-bottom: 30px;
      color: #3f1c00;
    }

    .form-group input, .form-group select {
      padding: 10px;
      font-size: 14px;
      border-radius: 5px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
      width: 100%;
    }

    .form-group input {
      background-color: #d5e0a4; /* Verde claro para los campos */
    }

    .form-group label {
      font-weight: bold;
      color: #3f1c00;
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
    }

    .btn-custom:hover {
      background-color: #542100;
    }

    .alert {
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="d-flex align-items-center justify-content-center mb-4">
    <img src="abarrotes_logo.png" alt="Logo" style="height: 50px; margin-right: 5px;">
    <h2 class="form-title m-0">REGISTRO</h2>
    </div>

    <!-- Mensaje de éxito o error -->
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <!-- Formulario de registro -->
    <form action="" method="POST">
      <!-- ID Asignado (solo lectura) -->
      <div class="form-group">
        <label for="id_usuario">ID Asignado</label>
        <input type="text" class="form-control" value="<?php echo $id_usuario; ?>" name="id_usuario" readonly>
      </div>

      <!-- Nombres -->
      <div class="form-group">
        <label for="nombres">Nombres</label>
        <input type="text" class="form-control" name="nombres" value="<?php echo $nombres; ?>" required autofocus>
      </div>

      <!-- Apellidos -->
      <div class="form-group">
        <label for="apellidos">Apellidos</label>
        <input type="text" class="form-control" name="apellidos" value="<?php echo $apellidos; ?>" required>
      </div>

      <!-- Contraseña -->
      <div class="form-group">
        <label for="contrasena">Contraseña</label>
        <input type="password" class="form-control" name="contrasena" required>
      </div>

      <!-- Dirección -->
      <div class="form-group">
        <label for="direccion">Dirección</label>
        <input type="text" class="form-control" name="direccion" value="<?php echo $direccion; ?>">
      </div>

      <!-- Correo -->
      <div class="form-group">
        <label for="correo">Correo</label>
        <input type="email" class="form-control" name="correo" value="<?php echo $correo; ?>">
      </div>

      <!-- Turno -->
      <div class="form-group">
        <label for="turno">Turno</label>
        <select name="turno" class="form-control" required>
          <option value="">Selecciona un turno</option>
          <option value="Matutino" <?php echo ($turno == "Matutino") ? "selected" : ""; ?>>Matutino</option>
          <option value="Vespertino" <?php echo ($turno == "Vespertino") ? "selected" : ""; ?>>Vespertino</option>
        </select>
      </div>

      <!-- Puesto -->
      <div class="form-group">
        <label for="puesto">Puesto</label>
        <select name="puesto" class="form-control" required>
          <option value="">Selecciona un puesto</option>
          <option value="Administrador" <?php echo ($puesto == "Administrador") ? "selected" : ""; ?>>Administrador</option>
          <option value="Cajero(a)" <?php echo ($puesto == "Cajero(a)") ? "selected" : ""; ?>>Cajero(a)</option>
        </select>
      </div>

      <!-- Botón para crear cuenta -->
      <button type="submit" name="guardar" class="btn-custom mb-3">CREAR CUENTA</button><br>
        <a href="login2.php" class="btn-custom d-block text-center" style="text-decoration: none;">INICIAR SESIÓN</a><br>
        <a href="Principal.php" class="btn-custom-warning d-block text-center" style="text-decoration: none;">VOLVER AL MENÚ</a>        
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
</body>
</html>
