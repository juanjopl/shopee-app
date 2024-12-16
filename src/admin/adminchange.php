<?php
require_once('../p2/p2_lib.php');
$seleccion = $_POST['isAdmin'];
$idUsuario = $_POST['idUsuario'];

$con = get_connection();
$sql = "SELECT perfil FROM usuarios WHERE idUsuario = '$idUsuario';";
$statement = $con->prepare($sql);
$statement->execute();
$resultado = $statement->fetch(PDO::FETCH_ASSOC);
if($resultado['perfil'] == 1) {
    $estado = 0;
}else {
    $estado = 1;
}
$sql = "UPDATE usuarios SET perfil = :perfil WHERE idUsuario = :idUsuario";
$statement = $con->prepare($sql);
$statement->bindParam(':perfil',$estado);
$statement->bindParam(':idUsuario',$idUsuario);
$resultado = $statement->execute();
if($resultado) {
    $sql = "UPDATE usuarios SET estado = 'Desbloqueado' WHERE idUsuario = :idUsuario";
    $statement = $con->prepare($sql);
    $statement->bindParam(':idUsuario',$idUsuario);
    $resultado = $statement->execute();
    if($resultado) {
        header("Location:admin.php?seleccion=usuarios");
    }
}
?>