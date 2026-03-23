<?php require_once("ConsultaDepartamentosController.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Departamentos</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Consulta de Departamentos</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-warning"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <form method="post" class="mb-3">
        <label for="nombre">Buscar por nombre:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Lácteos">
        <button type="submit" name="buscar" class="btn btn-primary mt-2">Buscar</button>
    </form>

    <?php if (!empty($departamentos)): ?>
        <table class="table table-bordered">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departamentos as $dep): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($dep["id_departamento"]); ?></td>
                        <td><?php echo htmlspecialchars($dep["nombre"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
