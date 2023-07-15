<?php 
session_start();  
$url_base="http://localhost/app/";

if(!isset($_SESSION['usuario'])){
  header("Location:".$url_base."login.php");

}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" 
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" 
    crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</head>
<body>
  <header>
    <!-- place navbar here -->
  </header>
  
  <div class="navbar-container">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo $url_base;?>">Sistema</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url_base;?>secciones/empleados/">Empleados</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url_base;?>secciones/puestos/">Puestos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url_base;?>secciones/usuarios/">Usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url_base;?>cerrar.php">Cerrar Sesion</a>
        </li>
      </ul>
    </div>
  </nav>
</div>

  
  
  
  
  <main class="container">
  <?php if(isset($_GET['mensaje'])) { ?>
<script>
    Swal.fire({icon:"success", title:"<?php echo $_GET['mensaje']; ?>"});
</script>
 <?php } ?>