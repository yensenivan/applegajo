<?php
include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";

    // Eliminar registros relacionados en tbl_empleados
    $sentencia_empleados = $conexion->prepare("DELETE FROM tbl_empleados WHERE idpuesto=:id");
    $sentencia_empleados->bindParam(":id", $txtID);
    $sentencia_empleados->execute();

    // Eliminar el registro en tbl_puestos
    $sentencia_puestos = $conexion->prepare("DELETE FROM tbl_puestos WHERE id=:id");
    $sentencia_puestos->bindParam(":id", $txtID);
    $sentencia_puestos->execute();

    $mensaje = "Registro Eliminado";
    header("location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM tbl_puestos");
$sentencia->execute();
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Resto del código HTML -->


<?php include("../../templetes/header.php"); ?>

<br/>
<div class="text-center">
    <h4>Lista de Puestos</h4>
</div>
<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="crear.php" role="button">Agregar Puesto</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del Puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_puestos as $registro) { ?>
                        <tr>
                            <td scope="row"><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['nombredelpuesto']; ?></td>
                            <td>
                                <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                                <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>)" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../templetes/footer.php"); ?>
