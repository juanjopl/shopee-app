<?php 
    require_once('p2/p2_lib.php');
    include_once("entity/usuarios.php");
    include("entity/productos.php");
    session_start();
    $idProducto = $_GET['idProducto'];
    if($idProducto<0 || !is_numeric($idProducto)) {
        header('Location:index.php');
    }
    $producto = recogerProductoDeseado($idProducto);

    if(isset($_SESSION['objeto'])) {
        $objeto = $_SESSION['objeto'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir producto</title>
    <link rel="stylesheet" href="estilos\\producto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <nav>
    <ul class="lista">
            <li><a href="index.php">Inicio</a></li>
            <?php
                if(isset($_SESSION['objeto']) && comprobarAdmin($_SESSION['objeto']->username)==false) {
                    ?>
                    <li><a href="">Mis productos</a></li>
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
            <form action="admin/admin.php" method="POST">
            <p>Selecciona tabla</p>
            <button type="submit" name="seleccion" value="usuarios">Usuarios</button>
            <button type="submit" name="seleccion" value="productos">Productos</button>
            </form>
        </div>
    
    </nav>
    <main>
    <div class="container mt-5 mb-5">
        <div class="row parte-img justify-content-center">
            <div class="col-md-6 mb-3">
                <?php mostrarImagenesProducto($producto) ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 mb-3 text-center datos">
                <h2 class="text-light"><?php echo $producto->precio ?>€</h2>
                <h2 class="text-light"><?php echo $producto->titulo ?></h2>
                <p class="text-light">Estado: <?php echo $producto->estado ?></p>
                <?php
                    if($producto->estadoProducto == 'reservado') {
                        ?>
                            <h5 class="text-danger" style="text-align: left;">Reservado</h4>
                        <?php
                    }else {
                        ?>
                            <h5 class="text-success" style="text-align: left;">Activo</h4>
                        <?php
                    }
                ?>
                <p class="text-light"><?php echo $producto->descripcion ?></p>
            </div>
        </div>
        <?php
        if(isset($_SESSION['objeto'])) {
            if($objeto->idUsuario != $producto->idVendedor) {
                if($producto->estadoProducto == 'activo' && comprobarAdmin($objeto->username) == false) {
                ?>
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3 text-center">
                        <p style="color: red;">Si no se introduce ninguna oferta, se usará el valor original del producto</p>
                        <form action="acciones/docookie.php" method="POST">
                        <label for="oferta" style="color: whitesmoke;">Oferta:</label>
                        <input type="hidden" name="valorOriginal" value="<?php echo $producto->precio ?>">
                        <input type="number" name="oferta" id="oferta" style="width: 30%;" class="mb-2">
                        <button type="submit" name="añadirCarrito" value="<?php echo $producto->idProducto ?>" class="btn btn-rounded btn-light" style="width: 100%;">Añadir al carrito</button>
                        </form>
                    </div>
                </div>
                <?php
                }
            }else {
                ?>
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3 text-center">
                        <h5 style="width:100%; color:green; background-color:#1E1E1E">Este producto es tuyo</h5>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    </main>
    <div class="limite">
        <h1>Esta página solo esta disponible para ordenadores</h1>
    </div>
    <footer>
    <p>&copy; 2023 McSneakers. Todos los derechos reservados.</p>
    </footer>
<script>
    function mostrarPopup() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>