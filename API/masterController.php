<?php 
include("../clases/articulo.php");
include("../clases/categoria.php");
include("../clases/directorio.php");
include("../clases/especialidad.php");
include("../clases/medico.php");
session_start();

if(array_key_exists(Operacion,$_POST))
{
  $laForm=$_POST;
  $clase = obtenerClase($_POST['modelo']);
  unset($_POST['modelo']);
  $clase->f_SetsForm($laForm);
  $result =  $clase->gestionar();
  $result = json_encode($someArray);
  header("Content-Type: application/json");
  echo $someJSON;
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
  }
  return $clase;
}
?>
