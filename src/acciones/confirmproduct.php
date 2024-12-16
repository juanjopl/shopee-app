<?php
require_once('../p2/p2_lib.php');
    if(isset($_POST['idProducto'])) {
        $idProducto = $_POST['idProducto'];
        $con = get_connection();
        $sql = "UPDATE productos SET estadoProducto = 'comprado' WHERE idProducto = :idProducto;";
        $statement = $con->prepare($sql);
        $statement->bindParam(":idProducto", $idProducto, PDO::PARAM_INT);
        $resultado = $statement->execute();
        if($resultado) {
            header('Location:..\\ofertas.php');
        }
    }else {
        header('Location:..\\index.php');
    }
?>