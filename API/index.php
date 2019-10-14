<?php 
include("/home2/larasalu/public_html/API/clases/articulo.php");
include("/home2/larasalu/public_html/API/clases/categoria.php");
include("/home2/larasalu/public_html/API/clases/directorio.php");
include("/home2/larasalu/public_html/API/clases/especialidad.php");
include("/home2/larasalu/public_html/API/clases/medico.php");
session_start();

//convierto el json de la peticion en un array asociativo para asi poder usar mas comodamente
$json= file_get_contents('php://input');
$data = json_decode($json, true);

if(array_key_exists('operacion',$data))
{
  $laForm=$data;
  $clase = obtenerClase($data['modelo']);
  unset($data['modelo']);
  if($clase!=null){
    $clase->f_SetsForm($laForm);
    $result =  $clase->gestionar();
  }else{
    $result = array('success'=>false,'mensaje'=>'modelo seleccionado no existe');
  } 
  header("Content-Type: application/json");
  $result = json_encode($result);
  echo $result;
}else if(array_key_exists(accesoPrueba,$_GET)){
	header("Content-Type: application/json");
	$result = json_encode(array('API'=>'laraSalud','version'=>'1'));
	echo $result;
}else{
  header("Content-Type: application/json");
	$result = json_encode(array('mensaje'=>'debe seleccionar una operacion'));
	echo $result;
}

function obtenerClase($modelo){
  switch($modelo){
    case'articulo':
      $clase = new cls_Articulo();
      break;
    case'categoria':
      $clase = new cls_Categoria();
      break;
    case'medico':
      $clase = new cls_Medico();
      break;
    case'directorio':
      $clase = new cls_Directorio();
      break;
    case'especialidad':
      $clase = new cls_Especialidad();
      break;
    case'usuario':
      $clase = new cls_Usuario();
      break;
  }
  return $clase;
}
?>
