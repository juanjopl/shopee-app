<?php
    require_once("../p2/p2_lib.php");
    include_once("../entity/usuarios.php");
    $datos = array(
        'idUsuario' => null,
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'pass' => $_POST['password'],
        'nombre' => $_POST['name'],
        'apellido1' => (isset($_POST['apellido1']) ? $_POST['apellido1'] : ''),
        'apellido2' => (isset($_POST['apellido2']) ? $_POST['apellido2'] : ''),
        'direccion' => $_POST['direccion'],
        'fechaNac' => $_POST['fecha'],
        'fechaCreacion' => date('Y-m-d H:i:s'),
        'fechaModificacion' => null,
        'estado' => 'Desbloqueado',
        'perfil' => 0,
        'avatar' => null
    );
    $confirmpass = $_POST['confirmpass'];
        if($datos['pass']==$confirmpass) {
                //Crea el objeto Usuario
                $usuario = Usuario::parse($datos);
                if ($usuario->addUser()) {
                session_start();
                $_SESSION['user'] = $usuario->username;
                $_SESSION['objeto'] = $usuario;
                header("Location:..\\index.php");
                }
        }else {
            header('Location: ..\\registro.php?err=PASSWORDS_NOT_MATCH');
        }
?>