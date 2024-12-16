<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="estilos/registro.css">
</head>
<body>
    <form action="acciones/doregistro.php" method="POST">
        <div class="contenedor">
            <h1>Registro</h1>
            <hr>
            <table>
                <tr>
                    <td>
                        <label for="name">Nombre *</label>
                    </td>
                    <td>
                        <input type="text" name="name" id="name">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="apellido1">Primer apellido</label>
                    </td>
                    <td>
                        <input type="text" name="apellido1" id="apellido1">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="apellido2">Segundo apellido</label>
                    </td>
                    <td>
                        <input type="text" name="apellido2" id="apellido2">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="username">Nombre de usuario *</label>
                    </td>
                    <td>
                        <input type="text" name="username" id="username">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Contraseña *</label>
                    </td>
                    <td>
                        <input type="password" name="password" id="password">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="confirmpass">Confirmar contraseña *</label>
                    </td>
                    <td>
                        <input type="password" name="confirmpass">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Correo electrónico *</label>
                    </td>
                    <td>
                        <input type="email" name="email" id="email">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="fecha">Fecha de nacimiento *</label>
                    </td>
                    <td>
                        <input type="date" name="fecha" id="fecha">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="direccion">Direccion *</label>
                    </td>
                    <td>
                        <input type="text" name="direccion" id="direccion">
                    </td>
                </tr>
            </table>
            <?php
            require_once("config.php");
            if(isset($_GET["err"])) {
                echo "<h2 id='error'>".$error[$_GET["err"]]."</h2>";
            }
            ?> 
            <button id="registro">Registrarte</button>
            <a href="login.php">Volver al login</a>
        </div>
    </form>
    <div class="limite">
        <h1>Esta página solo esta disponible para ordenadores</h1>
    </div>
</body>
</html>