<?php
    include('php/dbmanage.php');
    $arrayD = $_POST['directorioOrden'];
    echo $arrayD[0];
    $cantidadD = $_POST['cantidadD'];
    $tipoD = $_POST['directorio'];
    
    $query= "SELECT * FROM directorio WHERE premium='1' AND tipo='".$tipoD."'";
    $resultado= db_query($query);
    $i=1;
    
    while($filaPos=mysqli_fetch_array($resultado))
    {
        //$query=  "UPDATE directorio SET posicion='".$i."' where posicion='".$arraD[0]."'";
        //$resultado= db_query($query);
        $i++;
    }
?>