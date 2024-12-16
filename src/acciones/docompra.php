<?php
require_once('../p2/p2_lib.php');
include_once('../entity/usuarios.php');
session_start();
if (isset($_SESSION['objeto'])) {
$objeto = $_SESSION['objeto'];
    $carrito = json_decode($_COOKIE['carrito_'.$objeto->idUsuario]);
    $idComprador = $_SESSION['objeto']->idUsuario;
    foreach ($carrito as $producto) {
        $idProducto = $producto->id;
        $oferta = $producto->oferta;
        $valorOriginal = $producto->valorOriginal;
        $con = get_connection();
        if($oferta == $valorOriginal) {
            $sql = "UPDATE productos SET estadoProducto='reservado', oferta=:oferta, idComprador=:idComprador WHERE idProducto=:idProducto";
        }else {
            $sql = "UPDATE productos SET estadoProducto='negociacion-1', oferta=:oferta, idComprador=:idComprador WHERE idProducto=:idProducto";
        }
        $statement = $con->prepare($sql);
        $statement->bindParam(':idProducto',$idProducto, PDO::PARAM_INT);
        $statement->bindParam(':oferta',$oferta, PDO::PARAM_INT);
        $statement->bindParam(':idComprador',$idComprador, PDO::PARAM_INT);
        $resultado = $statement->execute();
        if($resultado) {
            setcookie('carrito_'.$objeto->idUsuario, '', time() - 3600, '/');
            header("Location:..\\ofertas.php");
        }
    }
}
?>