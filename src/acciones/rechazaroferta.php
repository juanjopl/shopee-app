<?php
require_once('../p2/p2_lib.php');
    if(isset($_POST['idProducto'])) {
        $con = get_connection();
        $sql = "UPDATE productos SET estadoProducto='activo', oferta=NULL, idComprador=NULL WHERE idProducto=:idProducto;";
        $statement = $con->prepare($sql);
        $statement->bindParam(":idProducto", $_POST["idProducto"], PDO::PARAM_INT);
        $resultado = $statement->execute();
        if($resultado) {
            header("Location:..\\misproductos.php");
        }
    }else {
        header("Location:..\\index.php");
    }
?>