<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {

    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $apellidoynombre = $registro["apellidoynombre"];
    $idpuesto = $registro["idpuesto"];
    $fechadeingreso = $registro["fechadeingreso"];
    $telefono = $registro["telefono"];
    $domicilio = $registro["domicilio"];
    $foto = $registro["foto"];
    $documentos = $registro["documentos"];

    $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos");
    $sentencia->execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

if ($_POST) {
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $apellidoynombre = (isset($_POST["apellidoynombre"])) ? $_POST["apellidoynombre"] : "";
    $domicilio = (isset($_POST["domicilio"])) ? $_POST["domicilio"] : "";
    $telefono = (isset($_POST["telefono"])) ? $_POST["telefono"] : "";
    $idpuesto = (isset($_POST["idpuesto"])) ? $_POST["idpuesto"] : "";
    $fechadeingreso = (isset($_POST["fechadeingreso"])) ? $_POST["fechadeingreso"] : "";

    //Preparamos
    $sentencia = $conexion->prepare("UPDATE tbl_empleados SET
        apellidoynombre=:apellidoynombre,
        domicilio=:domicilio,
        telefono=:telefono,
        idpuesto=:idpuesto,
        fechadeingreso=:fechadeingreso
        WHERE id=:id
    ");

    //Asignando
    $sentencia->bindParam(":apellidoynombre", $apellidoynombre);
    $sentencia->bindParam(":domicilio", $domicilio);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $foto = (isset($_FILES["foto"]['name'])) ? $_FILES["foto"]['name'] : "";

    $fecha_ = new DateTime();
    $nombredefoto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";

    $tmp_foto = $_FILES["foto"]['tmp_name'];

    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./" . $nombredefoto);

        $sentencia = $conexion->prepare("SELECT foto,documentos FROM tbl_empleados WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
            if (file_exists("./" . $registro_recuperado["foto"])) {
                unlink("./" . $registro_recuperado["foto"]);
            }
        }

        $sentencia = $conexion->prepare("UPDATE tbl_empleados SET foto=:foto WHERE id=:id");
        $sentencia->bindParam(":foto", $nombredefoto);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }

    $documentos = (isset($_FILES["documentos"]['name'])) ? $_FILES["documentos"]['name'] : "";

    $nombrededocumentos = ($documentos != '') ? $fecha_->getTimestamp() . "_" . $_FILES["documentos"]['name'] : "";
    $tmp_documentos = $_FILES["documentos"]['tmp_name'];

    if ($tmp_documentos != '') {
        move_uploaded_file($tmp_documentos, "./" . $nombrededocumentos);

        $sentencia = $conexion->prepare("SELECT documentos FROM tbl_empleados WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registro_recuperado["documentos"]) && $registro_recuperado["documentos"] != "") {
            if (file_exists("./" . $registro_recuperado["documentos"])) {
                unlink("./" . $registro_recuperado["documentos"]);
            }
        }

        $sentencia = $conexion->prepare("UPDATE tbl_empleados SET documentos=:documentos WHERE id=:id");
        $sentencia->bindParam(":documentos", $nombrededocumentos);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        
    }
    $mensaje="Registro Actualizado ";
    header("location:index.php?mensaje=".$mensaje);
}
?>

<?php include("../../templetes/header.php"); ?>

<br/> 

<div class="card">
    <div class="card-header">
        Datos del Empleado
    </div>
    <div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
    <label for="txtID" class="form-label">ID</label>
    <input type="text"
    value="<?php echo $txtID; ?>"
      class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
    
  </div>
    <br/>
    
    
    <div class="mb-3">
      <label for="apellidoynombre" class="form-label">Apellido y Nombre</label>
      <input type="text"
      value="<?php echo $apellidoynombre; ?>"
        class="form-control" name="apellidoynombre" id="apellidoynombre" aria-describedby="helpId" placeholder="Apellido y Nombre">
    </div>
    
    <div class="mb-3">
      <label for="domicilio" class="form-label">Domicilio</label>
      <input type="text"
      value="<?php echo $domicilio; ?>"
        class="form-control" name="domicilio" id="domicilio" aria-describedby="helpId" placeholder="Calle y Altura">
    </div>
    
    <div class="mb-3">
      <label for="telefono" class="form-label">Telefono</label>
      <input type="text"
      value="<?php echo $telefono; ?>"
        class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="Numero de Telefono">
    </div>

    <div class="mb-3">
        <label for="idpuesto" class="form-label">Puesto:</label>
        "<?php echo $idpuesto;?>"
        <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
        <?php foreach ($lista_tbl_puestos as $registro) { ?>    
        
            <option <?php echo ($idpuesto== $registro['id'])?"selected":""?> value="<?php echo $registro['id']?>">
            <?php echo $registro['nombredelpuesto']?>
            </option>
            <?php } ?>
        </select>
    </div>
    
    <div class="mb-3">
      <label for="fechadeingreso" class="form-label">Fecha de Ingreso</label>
      <input value="<?php echo $fechadeingreso; ?>"
      type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha de Ingreso">
      
    </div>
        
    
    <div class="mb-3">
  <label for="foto" class="form-label">Foto:</label>
  <br/>
  <img width="100" 
                    src="<?php echo $foto;?>" 
                    class="rounded" alt=""/>
                    <br/><br/>
  <input type="file"
    class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="">

    <div class="mb-3">
    <br/>  
    <label for="documentos" class="form-label">Documentos (PDF)</label>
    <br/>
    <a href="<?php echo $documentos; ?>" target="_blank"><?php echo $documentos; ?></a>
    <input type="file" class="form-control" name="documentos" id="documentos" placeholder="" aria-describedby="">
</div>


    <br/>
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


</div>

    </form>      



    </div>
    <div class="card-footer text-muted">
 
    </div>
</div>

<?php include("../../templetes/footer.php"); ?>