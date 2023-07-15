<?php
include("../../bd.php");

if($_POST){

 //Recolectamos   
 $usuario=(isset($_POST["usuario"])?$_POST["usuario"]:"");
 $password=(isset($_POST["password"])?$_POST["password"]:"");
 $correo=(isset($_POST["correo"])?$_POST["correo"]:"");

 //Preparamos
 $sentencia=$conexion->prepare("INSERT INTO tbl_usuarios (id,usuario,password,correo)
 VALUES (NULL,:usuario,:password,:correo)");

 //Asignando
 $sentencia->bindParam(":usuario",$usuario);
 $sentencia->bindParam(":password",$password);
 $sentencia->bindParam(":correo",$correo);
 $sentencia->execute();
 $mensaje="Registro Creado";
 header("location:index.php?mensaje=".$mensaje);
}
?>


<?php include("../../templetes/header.php"); ?>

<br/>

<div class="card">
    <div class="card-header">
        Nuevo Usuario
    </div>
    <div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">

    <div class="mb-3">
      <label for="usuario" class="form-label">Nombre de Usuario:
      </label>
      <input type="text"
        class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre de Usuario">
        </div>
       
       <div class="mb-3">
      <label for="password" class="form-label">Contraseña:</label>
      <input type="password"
        class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Escribir Contraseña">
    </div>

    <div class="mb-3">
      <label for="correo" class="form-label">Correo:</label>
      <input type="email"
        class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Escribir Correo">
    </div>

        <button type="submiy" class="btn btn-primary">Agregar</button>
       <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
    



    </form>   
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templetes/footer.php"); ?>