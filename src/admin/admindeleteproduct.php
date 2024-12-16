<?php
require_once('../p2/p2_lib.php');
    $idProducto = $_POST['idProducto'];

    $con = get_connection();
    $sql = "DELETE FROM fotosproductos WHERE idProducto= $idProducto;";
    $statement = $con->prepare($sql);
    $resultado = $statement->execute();
    if($resultado) {
        $sql = "DELETE FROM productos WHERE idProducto = $idProducto;";
        $statement = $con->prepare($sql);
        $resultado = $statement->execute();
        if($resultado) {
            header("Location:admin.php?seleccion=productos");
        }
    }
?>