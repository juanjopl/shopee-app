<?php
require_once('../p2/p2_lib.php');
    if(isset($_POST['idProducto'])) {
        $idProducto = $_POST['idProducto'];
        $estadoProducto = $_POST['estadoProducto'];
        $contraoferta = $_POST['contraoferta'];
        $con = get_connection();
        switch($estadoProducto) {
            case 'negociacion-1':
                $sql = "UPDATE productos SET oferta=:contraoferta, estadoProducto='negociacion-2' WHERE idProducto=:idProducto";
                break;
            case 'negociacion-2':
                $sql = "UPDATE productos SET oferta=:contraoferta, estadoProducto='negociacion-3' WHERE idProducto=:idProducto";
                break;
        }
        $statement = $con->prepare($sql);
        $statement->bindParam(":contraoferta", $contraoferta, PDO::PARAM_INT);
        $statement->bindParam(':idProducto',$idProducto,PDO::PARAM_INT);
        $resultado = $statement->execute();
        if($resultado) {
            header("Location:..\\ofertas.php");
        }
    }else {
        header("Location:..\\index.php");
    }
?>