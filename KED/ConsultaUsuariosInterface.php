<?php require_once("ConsultaUsuariosController.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h1 class="text-center">CONSULTA DE USUARIOS</h1>

    <form action="" method="POST" class="mb-4">
        <div class="mb-3">
            <label for="id_usuario" class="form-label">Buscar por ID de usuario:</label>
            <input type="number" name="id_usuario" id="id_usuario" class="form-control" value="<?php echo htmlspecialchars($id_usuario); ?>">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
            <button type="submit" name="todo" class="btn btn-secondary">Mostrar todos</button>
        </div>
    </form>

    <?php if (count($lista) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Turno</th>
                        <th>Puesto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombres']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['turno']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['puesto']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p class="mt-3 text-danger fw-bold">¡No se encontraron usuarios!</p>
    <?php endif; ?>

    <div class="d-flex justify-content-center gap-2 mt-4">
        <a href="AltaUsuarios.php" class="btn btn-success">Nuevo usuario</a>
        <a href="CambioUsuariosInterface.php" class="btn btn-primary">Modificar Usuario</a>
        <a href="BajaUsuariosInterface.php" class="btn btn-danger">Eliminar Usuario</a>
    </div>
</div>
</body>
</html>
