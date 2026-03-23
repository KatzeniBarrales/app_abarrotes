<?php
session_start();
include_once("abarroteslauraDB.php");

$mensaje = "";
$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    $nombre = $_POST["nombres"] ?? "";
    $contrasena = $_POST["contrasena"] ?? "";

    if ($nombre && $contrasena) {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombres = :nombres");
        $stmt->execute(['nombres' => $nombre]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            // ✅ Guardar datos del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nombre'] = $usuario['nombres'];

            header("Location: ventas.php");
            exit();
        } else {
            $mensaje = "Acceso denegado";
        }
    } else {
        $mensaje = "Por favor ingresa nombre y contraseña.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>

    <!-- Tipografías -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #4F772D;
            font-family: 'Open Sans', sans-serif;
        }

        .container {
            max-width: 500px;
            margin-top: 40px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-family: 'Oswald', sans-serif;
            font-size: 28px;
            color: #3f1c00;
            margin-bottom: 25px;
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

        .header-bar {
            background-color: #ECF39E;
            padding: 10px 0;
            height: 70px;
            margin-bottom: 30px;
        }

        .logo {
            height: 50px;
        }

        .header-title {
            font-family: 'Oswald', sans-serif;
            font-size: 24px;
            color: black;
            text-align: center;
            margin: 0;
        }
    </style>
</head>
<body>

    <!-- Encabezado -->
    <div class="header-bar">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-auto">
                    <img src="abarrotes_logo.png" alt="Logo" class="logo">
                </div>
                <div class="col text-start">
                    <h3 class="header-title">ABARROTES LAURA</h3>
                </div>
                <div class="col-3 d-flex align-items-center justify-content-end">
                <span style="font-family: 'Oswald', sans-serif; font-size: 16px; color: #3f1c00; margin-left: 10px;">EL ABARROTE CONECTADO</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="container">
        <h2 class="form-title text-center">INICIAR SESIÓN</h2>

        <?php if ($mensaje): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <form action="" method="post" autocomplete="off">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" name="nombres" id="nombres" class="form-control" required value="<?php echo isset($_POST['nombres']) ? htmlspecialchars($_POST['nombres']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
            </div>

            <button type="submit" name="login" class="btn-custom mb-3">ENTRAR</button>
            <a href="AltaUsuarios.php" class="btn-custom d-block text-center" style="text-decoration: none;">REGISTRARSE</a><br>        
            <a href="Principal.php" class="btn-custom-warning d-block text-center" style="text-decoration: none;">VOLVER AL MENÚ</a>        
        </form>
    </div>

</body>
</html>
