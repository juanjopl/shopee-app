<?php
require_once('p2/p2_lib.php');
include_once('entity/usuarios.php');
session_start();
if(!isset($_SESSION["user"])) {
    header('Location:login.php');
}else {
    $user = $_SESSION["user"];
    $objeto = $_SESSION['objeto'];
    $resultado = mostrarDatos($objeto->idUsuario);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información</title>
    <link rel="stylesheet" href="estilos/informacion.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <header>
    <nav>
    <nav>
        <ul class="lista">
            <li><a href="index.php">Inicio</a></li>
            <?php
                if(isset($_SESSION['objeto']) && comprobarAdmin($_SESSION['objeto']->username)==false) {
                    ?>
                    <li><a href="misproductos.php">Mis productos</a></li>
                    <?php
                }
            ?>
            <?php
            if(isset($_SESSION['user'])) {
                if(comprobarAdmin($_SESSION['user']) == false) {
                    echo '<li><a href="carrito.php">Carrito</a></li>'; 
                }
            }
            ?>
            <?php
            if(!isset($_SESSION['objeto'])) {
                echo "<li>Bienvenido invitado!!</li>";
            }else {
                $objeto = $_SESSION['objeto'];
                ?>
                    <li>
                    <img src="<?php
                        if ($objeto->avatar == null) {
                            echo 'img-default/default.jpg';
                        } else {
                            $image_data = base64_encode($objeto->avatar);
                            echo 'data:image/png;base64,' . $image_data; // Asegúrate de usar el tipo MIME correcto
                        }
                    ?>" id="img">
                    </li>
                <?php
            }
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 25px;">
                    ☰
                </a>
                <ul class="dropdown-menu" style="background-color: #1E1E1E">
                    <?php
                        if(!isset($_SESSION["user"])) {
                            ?>
                            <li class="dropdown-item"><a href="login.php">Iniciar Sesion</a></li>
                            <?php
                        }else {
                            if(comprobarAdmin($_SESSION["user"])) {
                            ?>
                                <li class="dropdown-item"><a href="#" onclick="mostrarPopup()">Modo admin</a><li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-item"><a href="informacion.php">Cuenta</a></li>
                                <li class="dropdown-item"><a href="acciones/logout.php">Cerrar Sesion</a></li>
                            <?php
                            }else {
                            ?>
                                <li class="dropdown-item"><a href="subirproducto.php">Subir Producto</a></li>
                                <li class="dropdown-item"><a href="informacion.php">Cuenta</a></li>
                                <li class="dropdown-item"><a href="acciones/logout.php">Cerrar Sesion</a></li>
                            <?php
                            }
                        }
                    ?>
                </ul>
            </li>
        </ul>

        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <form action="admin/admin.php" method="POST">
            <p>Selecciona tabla</p>
            <button type="submit" name="seleccion" value="usuarios">Usuarios</button>
            <button type="submit" name="seleccion" value="productos">Productos</button>
            </form>
        </div>
        
    </nav>
    </header>
    <main>
        <div class="avatar">
            <form action="acciones/changeavatar.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/webp" style="display:none;" id="fileInput">
            <label for="fileInput">
            <img src="<?php
                if($resultado["avatar"] == null){
                    echo 'img-default/default.jpg';
                }else {
                    echo 'data:image/jpeg;base64, '. base64_encode($objeto->avatar);
                }
            ?>" class="img">
            <br>
            <button id="mandaravatar">Cambiar avatar</button>
            </label>
            </form>
        </div>
        <label style="color: red; font-size: 12px; margin-top: 10px">(Para cambiar el avatar es necesario clicar en el avatar actual, elegir archivo y después darle al boton)</label>
        <table>
        <form action="acciones/changeinfo.php" method="POST">
            <tr>
                <td>Nombre de usuario:</td>
                <td><input type="text"  name="username" value="<?php echo $resultado['username']; ?>"></td>
            </tr>
            <tr>
                <td>Correo electrónico:</td>
                <td><input type="text"  name="email" value="<?php echo $resultado['email']; ?>"></td>
            </tr>
            <tr>
                <td>Direccion:</td>
                <td><input type="text" name="direccion" value="<?php echo $resultado['direccion']; ?>"></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input type="text" name="nombre" value="<?php echo $resultado['nombre']; ?>"></td>
            </tr>
            <tr>
                <td>Primer apellido:</td>
                <td><input type="text" name="apellido1" value="<?php echo $resultado['apellido1'] ?>"></td>
            </tr>
            <tr>
                <td>Segundo apellido:</td>
                <td><input type="text" name="apellido2" value="<?php echo $resultado['apellido2']; ?>"></td>
            </tr>
            <tr>
                <td>Contraseña:</td>
                <td><input type="password" name="pass"></td>
            </tr>
            <tr>
                <td>Nueva contraseña:</td>
                <td><input type="password" name="newpass"></td>
            </tr>
            <tr>
                <td colspan="2" class="botonesinfo"><button>Cambiar Información</button></td>
            </tr>
            </form>
        </table>
        <?php
            require_once("config.php");
            if(isset($_GET["err"])) {
                echo "<h2 id='error'>".$error[$_GET["err"]]."</h2>";
            }else if(isset($_GET["acier"])) {
                echo "<h2 id='ok'>".$aciertos[$_GET["acier"]]."</h2>";
            }
        ?>
    </main>
    <div class="limite">
        <h1>Esta página solo esta disponible para ordenadores</h1>
    </div> 
    <footer>
    <p>&copy; 2023 McSneakers. Todos los derechos reservados.</p>
    </footer>
    </body>
    <script>
        function mostrarPopup() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</html>