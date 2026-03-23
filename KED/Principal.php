<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Abarrotes Laura</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

  <style>
    body {
      background: url('principalverduras.png') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      font-family: 'Open Sans', sans-serif;
    }

    .top-bar {
      background-color: #ECF39E;
      padding: 10px 0;
      height: 70px;
    }

    .logo {
      height: 50px;
    }

    .top-title {
      font-family: 'Oswald', sans-serif;
      font-size: 24px;
      color: black;
      text-align: center;
      margin: 0;
    }

    .center-buttons {
      position: absolute;
      top: 60%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
    }

    .btn-custom {
      background-color: #3f1c00;
      color: white;
      margin: 0 10px;
      padding: 10px 30px;
      border-radius: 5px;
      letter-spacing: 2px;
      font-family: 'Oswald', sans-serif;
      border: none;
    }
  </style>
</head>
<body>
  <div class="top-bar">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-3">
          <img src="abarrotes_logo.png" alt="Logo" class="logo">
        </div>
        <div class="col-6">
          <h3 class="top-title">ABARROTES LAURA</h3>
        </div>
        <div class="col-3 d-flex align-items-center justify-content-end">
          <span style="font-family: 'Oswald', sans-serif; font-size: 16px; color: #3f1c00; margin-left: 10px;">EL ABARROTE CONECTADO</span>
        </div>
      </div>
    </div>
  </div>

  <div class="center-buttons">
    <a href="AltaUsuarios.php" class="btn-custom">Registro</a>
    <a href="login2.php" class="btn-custom">Inicio</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>

</body>
</html>
