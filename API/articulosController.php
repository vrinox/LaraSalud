<?php
$error ="";
$exitoso ="";
include('php/dbmanage.php');
include('php/usuario.php');
$query = "SELECT id,nombre from medicos";
$resultado = db_query($query);
while($fila=mysqli_fetch_array($resultado))
{
  $select = "<div class=\"form-group mt-2\">
      <label for=\"medicoautor\">Seleccionar autor</label>
      <select name=\"busquedaAutor\" class=\"form-control\" id=\"medicoautor\">
      <option value=\"".$fila['id']."\">".$fila['nombre']."</option>
      </select>
  </div>";
}
db_close();
if(array_key_exists("agregarArticulo",$_POST))
{ 
  if(!$_POST['iprincipal'])
  {
    $error .= "Cargue la imagen principal<br>";
  } 
  if($error=="")
  {
    $titulo = strtoupper($_POST['titulo']); 
    $query= "SELECT * FROM articulos WHERE titulo='".$titulo."' LIMIT 1;";
    $resultado= db_query($query);
    if(mysqli_num_rows($resultado)>0)
    {
      $error="Ya existe el articulo";
      db_close();
    }
    else
    {   
      $subtitulo = $_POST['subtitulo'];
      $descripcion = $_POST['descripcion'];
      $contenido = $_POST['contenido'];
      $iPrincipal = $_POST['iPrincipal'];
      $iSecundaria = $_POST['iSecundaria'];
      $enlace = $_POST['enlace'];
      $autor = $_POST['busquedaAutor'];
      $fecha = getdate();
      $fechaArticulo = $fecha['mday']."/".$fecha['mon']."/".$fecha['year'];
      $autor = $_POST['busquedaAutor'];
      //id	tipo	premium	nombre	direccion	ciudad	latitud	longitud	telefono	descripcion	horario	logo	mapa	facebook	instagram	linkedin	posicion	personas	puntuacion
      $dir_subida = 'imagenes/articulos/';
      $imgp_subido = $dir_subida.basename($_FILES['iprincipal']['name']);
      if (move_uploaded_file($_FILES['iprincipal']['tmp_name'], $imgp_subido)) { 
        $exitoso = "La imagen principal es v��lida y se subi�� con ��xito<br>";
      }
      else {
        $error = "No se logro subir la imagen principal, por favor intente de nuevo"; 
        $_POST = array();
      }
      $_POST = array();
    }
  }
}
?>