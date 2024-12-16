<?php
    require_once('../entity/productos.php');
    $idProducto = $_POST['idProducto'];

    $con = get_connection();
    $sql = "DELETE FROM fotosproductos WHERE idProducto IN (SELECT idProducto FROM productos WHERE idProducto = $idProducto);";
    $statement = $con->prepare($sql);
    $resultado = $statement->execute();
    if($resultado) {
        $sql = "DELETE FROM productos WHERE idProducto = $idProducto;";
        $statement = $con->prepare($sql);
        $resultado = $statement->execute();
        if($resultado) {
            header('Location:..\\misproductos.php');
        }
    }
?>