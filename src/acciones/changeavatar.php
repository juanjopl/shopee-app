<?php
require_once("../config.php");
require_once("../p2/p2_lib.php");
include_once("../entity/usuarios.php");
session_start();
$objeto = $_SESSION['objeto'];
$formatos = array("image/webp");

if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $temp = $_FILES["image"]["tmp_name"];

    $info = @getimagesize($temp);

    if ($info !== false) {
        $tipo = $info['mime'];

        if ($_FILES["image"]["size"] > 10000000) {
            header("Location:../informacion.php?err=SIZE");
        } else if (!in_array($tipo, $formatos)) {
            header("Location:../informacion.php?err=FORMAT");
        } else {
            $imageData = file_get_contents($temp);

            $con = get_connection();
            $sql = "UPDATE usuarios SET avatar= :imagen WHERE username= :username";
            $statement = $con ->prepare($sql);

            $statement->bindParam(":username", $_SESSION["user"]);
            $statement->bindParam(":imagen", $imageData);

            $result = $statement->execute();

            if ($result) {
                $objeto->ponerAvatar($imageData);
            } else {
                echo "Error: ";
            }
            header("Location:../informacion.php");
        }
    } else {
        header("Location:../informacion.php?err=SIZE");
    }
} else {
    header("Location:../informacion.php?err=NOFILE");
}
?>