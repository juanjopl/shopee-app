<?php
require_once("../p2/p2_lib.php");
require_once("../entity/usuarios.php");

// Asegúrate de que no haya ningún espacio o salto de línea antes de esta línea
session_start();

$user = $_POST['user'];
$pass = $_POST['password'];

if(autenticarUsuario($user, $pass)) {
    if(isBlocked($user)) {
        header('Location:..\\login.php?err=USER_BLOCKED');
        exit(); // No olvidar usar exit() después de una redirección
    } else {
        $_SESSION["user"] = $user;
        $_SESSION["objeto"] = crearObjetoUsuario($user);
        header('Location:..\\index.php');
        exit(); // Siempre usar exit() después de redirigir
    }
} else {
    header('Location:..\\login.php?err=NOT_EXIST');
    exit(); // Asegúrate de usar exit() después de redirigir
}
?>
