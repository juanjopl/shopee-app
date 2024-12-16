<?php
require_once('../entity/usuarios.php');
session_start();
if(isset($_SESSION['objeto'])) {
$objeto = $_SESSION['objeto'];
    if(isset($_POST['idProducto'])) {
        $idProducto = $_POST['idProducto'];
        $carrito = json_decode($_COOKIE['carrito_'.$objeto->idUsuario]);
        $i = array_search($idProducto, array_column($carrito,'id'));
        if($i !== false) {
            array_splice($carrito, $i,1);
            if(empty($carrito)) {
                setcookie('carrito_'.$objeto->idUsuario,'', time()-60,'/');
            }else {
                setcookie('carrito_'.$objeto->idUsuario,json_encode($carrito),time()+3600,'/');
            }
            header("Location:../carrito.php");
        }
    }
}
?>