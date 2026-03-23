<?php
require_once("CambioUsuariosController.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Modificar Usuario</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <form method="post" class="mb-4">
        <label for="id_usuario">ID del Usuario:</label>
        <input type="number" name="id_usuario" id="id_usuario" class="form-control" required
            value="<?php echo isset($_POST["id_usuario"]) ? htmlspecialchars($_POST["id_usuario"]) : ''; ?>" />
        <button type="submit" name="buscar" class="btn btn-primary mt-2">Buscar</button>
    </form>

    <?php if (!empty($usuario)): ?>
            <form method="post">
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario["id_usuario"]); ?>" />

            <div class="mb-3">
                <label>Nombres:</label>
                <input type="text" name="nombres" class="form-control" required value="<?php echo htmlspecialchars($usuario["nombres"]); ?>" />
            </div>

            <div class="mb-3">
                <label>Apellidos:</label>
                <input type="text" name="apellidos" class="form-control" required value="<?php echo htmlspecialchars($usuario["apellidos"]); ?>" />
            </div>

            <div class="mb-3">
                <label>Contraseña (dejar vacío para no cambiar):</label>
                <input type="password" name="contrasena" class="form-control" />
            </div>

            <div class="mb-3">
                <label>Dirección:</label>
                <input type="text" name="direccion" class="form-control" value="<?php echo htmlspecialchars($usuario["direccion"]); ?>" />
            </div>

            <div class="mb-3">
                <label>Correo:</label>
                <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($usuario["correo"]); ?>" />
            </div>

            <div class="mb-3">
                <label>Turno:</label>
                <select name="turno" class="form-control" required>
                    <option value="">Selecciona un turno</option>
                    <option value="Matutino" <?php echo ($usuario["turno"] == "Matutino") ? "selected" : ""; ?>>Matutino</option>
                    <option value="Vespertino" <?php echo ($usuario["turno"] == "Vespertino") ? "selected" : ""; ?>>Vespertino</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Puesto:</label>
                <select name="puesto" class="form-control" required>
                    <option value="">Selecciona un puesto</option>
                    <option value="Administrador" <?php echo ($usuario["puesto"] == "Administrador") ? "selected" : ""; ?>>Administrador</option>
                    <option value="Cajero(a)" <?php echo ($usuario["puesto"] == "Cajero(a)") ? "selected" : ""; ?>>Cajero(a)</option>
                </select>
            </div>

            <button type="submit" name="actualizar" class="btn btn-success">Guardar Cambios</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
