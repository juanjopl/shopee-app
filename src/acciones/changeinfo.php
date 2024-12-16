<?php
require_once("../config.php");
require_once("../entity/usuarios.php");
require_once("../p2/p2_lib.php");
session_start();
$objeto = $_SESSION['objeto'];
$oldpass = $_POST['pass'];

$datos = array(
    'username' => $_POST['username'],
    'email' => $_POST['email'],
    'direccion' => $_POST['direccion'],
    'nombre' => $_POST['nombre'],
    'apellido1' => $_POST['apellido1'],
    'apellido2' => $_POST['apellido2'],
    'pass' => $_POST['newpass'],
    'perfil' => 0,
    'fechaModificacion' => date("Y-m-d H:i:s")
);
if ($oldpass == "" && $datos['pass'] == "" || comprobarPass($oldpass, $objeto->idUsuario)) {
        $objeto->modUser($datos, $objeto->idUsuario);
        $_SESSION["user"] = $_POST['username'];
        header("Location:../informacion.php?acier=OK_MOD");
} else {
    header('Location:../informacion.php?err=PASSWORDS_NOT_MATCH');
}
?>