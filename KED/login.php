<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="KED.png">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body class="bg-light">
  <div class="d-flex justify-content-center align-items-center vh-100" style="background-color:#132A13;">
    <div class="rounded p-4 shadow" style="background-color:#90A955; width: 100%; max-width: 400px;">
      <img src="abarrotes_logo.png" alt="" class="d-block mx-auto">
      <form action="" method="post">
        <div class="mb-3">
          <label for="usuario" class="form-label fw-semibold">USUARIO:</label>
          <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingresa tu usuario" required>
        </div>
        <div class="mb-3">
          <label for="contrasena" class="form-label fw-semibold">CONTRASEÑA:</label>
          <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingresa tu contraseña">
        </div><br>
        <button type="submit" class="w-100 rounded" style="background-color: #31572C;">INGRESAR</button><br><br>
        <button type="submit" class="w-100 rounded " style="background-color:rgb(43, 118, 114);">CREAR NUEVO USUARIO</button>
      </form>
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>