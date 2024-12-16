<?php
require_once('p2/p2_lib.php');
include_once('entity/usuarios.php');
session_start();
if(!isset($_SESSION["user"])) {
    header('Location:login.php');
}else {
    $user = $_SESSION["user"];
    $objeto = $_SESSION['objeto'];
    
    $con = get_connection();
    $sql = "SELECT idCategoria, descripcion FROM categoria";
    $statement = $con->prepare($sql);
    $statement->execute();
    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Producto</title>
    <link rel="stylesheet" href="estilos/subirproducto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <header>
    <nav>
    <ul class="lista">
            <li><a href="index.php">Inicio</a></li>
            <?php
                if(isset($_SESSION['objeto'])) {
                    ?>
                    <li><a href="">Mis productos</a></li>
                    <?php
                }
            ?>
            <li><a href="">Contactar</a></li>
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
    </header>
    <main>
        <span>Subir Producto</span>
        <table>
        <form action="acciones/doproducto.php" method="POST" enctype="multipart/form-data">
            <tr>
                <td>
                Titulo:
                <input type="text"  name="titulo">
                </td>
            </tr>
            <tr>
                <td>Descripcion:</td>
            </tr>
            <tr>
                <td><textarea name="descripcion" cols="50" rows="10"></textarea></td>
            </tr>
            <tr>
                <td>Estado:<br>
                    <select name="estado">
                    <option value="Nuevo">Nuevo</option>
                    <option value="Usado">Usado</option>
                    <option value="Piezas">Piezas</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Categoria:<br>
                    <select id="categoria" name="categoria">
                        <option disabled selected>Elige categoria</option>
                        <?php foreach ($resultado as $row) { ?>
                        <option value="<?php echo $row['idCategoria']; ?>"><?php echo $row['descripcion']; ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Subcategoria:<br>
                    <select id="subcategoria" name="subcategoria">
                        <option disabled selected>Elige subcategoria</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Precio:<br>
                    <input type="number" name="precio" id="inputPrecio">
                </td>
            </tr>
            <tr>
                <td>Foto:<br>
                    <input type="file" name="images[]" multiple accept="image/webp" id="foto">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="botonesinfo"><button class="btn btn-success w-100" id="btnEnviar">Subir</button></td>
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
    <script>
        btnEnviar.disabled = true;
        inputPrecio.addEventListener('input', function() {
            let valor = inputPrecio.value.trim();
            if (/^\d+$/.test(valor) && parseInt(valor) > 0) {
                btnEnviar.disabled = false;
            } else {
                btnEnviar.disabled = true;
            }
        });

        function mostrarPopup() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';
        }

        document.getElementById("categoria").onchange = function() {
        let categoriaSeleccionada = this.value;

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
    };
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>