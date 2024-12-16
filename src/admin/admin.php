<?php
require_once('../entity/productos.php');
include_once('../entity/usuarios.php');
session_start();

$tablaSeleccionada = $_GET['seleccion'];
$objeto = $_SESSION['objeto'];
if(comprobarAdmin($_SESSION['user']) == false) {
    header('Location:../login.php');
}

$con = get_connection();
$sql = "SELECT idCategoria, descripcion FROM categoria";
$statement = $con->prepare($sql);
$statement->execute();
$resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../estilos/admin.css"></style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav>
        <ul class="lista">
            <li><a href="../index.php">Inicio</a></li>
            <?php
            if(isset($_SESSION['user'])) {
                if(comprobarAdmin($_SESSION['user']) == false) {
                    echo '<li><a href="../carrito.php">Carrito</a></li>'; 
                }
            }
            ?>
            <li>
                <img src="<?php
                    if ($objeto->avatar == null) {
                        echo '../img-default/default.jpg';
                    } else {
                        echo 'data:image/jpeg;base64, ' . base64_encode($objeto->avatar);
                    }
                ?>" id="img">
            </li>
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
                                <li class="dropdown-item"><a href="../informacion.php">Cuenta</a></li>
                                <li class="dropdown-item"><a href="../acciones/logout.php">Cerrar Sesion</a></li>
                            <?php
                            }else {
                            ?>
                                <li class="dropdown-item"><a href="../subirproducto.php">Subir Producto</a></li>
                                <li class="dropdown-item"><a href="../informacion.php">Cuenta</a></li>
                                <li class="dropdown-item"><a href="../acciones/logout.php">Cerrar Sesion</a></li>
                            <?php
                            }
                        }
                    ?>
                </ul>
            </li>
        </ul>

        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <form action="admin.php" method="GET">
            <p>Selecciona tabla</p>
            <button type="submit" name="seleccion" value="usuarios">Usuarios</button>
            <button type="submit" name="seleccion" value="productos">Productos</button>
            </form>
        </div>

</nav>

