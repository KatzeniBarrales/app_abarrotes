<?php require_once("BajaUsuariosController.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Eliminar Usuario</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo htmlspecialchars($tipoMensaje); ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <form method="post" class="mb-4">
        <label for="id_usuario">ID del Usuario:</label>
        <input type="number" name="id_usuario" id="id_usuario" class="form-control" required
            value="<?php echo isset($_POST["id_usuario"]) ? htmlspecialchars($_POST["id_usuario"]) : ''; ?>" />
        <button type="submit" name="buscar" class="btn btn-primary mt-2">Buscar</button>
    </form>

    <?php if (!empty($usuario)): ?>
        <h4>Datos del Usuario</h4>
        <table class="table table-bordered">
            <tr><th>ID</th><td><?php echo htmlspecialchars($usuario["id_usuario"]); ?></td></tr>
            <tr><th>Nombres</th><td><?php echo htmlspecialchars($usuario["nombres"]); ?></td></tr>
            <tr><th>Apellidos</th><td><?php echo htmlspecialchars($usuario["apellidos"]); ?></td></tr>
            <tr><th>Dirección</th><td><?php echo htmlspecialchars($usuario["direccion"]); ?></td></tr>
            <tr><th>Correo</th><td><?php echo htmlspecialchars($usuario["correo"]); ?></td></tr>
            <tr><th>Turno</th><td><?php echo htmlspecialchars($usuario["turno"]); ?></td></tr>
            <tr><th>Puesto</th><td><?php echo htmlspecialchars($usuario["puesto"]); ?></td></tr>
        </table>

        <form method="post">
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario["id_usuario"]); ?>" />
            <button type="submit" name="eliminar" class="btn btn-danger"
                onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">
                Eliminar Usuario
            </button>
        </form>
    <?php elseif (isset($_POST["buscar"])): ?>
        <div class="alert alert-warning">Usuario no encontrado.</div>
    <?php endif; ?>
</div>
</body>
</html>
