<?php
    require_once("../src/p2/p2_lib.php");
    include_once("entity/usuarios.php");
    include_once("entity/productos.php");
    session_start();
    if(isset($_SESSION['objeto'])) {
        $objeto = $_SESSION['objeto'];
    }

    if(isset($_GET['pagina'])) {
    $numpagina = $_GET['pagina'];
    if($numpagina<0 || !is_numeric($numpagina)) {
        header('Location:index.php');
    }
    }

    $con = get_connection();
    $sql = "SELECT idCategoria, descripcion FROM categoria";
    $statement = $con->prepare($sql);
    $statement->execute();
    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="estilos/index.css">
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
            if(isset($_SESSION['objeto'])) {
                if(comprobarAdmin($_SESSION['objeto']->username) == false) {
                    echo '<li><a href="carrito.php">Carrito</a></li>';
                    echo '<li><a href="ofertas.php">Ofertas</a></li>'; 
                }
            }
            ?>
            <?php
            if(!isset($_SESSION['objeto'])) {
                echo "<li>Bienvenido invitado!!</li>";
            }else {
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
                            if(comprobarAdmin($_SESSION["objeto"]->username)) {
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
                <select class="form-select w-100" id="subcategoria" name="subcategoria" placeholder="Subcategoria">
                <option disabled selected>Selecciona una subcategoría</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <button class="btn btn-warning w-100" type="submit" id="btnFiltrar">Filtrar</button>
            </div>
            </form>
        </div>
    </div>



    <main>
        <?php
            define('REGISTROS_PAGINA', 6);
            $conn = get_connection();

            if(isset($_POST['categoria']) || isset($_POST['subcategoria'])) {
                $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;
                $subcategoria = isset($_POST['subcategoria']) ? $_POST['subcategoria'] : null;
                if(isset($_SESSION['objeto'])) {
                    $productos = Producto::productosFiltrados($categoria, $subcategoria, $objeto->idUsuario);
                }else {
                    $productos = Producto::productosFiltrados($categoria, $subcategoria, null);
                }
                if(!empty($productos)) {
                    $paginas = ceil(count($productos)/REGISTROS_PAGINA);
                    if(isset($_GET['pagina'])) {
                        $pagina = $_GET['pagina'];
                    }else {
                        $pagina = 1;
                    }
                }
            }else {
                if(isset($_SESSION['objeto'])) {
                    $registros = Producto::contarProductos($objeto->idUsuario);//11
                }else {
                    $registros = Producto::contarProductos();//11
                }
                $paginas = ceil($registros / REGISTROS_PAGINA); //2
                if(isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                }else {
                    $pagina = 1;
                }
                if(isset($_SESSION['objeto'])) {
                    $productos = Producto::getPaginacion($pagina, REGISTROS_PAGINA, $objeto->idUsuario);
                }else {
                    $productos = Producto::getPaginacion($pagina, REGISTROS_PAGINA);
                }
            }
        ?>

        <?php
            if (!empty($productos) && count($productos) > 0) {
                mostrarProductos($productos);
            }else {
                ?>
                    <h3 style='color:whitesmoke;'>No se encontraron productos</h3>";
                <?php
            }
        ?>
    </main>
    
    <?php
       if (!empty($productos) && count($productos) > 0 && $paginas > 1) {
    ?>
    <div class="paginacion">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link bg-dark text-light" href="?pagina=<?php 
                    if($pagina > 1) {
                        echo $pagina - 1; 
                    }else {
                        echo 1;
                    }
                ?>">
                    <span class="sr-only">Anterior</span>
                </a>
            </li>
            <?php
            for ($i = 1; $i <= $paginas; $i++) {
                ?>
                <li class="page-item <?php echo ($pagina == $i) ? 'active' : ''; ?>">
                    <a class="page-link bg-dark text-light" href="?pagina=<?php echo $i ?>"><?php echo $i ?></a>
                </li>
                <?php
            }
            ?>
            <li class="page-item">
                <a class="page-link bg-dark text-light" href="?pagina=<?php 
                        if($pagina < $paginas) {
                            echo $pagina + 1;
                        }else {
                            echo $paginas;
                        }
                ?>" aria-label="Siguiente">
                    <span class="sr-only">Siguiente</span>
                </a>
            </li>
        </ul>
    </div>
    <?php
        }
    ?>
    <div class="limite">
        <h1>Esta página solo esta disponible para ordenadores</h1>
    </div>
    <footer>
    <p>&copy; 2023 McSneakers. Todos los derechos reservados.</p>
    </footer>
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
        ajax.open("GET", "acciones/dosubcategorias.php?categoria=" + categoriaSeleccionada, true);
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