<?php
    if($tablaSeleccionada == "productos") {
        ?>
        <div class="container-fluid m-0 filtros">
            <div class="row justify-content-center align-items-center">
                <div class="col-6 col-md-3">
                <form action="#" method="POST">
                    <select class="form-select w-100" id="categoria" name="categoria">
                        <option disabled selected>Selecciona una categoría</option>
                        <?php foreach ($resultado as $row) { ?>
                            <option value="<?php echo $row['idCategoria']; ?>"><?php echo $row['descripcion']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <select class="form-select w-100" id="subcategoria" name="subcategoria">
                        <option disabled selected>Selecciona una subcategoría</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <select class="form-select w-100" name="estadoProducto">
                            <option selected disabled value="">Estado</option>
                            <option value="activo">Activo</option>
                            <option value="reservado">Reservado</option>
                            <option value="comprado">Comprado</option>
                            <option value="negociacion-1">Negociacion (1)</option>
                            <option value="negociacion-2">Negociacion (2)</option>
                            <option value="negociacion-3">Negociacion (3)</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <button class="btn btn-warning w-100" type="submit" id="btnFiltrar">Filtrar</button>
                </div>
                </form>
            </div>
        </div>
        <?php
    }
?>

<main>
    <?php
        if($tablaSeleccionada == 'usuarios') {
            ?>
            <div class="table-responsive w-100">
            <table class="table-bordered w-100" style="background-color: grey; color: whitesmoke;">
                <thead>
                <tr>
                    <th scope="col">idUsuario</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido 1</th>
                    <th scope="col">Apellido 2</th>
                    <th scope="col">Fecha Nacimiento</th>
                    <th scope="col">Fecha Creacion</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Perfil</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $usuarios = Usuario::recogerUsuarios();
                    if($usuarios != null) {
                    foreach ($usuarios as $usuario) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $usuario->idUsuario ?></th>
                                <td><?php echo $usuario->username ?></td>
                                <td><?php echo $usuario->pass ?></td>
                                <td><?php echo $usuario->nombre ?></td>
                                <td><?php echo $usuario->apellido1 ?></td>
                                <td><?php echo $usuario->apellido2 ?></td>
                                <td><?php echo $usuario->fechaNac ?></td>
                                <td><?php echo $usuario->fechaCreacion ?></td>
                                <td><?php echo $usuario->estado ?></td>
                                <td>
                                <?php
                                if($usuario->perfil == 1) {
                                echo "Admin";
                                }else {
                                echo "Normal";
                                }
                                ?>       
                                </td>
                                <?php
                                    if(($objeto->idUsuario != $usuario->idUsuario)) {
                                        if($usuario->perfil != 1) {
                                        ?>
                                            <td>
                                                <form action="adminblock.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas realizar esta accion?');">
                                                    <button type="submit" name="idUsuario" value="<?php echo $usuario->idUsuario ?>">
                                                    <?php
                                                        if($usuario->estado == "Desbloqueado") {
                                                            echo "Bloquear";
                                                        }else {
                                                            echo "Desbloquear";
                                                        }
                                                    ?>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="admindeleteuser.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas borrar este usuario?');">
                                                    <button type="submit" name="idUsuario" value="<?php echo $usuario->idUsuario ?>">Borrar</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="adminchange.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas realizar esta accion?');">
                                                    <button type="submit" name="idUsuario" value="<?php echo $usuario->idUsuario ?>">Tipo usuario</button>
                                                    <input type="hidden" name="isAdmin" value="<?php echo ($usuario->perfil == 1) ? '1' : '0'; ?>">
                                                </form>
                                            </td>
                                        <?php
                                        }
                                    }
                                ?>
                            </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            </div>
            <?php
        }
    ?>

    <?php
        if($tablaSeleccionada == 'productos') {
            ?>
            <div class="table-responsive w-100">
            <table class="table-bordered w-100" style="background-color: grey;">
                <thead>
                <tr>
                    <th scope="col">idProducto</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Fecha Creacion</th>
                    <th scope="col">idVendedor</th>
                    <th scope="col">idComprador</th>
                    <th scope="col">idCategoria</th>
                    <th scope="col">idSubcategoria</th>
                    <th scope="col">estadoProducto</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $categoria = null;
                $subcategoria = null;
                $estadoProducto = null;
                if (isset($_POST['categoria']) || isset($_POST['subcategoria']) || isset($_POST['estadoProducto'])) {
                    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;
                    $subcategoria = isset($_POST['subcategoria']) ? $_POST['subcategoria'] : null;
                    $estadoProducto = isset($_POST['estadoProducto']) ? $_POST['estadoProducto'] : null;
                }
                $productos = Producto::recogerProductos($categoria, $subcategoria, $estadoProducto);                
                if($productos != null) {
                    foreach ($productos as $producto) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $producto->idProducto ?></th>
                                <td><?php echo $producto->titulo ?></td>
                                <td><?php echo $producto->estado ?></td>
                                <td><?php echo $producto->precio ?>€</td>
                                <td><?php echo $producto->fechaCreacion ?></td>
                                <td><?php echo $producto->idVendedor ?></td>
                                <td><?php echo $producto->idComprador ?></td>
                                <td><?php echo $producto->idCategoria ?></td>
                                <td><?php echo $producto->idSubcategoria ?></td>
                                <td><?php echo $producto->estadoProducto ?></td>
                                <td>
                                    <form action="admindeleteproduct.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas borrar este producto?');">
                                        <button type="submit" name="idProducto" value="<?php echo $producto->idProducto ?>" id="btnBorrar">
                                        Borrar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            </div>
            <?php
    }
    ?>

</main>
<footer>
<p>&copy; 2023 McSneakers. Todos los derechos reservados.</p>
</footer>
</div>
    <script>
        let subcategoriasCargadas = false;
        document.getElementById('subcategoria').addEventListener('click', function() {
            if (!subcategoriasCargadas) {
                let categoriaSeleccionada = document.getElementById('categoria').value;
                if (categoriaSeleccionada !== '') {
                    cargarSubcategorias(categoriaSeleccionada);
                    subcategoriasCargadas = true;
                }
            }
        });
        document.getElementById('categoria').addEventListener('change', function() {
            document.getElementById('subcategoria').innerHTML = "<option value='' disabled selected>Selecciona una subcategoría</option>";
            subcategoriasCargadas = false;
        });
        function cargarSubcategorias(categoriaSeleccionada) {
            let ajax = new XMLHttpRequest();
            ajax.open("GET", "../acciones/dosubcategorias.php?categoria=" + categoriaSeleccionada, true);
            ajax.onload = function() {
                if (ajax.status == 200) {
                    let selectSubcategorias = document.getElementById("subcategoria");
                    selectSubcategorias.options.length = 0;
                    let subcategorias = JSON.parse(ajax.responseText);
                    subcategorias.forEach(function(subcategoria) {
                        let option = document.createElement("option");
                        option.value = subcategoria.idSubcategoria;
                        option.text = subcategoria.descripcion;
                        selectSubcategorias.add(option);
                    });
                }
            };
            ajax.send();
        }

        function mostrarPopup() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>