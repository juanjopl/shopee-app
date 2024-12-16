<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos/login.css">
</head>

<body>
    <div class="login">
        <h1>Inicio de Sesión</h1>
        <hr>
        <form action="acciones/dologin.php" method="POST">
            <input type="text" name="user" id="user" placeholder="Usuario o email">
            <input type="password" name="password" id="password" placeholder="Contraseña">
            <?php
            require_once("config.php");
            if(isset($_GET["err"])) {
                echo "<h2 id='error'>".$error[$_GET["err"]]."</h2>";
            }else if(isset($_GET["acier"])) {
                    echo "<h2 id='ok'>".$aciertos[$_GET["acier"]]."</h2>";
                }
            ?> 
            <button id="boton">Iniciar Sesión</button><br>  
            <a href="registro.php">Registrate Aquí</a>
    </div>
    <div class="limite">
        <h1>Esta página solo esta disponible para ordenadores</h1>
    </div>
</body>
</html>