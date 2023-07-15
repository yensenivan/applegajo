<?php
include("../../bd.php");

if($_POST){
print_r($_POST);
  
  //Recolectamos   
  $nombredelpuesto=(isset($_POST["nombredelpuesto"])?$_POST["nombredelpuesto"]:"");
  //Preparamos
  $sentencia=$conexion->prepare("INSERT INTO tbl_puestos(id,nombredelpuesto)
              VALUES (null, :nombredelpuesto)");
  //Asignando
  $sentencia->bindParam(":nombredelpuesto",$nombredelpuesto);               
  $sentencia->execute();
  $mensaje="Registro Creado";
  header("location:index.php?mensaje=".$mensaje);;
}

?>

<?php include("../../templetes/header.php"); ?>

<br/>

<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">

    <div class="mb-3">
      <label for="nombredelpuesto" class="form-label">Nombre del puesto:
      </label>
      <input type="text"
        class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del Puesto">
        </div>
       <button type="submiy" class="btn btn-primary">Agregar</button>
       <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
    



    </form>   
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templetes/footer.php"); ?>