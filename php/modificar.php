<?php 
include("dbmanage.php");
if(count($_POST)==5)
{
    $id = $_POST['id'];
    $tabla = $_POST['tabla'];
    $fila = $_POST['fila'];
    $columna = $_POST['columna'];
    $valor = $_POST['valor'];
    
    update($tabla,$columna,$valor,$fila,$id);
    db_close();
}
elseif(count($_POST)==7)
{
    $id = $_POST['id'];
    $tabla = $_POST['tabla'];
    $fila = $_POST['fila'];
    $columna = $_POST['columna'];
    $valor = $_POST['valor'];
    $columna2 = $_POST['columna2'];
    $valor2 = $_POST['valor2'];
    
    update1($tabla,$columna,$valor,$columna2,$valor2,$fila,$id);
    db_close();
  
}
?>