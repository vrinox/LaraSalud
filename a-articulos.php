<?php
    $error ="";
    $exitoso ="";
    include('php/dbmanage.php');
     include('php/usuario.php');
     header("Content-Type: text/html;charset=utf-8");
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

        /*    if(!$_POST['titulo'])
            {
              $error .= "Coloque un titulo<br>";
            } 
            if(!$_POST['subtitulo'])
            {
              $error .= "Coloque un subtitulo<br>";
            } 
            if(!$_POST['descripcion'])
            {
              $error .= "Coloque una meta descripción<br>";
            } */
            if(!$_POST['iprincipal'])
            {
              $error .= "Cargue la imagen principal<br>";
            } 
           /* if(!$_POST['iSecundaria'])
            {
              $error .= "Cargue la imagen secundaria<br>";
            } 
            if(!$_POST['contenido'])
            {
              $error .= "Redacte un contenido<br>";
            } 
            if(!$_POST['enlace'])
            {
              $error .= "Coloque un enlace para el articulo<br>";
            } */
        if($error=="")
        {
            $titulo = strtoupper($_POST['titulo']); 
           // echo $titulo;
           $query= "SELECT * FROM articulos WHERE titulo='".$titulo."' LIMIT 1;";
            $resultado= db_query($query);
            if(mysqli_num_rows($resultado)>0)
            {
                $error="Ya existe el articulo";
                db_close();
            }
           // $_POST = array();
            else
            {   
                    // $query= "SELECT id FROM medicos WHERE id='".$titulo."' LIMIT 1";
              //  $titulo = $_POST['titulo'];
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
                //echo $titulo.$fechaArticulo.$autor;
                //id	tipo	premium	nombre	direccion	ciudad	latitud	longitud	telefono	descripcion	horario	logo	mapa	facebook	instagram	linkedin	posicion	personas	puntuacion
            
                $dir_subida = 'imagenes/articulos/';
                $imgp_subido = $dir_subida.basename($_FILES['iprincipal']['name']);
                echo $imgp_subido;
              //  $imgs_subido = $dir_subida.basename($_FILES['iSecundaria']['name']);
                if (move_uploaded_file($_FILES['iprincipal']['tmp_name'], $imgp_subido)) { $exitoso = "La imagen principal es válida y se subió con éxito<br>";}
                else {$error = "No se logro subir la imagen principal, por favor intente de nuevo"; $_POST = array();}
        //    if (move_uploaded_file($_FILES['iSecundaria']['tmp_name'], $imgs_subido)) { $exitoso .= "La imagen secundaria es válida y se subió con éxito<br>"; }
        //    else {$error = "¡No se logro subir la imagen secundaria, por favor intente de nuevo!"; $_POST = array();}
                
            /*    if($exitoso !="")
                {
                    $query = "INSERT INTO articulos('titulo', 'subtitulo', 'resumen', 'contenido', 'imagenuno', 'imagendos', 'autor', 'enlace', 'fecha') VALUES('".$titulo."','".$subtitulo."','".$descripcion."','".$contenido."','".$imgp_subido."','".$imgs_subido."','".$autor."','".$enlace."','".$fechaArticulo."')";
                    if (!db_query($query))
                    {
                        $error="No hemos podido completar el registro del articulo, por favor inténtelo más tarde";
                        $_POST = array();
                    }
                    else
                    {
                      $exitoso.="Articulo agregado exitosamente";
                      db_close();
                      $_POST = array();
                    }
                     
                }*/
                 $_POST = array();
            }
      }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <script src="https://cdn.tiny.cloud/1/bylnd8nuvi8ba0uw0un57vcprn5jyyxbd1so3v7keff4rkgb/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  
  <title>LS Admin - Articulos</title>

  <?php include('php/admin-header.php'); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edici贸n de Articulos</h1>
          </div>
        <?php if($error!=""){ 
                echo "<div class=\"alert alert-danger\" role=\"alert\">".$error."</div>";
              }
              else if($exitoso!=""){ 
                echo "<div class=\"alert alert-success\" role=\"alert\">".$exitoso."</div>";
              } 
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="titulo">T铆tulo</label>
                <input type="input" class="form-control" id="titulo" name="titulo">
            </div>
            <div class="form-group">
                <label for="subtitulo">Subt铆tulo</label>
                <input type="input" class="form-control" id="subtitulo" name="subtitulo">
            </div>
            <div class="form-group">
                <i class="fas fa-angle-double-right prefix"></i>
                 <label for="descripcion">Metadescripci贸n</label>
              <textarea id="descripcion" class="md-textarea form-control" rows="3" name="descripcion"></textarea>
             
            </div>
            <div class="row">
                <div class="col-sm-6">
                 <div class="form-group">
                    <label for="imagenPrincipal">Imagen principal</label>
                    <div><input name="iprincipal" type="file" class="form-control-file" id="imagenPrincipal"></div>
                  </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                    <label for="imagenSecundaria">Imagen secundaria</label>
                    <div><input name="iSecundaria" type="file" class="form-control-file" id="imagenSecundaria"  accept="image/*"></div>
                  </div>
                </div>
                </div>
            <div class="container"><textarea class="ml-2" id="basic-example" name="contenido"></textarea>
             <div class="form-group">
                <label for="enlace">Enlace</label>
                <input type="input" class="form-control" id="enlace" name="enlace">
            </div>
            <?php echo $select; ?>
            <button type="submit" name="agregarArticulo" class="btn mb-2" style="background-color: rgb(255,255,153)">Agregar</button>
           
            <button type="submit" name="buscarArticulo" class="btn mb-2" style="background-color: rgb(255,255,153)">Buscar</button>
            </div>
          
        </form>


 <?php include('php/admin-footer.php'); ?>