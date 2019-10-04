<?php
function db_query($query) {
    $connection = mysqli_connect("51.91.31.196", "larasalu_admin", "conejototuga.1", "larasalu_directorio");
    if (mysqli_connect_error()) 
        return die("Error de conexión en la base de datos");
    else
    {
        mysqli_set_charset( $connection, 'utf8');
        $result = mysqli_query($connection,$query);
        
    }
 
    return $result;
}
 
function delete($tblname,$field_id,$id){ //Funcion para borrar registros
 
	$sql = "delete from ".$tblname." where ".$field_id."=".$id."";
	
	return db_query($sql);
}
function update($tblname,$columna,$valor,$field_id,$id){ //Funcion para borrar registros
	$sql = "update ".$tblname." set ".$columna."='".$valor."' where ".$field_id."=".$id."";
	
	return db_query($sql);
}
function update1($tblname,$columna,$valor,$columna2,$valor2,$field_id,$id){ //Funcion para borrar registros
	$sql = "update ".$tblname." set ".$columna."='".$valor."',".$columna2."='".$valor2."' where ".$field_id."=".$id."";
	
	return db_query($sql);
}
function select_id($tblname,$field_name,$field_id){
	$sql = "Select * from ".$tblname." where ".$field_name." = ".$field_id."";
	$db=db_query($sql);
	$GLOBALS['row'] = mysqli_fetch_object($db);
 
	return $sql;
}
function db_close() {
    $connection = mysqli_connect("51.91.31.196", "larasalu_admin", "conejototuga.1", "larasalu_directorio");
   
    return mysqli_close($connection);
}
?>