<?php 
include("/home2/larasalu/public_html/API/clases/articulo.php");
include("/home2/larasalu/public_html/API/clases/categoria.php");
include("/home2/larasalu/public_html/API/clases/directorio.php");
include("/home2/larasalu/public_html/API/clases/especialidad.php");
include("/home2/larasalu/public_html/API/clases/medico.php");
include("/home2/larasalu/public_html/API/clases/usuario.php");
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
  $result = json_encode($result);
}else if(array_key_exists(accesoPrueba,$_GET)){
  $result= array('mesaje'=>'larasalud');
}else{
	$result = json_encode(array('mensaje'=>'debe seleccionar una operacion'));
}

header("Content-Type: application/json");
// manejo de CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
// fin cabeceras CORS
echo $result;

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
