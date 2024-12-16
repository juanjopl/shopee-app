<?php
    require_once("p2/p2_lib.php");
    include_once("entity/usuarios.php");
    include_once("entity/productos.php");
    session_start();
    if(!isset($_SESSION["objeto"])) {
        header('Location:index.php');
    }else {
        $objeto = $_SESSION['objeto'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas</title>
    <link rel="stylesheet" href="estilos/ofertas.css">
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
    <div class="accordion" id="accordionPanelsStayOpenExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
            Ofertas Enviadas
        </button>
        </h2>
        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse">
        <div class="accordion-body d-flex justify-content-center" style="background-color: #1E1E1E;">
           <!-- OFERTAS ENVIADAS -->
           <?php
                ofertasEnviadas($objeto->idUsuario);
           ?>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
            Ofertas Recibidas
        </button>
        </h2>
        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
        <div class="accordion-body d-flex justify-content-center" style="background-color: #1E1E1E;">
            <!-- OFERTAS RECIBIDAS -->
            <?php
                ofertasRecibidas($objeto->idUsuario);
            ?>
        </div>
        </div>
    </div>
    </div>
    </main>
    <div class="limite">
        <h1>Esta página solo esta disponible para ordenadores</h1>
    </div>
    <footer>
    <p>&copy; 2023 McSneakers. Todos los derechos reservados.</p>
    </footer>
</body>
<script>
    function mostrarContraoferta(id) {
    document.getElementById('overlay').style.display = 'block';
    let popup = document.getElementById(id);
    popup.style.display = 'block';
    }
    function cerrarContraoferta(id) {
        document.getElementById('overlay').style.display = 'none';
        let popup = document.getElementById(id);
        popup.style.display = 'none';
    }

    let btnEnviar = document.getElementById('btnEnviar');
    let inputContraoferta = document.getElementById('inputContraoferta');
    btnEnviar.disabled = true;
    inputContraoferta.addEventListener('input', function() {
        let valor = inputContraoferta.value.trim();
        if (/^\d+$/.test(valor) && parseInt(valor) > 0) {
            btnEnviar.disabled = false;
        } else {
            btnEnviar.disabled = true;
        }
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</html>