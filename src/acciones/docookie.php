<?php
require_once('../entity/usuarios.php');
session_start();
if(isset($_SESSION['objeto'])) {
$objeto = $_SESSION['objeto'];
    if(isset($_POST['añadirCarrito'])) {
        $idProducto = $_POST['añadirCarrito'];
        $valorOriginal = $_POST['valorOriginal'];
        $oferta = $_POST['valorOriginal'];
        if(isset($_POST['oferta']) && $_POST['oferta'] !== "" && $_POST['oferta'] > 0) {
            $oferta = $_POST['oferta'];
        }
        if(isset($_COOKIE['carrito_'.$objeto->idUsuario])) {
            $carrito = json_decode($_COOKIE['carrito_'.$objeto->idUsuario], true);
        } else {
            $carrito = [];
        }        
        $i = array_search($idProducto, array_column($carrito, 'id'));
        if($i !== false) {
            $carrito[$i]['oferta'] = $oferta;
            $carrito[$i]['valorOriginal'] = $valorOriginal;
        } else {
            $nuevoProducto = [
                'id' => $idProducto,
                'valorOriginal' => $valorOriginal,
                'oferta' => $oferta
            ];
            $carrito[] = $nuevoProducto;
        }
        setcookie('carrito_'.$objeto->idUsuario, json_encode($carrito), time() + 3600, '/');
        header("Location:..\\carrito.php");
        exit();
    }
}
?>