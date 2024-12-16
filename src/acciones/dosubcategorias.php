<?php
require_once("../p2/p2_lib.php");

$categoriaSeleccionada = $_GET['categoria'];


$con = get_connection();

$sql = "SELECT idSubcategoria, descripcion FROM subcategoria WHERE idCategoria = :categoria";
$statement = $con->prepare($sql);
$statement->bindParam(":categoria", $categoriaSeleccionada);
$statement->execute();
$resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

$subcategorias = array();

foreach ($resultado as $row) {
  $subcategorias[] = $row;
}

cerrarConexion($con);

header('Content-Type: application/json');
echo json_encode($subcategorias);
?>

