<?php
    require_once('../entity/usuarios.php');
    include_once('../entity/productos.php');
    $idUsuario = $_POST['idUsuario'];

    $con = get_connection();
    $sql = "DELETE FROM fotosproductos WHERE idProducto IN (SELECT idProducto FROM productos WHERE idVendedor = $idUsuario);";
    $statement = $con->prepare($sql);
    $resultado = $statement->execute();
    if($resultado) {
        $sql = "DELETE FROM productos WHERE idVendedor = $idUsuario;";
        $statement = $con->prepare($sql);
        $resultado = $statement->execute();
        if($resultado) {
            $sql = "DELETE FROM usuarios WHERE idUsuario = $idUsuario";
            $statement = $con->prepare($sql);
            $resultado = $statement->execute();
            if($resultado) {
                header("Location:admin.php?seleccion=usuarios");
            }
        }
    }
    
?>