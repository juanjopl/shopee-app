<?php
require_once("p2/p2_lib.php");
include_once("entity/usuarios.php");
include_once("entity/productos.php");
session_start();
if (isset($_SESSION["objeto"])) {
    $objeto = $_SESSION["objeto"];
}else {
    header("Location:..\\index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link rel="stylesheet" href="estilos/carrito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav>
    <ul class="lista">
        <li><a href="index.php">Inicio</a></li>
        <?php
            if(isset($_SESSION['objeto']) && comprobarAdmin($_SESSION['objeto']->username) == false) {
                ?>
                <li><a href="misproductos.php">Mis productos</a></li>
                <?php
            }
        ?>
        <?php
        if(isset($_SESSION['user'])) {
            if(comprobarAdmin($_SESSION['user']) == false) {
                echo '<li><a href="carrito.php">Carrito</a></li>';
                echo '<li><a href="ofertas.php">Ofertas</a></li>'; 
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
                            echo 'data:image/jpeg;base64, ' . base64_encode($objeto->avatar);
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
        <form action="admin/admin.php" method="GET">
        <p>Selecciona tabla</p>
        <button type="submit" name="seleccion" value="usuarios">Usuarios</button>
        <button type="submit" name="seleccion" value="productos">Productos</button>
        </form>
    </div>
</nav>
<div class="container-fluid m-0 filtros">
    <div class="row mt-2 justify-content-center align-items-center">
        <div class="col-6 col-md-3 d-flex justify-content-center align-items-center">
            <form action="acciones/docarritoempty.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas vaciar el carrito?');">
                <button type="submit" name="vaciar" class="btn btn-danger w-100" id="vaciarCarrito">Vaciar carrito</button>
            </form>
        </div>
    </div>
</div>

<main>
<?php
$productosCarrito = array();
    if(isset($_COOKIE['carrito_'.$objeto->idUsuario])) {
            $carrito = json_decode($_COOKIE['carrito_'.$objeto->idUsuario]);
            foreach ($carrito as $producto) {
            $idProducto = $producto->id;
            $con = get_connection();
            $sql = "SELECT * FROM productos WHERE idProducto = $idProducto";
            $statement = $con->prepare($sql);
            $statement->execute();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $productoCookie = new Producto();
                $productosCarrito[] = Producto::parse($row);
            }
        }
    }
    if(empty($productosCarrito)) {
        ?>
            <h3 style='color:whitesmoke;'>Carrito vacío</h3>";
        <?php
    }else {
        mostrarCarrito($productosCarrito,$objeto->idUsuario);
        ?>
            <div class="row row-cols-1 d-flex justify-content-center w-50 mb-5">
                <form action="../acciones/docompra.php" method="POST" style="text-align: right;" onsubmit="return confirm('¿Comprar?');">
                <button type="submit" class="btn btn-success" name="compra">Comprar</button>
            </div>
        <?php
    }
?>
</main>
<div class="limite">
    <h1>Esta página solo esta disponible para ordenadores</h1>
</div>
<footer>
    <p>&copy; 2023 McSneakers. Todos los derechos reservados.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>