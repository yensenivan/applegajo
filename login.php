<?php
session_start();

if ($_POST) {
    include("./bd.php");

    $sentencia = $conexion->prepare("SELECT *, count(*) as n_usuarios 
                                    FROM tbl_usuarios 
                                    WHERE usuario=:usuario
                                    AND password=:password");

    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
    if ($registro["n_usuarios"] > 0) {
        $_SESSION['usuario'] = $registro["usuario"];
        $_SESSION['logueado'] = true;
        header("Location: index.php");
        exit;
    } else {
        $mensaje = "Error: El usuario o la contraseña son incorrectos.";
    }
}
?>


<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
    }

    .card {
      width: 300px;
      border: none;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #007bff;
      color: #fff;
      text-align: center;
    }

    .card-body {
      padding: 20px;
    }

    .form-label {
      font-weight: bold;
    }

    .btn-primary {
      width: 100%;
      background-color: #007bff;
      border-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }

    .alert {
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>

      <div class="col-md-4">
        <br />
        <div class="card">
          <div class="card-header text-center">
            Iniciar Sesión
          </div>
          <div class="card-body">

            <?php if (isset($mensaje)) { ?>
            <div class="alert alert-danger" role="alert">
              <strong><?php echo $mensaje; ?></strong>
            </div>
            <?php } ?>

            <form action="" method="post">
              <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" name="usuario" id="usuario"
                  placeholder="Escriba su usuario" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password"
                  placeholder="Escriba su contraseña" required>
              </div>
              <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>

          </div>

        </div>
      </div>
      <div class="col-md-4"></div>
    </div>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz"
    crossorigin="anonymous"></script>
</body>

</html>
