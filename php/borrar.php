<?php 
include("dbmanage.php");
$id = $_GET['id'];
$tabla = $_GET['tabla'];
$fila = $_GET['fila'];
delete($tabla,$fila,$id);
if($tabla=="especialidades")
    header("location:https://larasalud.com/a-especialidades.php");
elseif($tabla=="categorias")
    header("location:https://larasalud.com/a-categorias.php");
elseif($tabla=="directorio")
    header("location:https://larasalud.com/a-directorio.php");
?>