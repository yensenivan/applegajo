<?php
include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    
    // Buscar ARC
    $sentencia = $conexion->prepare("SELECT foto, documentos FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_ASSOC);

    if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != ""){
        if(file_exists("./".$registro_recuperado["foto"])){
            unlink("./".$registro_recuperado["foto"]);
        }
    }

    if(isset($registro_recuperado["documentos"]) && $registro_recuperado["documentos"] != ""){
        if(file_exists("./".$registro_recuperado["documentos"])){
            unlink("./".$registro_recuperado["documentos"]);
        }
    }

    $sentencia = $conexion->prepare("DELETE FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    header("location:index.php");
    exit;
}

$sentencia = $conexion->prepare("SELECT *,
    (SELECT nombredelpuesto FROM tbl_puestos WHERE tbl_puestos.id = tbl_empleados.idpuesto LIMIT 1) as puesto
    FROM tbl_empleados");
$sentencia->execute();
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templetes/header.php"); ?>

<br/>
<div class="text-center">
    <h4>Gestión de Empleados</h4>
</div>
<div class="card">
    <div class="card-header">
    
        <a class="btn btn-primary" href="crear.php" role="button">Agregar Empleado</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Apellido y Nombre</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fecha de Ingreso</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Domicilio</th>
                        <th scope="col">Documentos</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_empleados as $registro) { ?>
                        <tr>
                            <td><?php echo $registro['id']; ?></td>
                            <td>
                                <img width="50" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt=""/>
                            </td>
                            <td><?php echo $registro['apellidoynombre']; ?></td>
                            <td><?php echo $registro['puesto']; ?></td>
                            <td><?php echo $registro['fechadeingreso']; ?></td>
                            <td><?php echo $registro['telefono']; ?></td>
                            <td><?php echo $registro['domicilio']; ?></td>
                            <td>
                                <a href="<?php echo $registro['documentos']; ?>" target="_blank" class="btn btn-primary btn-sm">Ver PDF</a>
                            </td>
                            <td>
                                <a class="btn btn-info btn-sm" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button"><i class="fas fa-edit"></i> Editar</a>
                                <a class="btn btn-danger btn-sm" href="javascript:borrar(<?php echo $registro['id']; ?>)" role="button"><i class="fas fa-trash"></i> Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../templetes/footer.php"); ?>
