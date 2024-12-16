<?php
require_once("../entity/usuarios.php");
session_start();

if (isset($_SESSION["objeto"])) {
    $objeto = $_SESSION['objeto'];
} else {
    header("Location: ..\\index.php");
}
setcookie('carrito_'.$objeto->idUsuario, '', time() - 3600, '/');
header("Location: ..\\index.php");
?>