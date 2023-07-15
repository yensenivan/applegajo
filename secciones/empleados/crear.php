<?php
include("../../bd.php");

if ($_POST) {
    // Recolectamos los datos
    $apellidoynombre = isset($_POST["apellidoynombre"]) ? $_POST["apellidoynombre"] : "";
    $domicilio = isset($_POST["domicilio"]) ? $_POST["domicilio"] : "";
    $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
    $idpuesto = isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "";
    $fechadeingreso = isset($_POST["fechadeingreso"]) ? $_POST["fechadeingreso"] : "";

    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : "";
    $documentos = isset($_FILES["documentos"]["name"]) ? $_FILES["documentos"]["name"] : "";

    // Preparamos la sentencia SQL
    $sentencia = $conexion->prepare("INSERT INTO tbl_empleados
        (apellidoynombre, idpuesto, fechadeingreso, telefono, foto, domicilio, documentos)
        VALUES (:apellidoynombre, :idpuesto, :fechadeingreso, :telefono, :foto, :domicilio, :documentos)");

    // Asignamos los valores a los parámetros de la sentencia
    $sentencia->bindParam(":apellidoynombre", $apellidoynombre);
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
    $sentencia->bindParam(":telefono", $telefono);
    $sentencia->bindParam(":domicilio", $domicilio);
    
    $fecha_ = new DateTime();
    $nombredefoto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]["name"] : "";
    $tmp_foto = $_FILES["foto"]["tmp_name"];
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./" . $nombredefoto);
    }
    $sentencia->bindParam(":foto", $nombredefoto);
    
    $nombrededocumentos = ($documentos != '') ? $fecha_->getTimestamp() . "_" . $_FILES["documentos"]["name"] : "";
    $tmp_documentos = $_FILES["documentos"]["tmp_name"];
    if ($tmp_documentos != '') {
        move_uploaded_file($tmp_documentos, "./" . $nombrededocumentos);
    }
    $sentencia->bindParam(":documentos", $nombrededocumentos);

    // Ejecutamos la sentencia SQL
    $sentencia->execute();

    $mensaje = "Registro Creado";
    header("location:index.php?mensaje=" . $mensaje);
    exit;
}

{
    $sentencia = $conexion->prepare("SELECT * FROM tbl_puestos");
    $sentencia->execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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

            <br/>
            <div class="mb-3">
                <label for="apellidoynombre" class="form-label">Apellido y Nombre</label>
                <input type="text" class="form-control" name="apellidoynombre" id="apellidoynombre" aria-describedby="helpId" placeholder="Apellido y Nombre">
            </div>

            <div class="mb-3">
                <label for="domicilio" class="form-label">Domicilio</label>
                <input type="text" class="form-control" name="domicilio" id="domicilio" aria-describedby="helpId" placeholder="Calle y Altura">
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="Número de Teléfono">
            </div>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>
                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_tbl_puestos as $registro) { ?>
                        <option value="<?php echo $registro['id']; ?>">
                            <?php echo $registro['nombredelpuesto']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fechadeingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha de Ingreso">
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
            </div>

            <div class="mb-3">
                <label for="documentos" class="form-label">Documentos (PDF)</label>
                <input type="file" class="form-control" name="documentos" id="documentos" placeholder="documentos" aria-describedby="Documentos (PDF)">
            </div>

            <br/>
            <button type="submit" class="btn btn-success">Agregar Empleado</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
    <div class="card-footer text-muted">
    </div>
</div>

<?php include("../../templetes/footer.php"); ?>
