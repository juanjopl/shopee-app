<?php
require_once("../p2/p2_lib.php");
session_start();
$user = $_SESSION['user'];
session_destroy();
header('Location:..\\index.php');
?>