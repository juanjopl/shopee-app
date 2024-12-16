<?php
    require_once('../p2/p2_lib.php');

    $idUsuario = $_POST['idUsuario'];
    $con = get_connection();
    $sql = "SELECT estado FROM usuarios WHERE idUsuario = '$idUsuario';";
    $statement = $con->prepare($sql);
    $statement->execute();
    $resultado = $statement->fetch(PDO::FETCH_ASSOC);
    if($resultado['estado'] == 'Desbloqueado') {
        $estado = 'Bloqueado';
    }else {
        $estado = "Desbloqueado";
    }
    $sql = "UPDATE usuarios SET estado = :estado WHERE idUsuario = :idUsuario";
    $statement = $con->prepare($sql);
    $statement->bindParam(':estado',$estado);
    $statement->bindParam(':idUsuario',$idUsuario);
    $resultado = $statement->execute();
    if($resultado) {
        header("Location:admin.php?seleccion=usuarios");
    }
?>