<?php
//    $error="";
  // $exitoso="";
    include('php/dbmanage.php');
    include('php/usuario.php');
    header("Content-Type: text/html;charset=utf-8");
    
    if(array_key_exists("agregarDirectorio",$_POST))
    {
        if(!$_POST['premiumD']!="1")
        {
            if(!$_POST['nombreD'])
            {
              $error .= "Coloque un nombre<br>";
            } 
            if(!$_POST['descripcionD'])
            {
              $error .= "Coloque una descripción<br>";
            } 
            if(!$_POST['telefonoD'])
            {
              $error .= "Coloque un telefono<br>";
            } 
            if(!$_POST['direccionD'])
            {
              $error .= "Coloque una dirección<br>";
            } 
            if(!$_POST['mapaD'])
            {
              $error .= "Coloque un enlace de google maps<br>";
            } 
            if(!$_POST['horarioD'])
            {
              $error .= "Coloque un horario<br>";
            } 
            if(!$_POST['correoD'])
            {
              $error .= "Coloque un correo<br>";
            } 
        }
        else if(!$_POST['premiumD']=="1")
        {
            
            if(!$_POST['nombreD'])
            {
              $error .= "Coloque un nombre<br>";
            } 
            if(!$_POST['descripcionD'])
            {
              $error .= "Coloque una descripción<br>";
            } 
            if(!$_POST['telefonoD'])
            {
              $error .= "Coloque un telefono<br>";
            } 
            if(!$_POST['direccionD'])
            {
              $error .= "Coloque una dirección<br>";
            } 
        }
        if($error=="")
        {
            $nombreD = strtoupper($_POST['nombreD']); 
            $tipoD = $_POST['directorio'];
            $query= "SELECT * FROM directorio WHERE nombre='".$nombreD."' AND tipo='".$tipoD."' LIMIT 1";
            $resultado= db_query($query);
            if(mysqli_num_rows($resultado)>0)
            {
                $error="Ya existe el directorio";
            }
            else
            {   
                $query= "SELECT * FROM directorio WHERE premium='1' AND tipo='".$tipoD."'";
                $result = db_query($query);
                $posicion = mysqli_num_rows($result) + 1;
                //id	tipo	premium	nombre	direccion	ciudad	latitud	longitud	telefono	descripcion	horario	logo	mapa	facebook	instagram	linkedin	posicion	personas	puntuacion
                $premium = $_POST['premiumD'];
                $direccion = $_POST['direccionD'];
                $ciudad = $_POST['ciudadD'];
                $mapa = $_POST['mapaD'];
                $telefono = $_POST['telefonoD'];
                $descripcion = $_POST['descripcionD'];
                $horario = $_POST['horarioD'];
                $correo = $_POST['correoD'];
                $facebook = $_POST['facebookD'];
                $instagram = $_POST['instagramD'];
                $linkedin = $_POST['linkedinD'];
            
                $dir_subida = "imagenes/logos/".$tipoD."/";
                $logo_subido = $dir_subida.basename($_FILES['logoD']['name']);
                //esta es una validacion en el caso que el usuario no suba imagen se coloca un icono que ya esta en el servidor
                if(!basename($_FILES['logoD']['name'])){ $logo_subido = "imagenes/iconos/50x50/".$tipoD.".png";}
                else if (move_uploaded_file($_FILES['logoD']['tmp_name'], $logo_subido)) { $exitoso = "El logo es válido y se subió con éxito<br>"; }
                else {$error = "¡No se logro subir el logo, por favor intente de nuevo!";}
                if($premium=="1") $query = "INSERT INTO directorio(tipo,premium,nombre,direccion,ciudad,mapa,telefono,descripcion,horario,logo,correo,facebook,instagram,linkedin,posicion) VALUES('".$tipoD."','".$premium."','".$nombreD."','".$direccion."','".$ciudad."','".$mapa."','".$telefono."','".$descripcion."','".$horario."','".$logo_subido."','".$correo."','".$facebook."','".$instagram."','".$linkedin."','".$posicion."')";
                else $query = "INSERT INTO directorio(tipo,premium,nombre,direccion,ciudad,mapa,telefono,descripcion,horario,logo,correo,facebook,instagram,linkedin) VALUES('".$tipoD."','".$premium."','".$nombreD."','".$direccion."','".$ciudad."','".$mapa."','".$telefono."','".$descripcion."','".$horario."','".$logo_subido."','".$correo."','".$facebook."','".$instagram."','".$linkedin."')";
                if (!db_query($query))
                {
                  $error="No hemos podido completar el registro, por favor inténtelo más tarde";
                }
                else
                {
                  $exitoso.="Directorio agregado exitosamente";
                  db_close();
                }
                
                unset($_POST['directorio'],$_POST['premiumD'],$_POST['nombreD'],$_POST['direccionD'],$_POST['ciudadD'],$_POST['mapaD'],
                      $_POST['telefonoD'],$_POST['descripcionD'],$_POST['horarioD'],$_POST['correoD'],$_POST['facebookD'],
                      $_POST['instagramD'],$_FILES['logoD']['name'],$_POST['linkedinD']);

             //   $_POST = array();

                     
            }
         }
      }
    if(array_key_exists("buscarDirectorio",$_POST))
    {
        $nombreD = strtoupper($_POST['nombreD']); 
        $tipoD = $_POST['directorio'];
        $query= "SELECT * FROM directorio WHERE nombre='".$nombreD."' AND tipo='".$tipoD."'";
        $resultado= db_query($query);
        $fila = mysqli_fetch_array($resultado);
        $cont = 0;
        if(mysqli_num_rows($resultado)<1)
        {
            $error="El registro no se encuenta en la base de datos";
        }
        else
        {
            
            $id = $fila['id'];
            $nombreB = $fila['nombre'];
            $premiumB = $fila['premium'];
            $direccionB = $fila['direccion'];
            $ciudadB = $fila['ciudad'];
            $mapaB = $fila['mapa'];
            $telefonoB = $fila['telefono'];
            $descripcionB = $fila['descripcion'];
            $horarioB = $fila['horario'];
            list($primero,$segungo,$tercero,$logoB) = split('/', $fila['logo']);
            $correoB = $fila['correo'];
            $facebookB = $fila['facebook'];
            $instagramB = $fila['instagram'];
            $linkedinB = $fila['linkedin'];
        
           db_close();
          //  echo $nombreB.$premiumB.$direccionB.$ciudadB.$latitudB.$longitudB.$telefonoB.$descripcionB.$horarioB.$logoB.$correoB.$facebookB.$instagramB.$linkedinB;
        }
    }
    if(array_key_exists("posicionDirectorio",$_POST))
    {
       
        $tipoPos = $_POST['posdirectorio'];
        $query= "SELECT * FROM directorio WHERE premium='1' AND tipo='".$tipoPos."'";
        $resultado= db_query($query);
        while($filaPos=mysqli_fetch_array($resultado))
        {
        	$lista= $lista."<li id=\"".$filaPos['posicion']."\" class=\"default\">".$filaPos['nombre']."</li>";
        
           db_close();
          //  echo $nombreB.$premiumB.$direccionB.$ciudadB.$latitudB.$longitudB.$telefonoB.$descripcionB.$horarioB.$logoB.$correoB.$facebookB.$instagramB.$linkedinB;
        }
    }
    
     if(array_key_exists("enviarPos",$_POST)) //esta es la logica de posicion que no esta funcionando por mala logica de guardado en la base de datos
    {
       
        $arrayPos = $_POST['posicionesD'];
        $directPos = $_POST['tipoPos'];
        $query= "SELECT id,posicion FROM directorio WHERE premium='1' AND tipo='".$directPos."';";
        $resultado= db_query($query);
        $filaPos=mysqli_fetch_array($resultado);
        $idD[] = $filaPos[0];
        db_close();
        $p = 0; 
        for($i = 0 ; $i < strlen($arrayPos); $i++)
        {
            
            if($arrayPos[$i]!=",")
            {
                $p++;
                $idAct = $idD[$p];
                $query= "UPDATE directorio SET posicion='".$p."' WHERE tipo='".$directPos."' AND id='".$idAct."' AND posicion='".$arrayPos[$i]."';";
                db_query($query);
                db_close();
               
                echo " posicion actual: ".$arrayPos[$i];
                echo " nueva posicion: ".$p;
            }  
        }
      //  db_close();
    }
    if(array_key_exists("modificarDirectorio",$_POST))
    {

        $nombreD = strtoupper($_POST['nombreD']); 
        $tipoD = $_POST['directorio'];
        $premium = $_POST['premiumD'];
        $direccion = $_POST['direccionD'];
        $ciudad = $_POST['ciudadD'];
        $mapa = $_POST['mapaD'];
        $telefono = $_POST['telefonoD'];
        $descripcion = $_POST['descripcionD'];
        $horario = $_POST['horarioD'];
        $correo = $_POST['correoD'];
        $facebook = $_POST['facebookD'];
        $instagram = $_POST['instagramD'];
        $linkedin = $_POST['linkedinD'];
    
       // echo $nombreD.$premium.$direccion.$ciudad.$latitud.$longitud.$telefono.$descripcion.$horario.$logo_subido.$correo.$facebook.$instagram.$linkedin;
                $query = "SELECT id,logo FROM directorio WHERE nombre='".$nombreD."' AND tipo='".$tipoD."';";
                $resultado= db_query($query);
                $listaBD = mysqli_fetch_array($resultado);
                echo $_POST['idActual'].$listaBD['id'];
                if($_POST['idActual']!=$listaBD['id'] && mysqli_num_rows($resultado)>0)
                {
                    $error="Ya existe el directorio con ese registro";
                    $_POST = array();
                }
                else
                {
                    db_close();
                    $dir_subida = 'imagenes/logos/'.$tipoD.'/';
                    $logo_subido = $dir_subida.basename($_FILES['logoD']['name']);
                   // echo $nombreD.$premium.$direccion.$ciudad.$latitud.$longitud.$telefono.$descripcion.$horario.$logo_subido.$correo.$facebook.$instagram.$linkedin;
                    if(!basename($_FILES['logoD']['name'])){ $query = "update directorio set tipo='".$tipoD."', premium='".$premium."', nombre='".$nombreD."', direccion='".$direccion."', ciudad='".$ciudad."', mapa='".$mapa."', telefono='".$telefono."', descripcion='".$descripcion."', horario='".$horario."', correo='".$correo."', facebook='".$facebook."', instagram='".$instagram."', linkedin='".$linkedin."' where id='".$_POST['idActual']."';"; }
                    else if (move_uploaded_file($_FILES['logoD']['tmp_name'], $logo_subido)) { 
                        $query = "update directorio set tipo='".$tipoD."', premium='".$premium."', nombre='".$nombreD."', direccion='".$direccion."', ciudad='".$ciudad."', mapa='".$mapa."', telefono='".$telefono."', descripcion='".$descripcion."', horario='".$horario."', logo='".$logo_subido."', correo='".$correo."', facebook='".$facebook."', instagram='".$instagram."', linkedin='".$linkedin."' where id='".$_POST['idActual']."';";
                        $exitoso = "El logo es válido y se subió con éxito<br>"; }
                    else {$error = "¡No se logro subir el logo, por favor intente de nuevo!";}
                    
                    if (!db_query($query))
                    {
                      $error="No hemos podido modificar el registro, por favor inténtelo más tarde";
                    }
                    else
                    {
                        //echo $id.$nombreD.$premium.$direccion.$ciudad.$latitud.$longitud.$telefono.$descripcion.$horario.$logo_subido.$correo.$facebook.$instagram.$linkedin;
                        $exitoso.="Directorio modificado exitosamente";
                        db_close();
                    }
                }
        
    }
    
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LS Admin - Directorio</title>

<?php include('php/admin-header.php'); ?>

 <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gestionar Directorio</h1>
          </div>
          <?php if($error!=""){ echo "<div class=\"alert alert-danger\" role=\"alert\">".$error."</div>";}
               else if($exitoso!=""){ echo "<div class=\"alert alert-success\" role=\"alert\">".$exitoso."</div>";}
                else echo "";?>
          <form enctype="multipart/form-data" action="a-directorio.php" method="POST">
              <!-- Tipo de directorio ------->
              <div class="row">
              <div class="form-group col-sm-4 mt-2">
                <label for="tipodirectorio">Seleccionar directorio</label>
                <select name="directorio" class="form-control" id="tipodirectorio">
                <option value="Ambulancias" <?php if(array_key_exists("buscarDirectorio",$_POST) && $tipoD=="Ambulancias"){ echo "selected";} ?>>Ambulancia</option>
                <option value="Clinicas" <?php if(array_key_exists("buscarDirectorio",$_POST) && $tipoD=="Clinicas"){ echo "selected";} ?>>Clinica</option>
                <option value="Enfermeras" <?php if(array_key_exists("buscarDirectorio",$_POST) && $tipoD=="Enfermeras"){ echo "selected";} ?>>Enfermera</option>
                <option value="Farmacias" <?php if(array_key_exists("buscarDirectorio",$_POST) && $tipoD=="Farmacias"){ echo "selected";} ?>>Farmacia</option>
                <option value="Laboratorios" <?php if(array_key_exists("buscarDirectorio",$_POST) && $tipoD=="Laboratorios"){ echo "selected";} ?>>Laboratorio</option>
                <option value="Suministros" <?php if(array_key_exists("buscarDirectorio",$_POST) && $tipoD=="Suministros"){ echo "selected";} ?>>Suministro</option>
                </select>
              </div>
             <!----   Cargar logo  ----->
             <div class="col-sm-5" style="padding-top:0.75rem">
            <!-- <div class="custom-file">
              <input type="file" class="custom-file-input" id="customFileLang" name="logoD">
              <label class="custom-file-label" for="customFileLang">Seleccionar Logo</label>
            </div>-->
            <div class="form-group">
                <label for="exampleFormControlFile1">Seleccionar logo</label>
                <div><input name="logoD" type="file" class="form-control-file" id="exampleFormControlFile1"  accept="image/*" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$logoB."'";} ?>/> <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo $logoB;} ?></div>
              </div>
            </div>
            <!--- checkbox que pregunta si es premium o no --->
            <div class="col-sm-3" style="padding-top:2.5rem">
            <div class="custom-control custom-checkbox pl-5">
              <input type="checkbox" class="custom-control-input" id="customCheck1" name="premiumD" value="1" <?php if(array_key_exists("buscarDirectorio",$_POST) && $premiumB=="1"){ echo " checked";}?>>
              <label class="custom-control-label" for="customCheck1">Premium</label>
            </div>
            </div>
            </div>
            <!--- persona o empresa del directorio --->
            <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="titulo" id="direct"></label>
                <input type="text" class="form-control" id="titulo" name="nombreD" placeholder="ej. Psicologo Eduard Guerrero" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$nombreB."'";} ?>>
              </div>
             </div>
             <div class="col-sm-3 pt-4">
                <button type="submit" name="buscarDirectorio" class="btn mb-2" style="background-color: rgb(255,255,153)"><i class="fa fa-xs fa-search" aria-hidden="true"></i>
            </button> 
            </div>
            </div>
            <div class="row">
            <div class="col-sm-7">
             <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcionD" placeholder=" ej. Especialista en cognitivo conductual,terapia de parejas." <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$descripcionB."'";} ?>>
              </div>
            </div>
            <div class="col-sm-5">
             <div class="form-group">
                <label for="telefono">Telefonos</label>
                <input type="tel" class="form-control" id="telefono" name="telefonoD" placeholder=" ej. 0251-6350113 / 0414-0714813" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$telefonoB."'";} ?>>
              </div>
            </div>
            </div>  
             <div class="row">
            <div class="col-sm-9">
             <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccionD" placeholder=" ej. Avenida 1 entre Calle 7 y 8 casa Número 7-20, Centro Médico Los Pinos. Urb. La Mata" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$direccionB."'";} ?>>
              </div>
            </div>
            <div class="col-sm-3">
             <div class="form-group">
                <label for="city">Ciudad</label>
                <select name="ciudadD" class="form-control" id="city">
                <option value="Barquisimeto" <?php if(array_key_exists("buscarDirectorio",$_POST) && $ciudadB=="Barquisimeto"){ echo "selected";} ?>>Barquisimeto</option>
                <option value="Cabudare" <?php if(array_key_exists("buscarDirectorio",$_POST) && $ciudadB=="Cabudare"){ echo "selected";} ?>>Cabudare</option>
                <option value="Carora" <?php if(array_key_exists("buscarDirectorio",$_POST) && $ciudadB=="Carora"){ echo "selected";} ?>>Carora</option>
                <option value="Duaca" <?php if(array_key_exists("buscarDirectorio",$_POST) && $ciudadB=="Duaca"){ echo "selected";} ?>>Duaca</option>
                <option value="Tocuyo" <?php if(array_key_exists("buscarDirectorio",$_POST) && $ciudadB=="Tocuyo"){ echo "selected";} ?>>El tocuyo</option>
                <option value="Quibor" <?php if(array_key_exists("buscarDirectorio",$_POST) && $ciudadB=="Quibor"){ echo "selected";} ?>>Quibor</option>
                <option value="Sanare" <?php if(array_key_exists("buscarDirectorio",$_POST) && $ciudadB=="Sanare"){ echo "selected";} ?>>Sanare</option>
                <option value="Sarare" <?php if(array_key_exists("buscarDirectorio",$_POST) && $ciudadB=="Sarare"){ echo "selected";} ?>>Sarare</option>
                <option value="Siquisique" <?php if(array_key_exists("buscarDirectorio",$_POST) && $ciudadB=="Siquisique"){ echo "selected";} ?>>Siquisique</option>
                </select>
              </div>
            </div>
            </div>
             <div class="form-group">
                <label for="mapa">Mapa Google</label>
                <input type="text" class="form-control" id="mapa" name="mapaD" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$mapaB."'";} ?>>
              </div>
   
            </div>
            <div class="form-group">
                <label for="horario">Horario</label>
                <input type="text" class="form-control" id="horario" name="horarioD" placeholder=" ej. Atención Presencial: Martes, Jueves y Viernes (2pm a 6pm) Atención Online: Lunes a Viernes (8pm a 10pm) hora de Venezuela" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$horarioB."'";} ?>>
             </div>
            <div class="form-group w-50">
                <label for="correo">Correo</label>
                <input type="email" class="form-control" id="correo" name="correoD" placeholder=" ej. psicologoeduard@gmail.com" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$correoB."'";} ?>>
             </div>
              <div class="form-group w-75">
                <label for="facebook">Facebook</label>
                <input type="text" class="form-control"  id="facebook" name="facebookD" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$facebookB."'";} ?>>
             </div>
              <div class="form-group w-75">
                <label for="linkedin">LinkedIn</label>
                <input type="text" class="form-control" id="linkedin" name="linkedinD" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$linkedinB."'";} ?>>
             </div>
              <div class="row">
            <div class="col-sm-9">
              <div class="form-group w-93">
                <label for="instagram">Instagram</label>
                <input type="text" class="form-control" id="instagram" name="instagramD" <?php if(array_key_exists("buscarDirectorio",$_POST)){ echo "value='".$instagramB."'";} ?>>
             </div>
             </div>
             <div class="col-sm-1 pt-4">
             <button type="submit" name="agregarDirectorio" class="btn mb-2" style="background-color: rgb(255,255,153)"><i class="fa fa-xs fa-plus" aria-hidden="true"></i>
            </button>
            </div>
            <div class="col-sm-1 pt-4">
             <button type="submit" name="modificarDirectorio" class="btn mb-2" style="background-color: rgb(255,255,153)"><i class="fa fa-xs fa-edit" aria-hidden="true"></i>
            </button>
            </div>
            <div class="col-sm-1 pt-4">
            <button type="button" class="btn mb-2" style="background-color: rgb(255,255,153)" data-toggle="modal" data-target="#modal<?php echo $id; ?>"><i class="fa fa-xs fa-trash" aria-hidden="true"></i>
            </button>
            </div>
             </div>
            <input type="hidden" name="idActual" <?php echo 'value="'.$id.'"'; ?>/>
            <input type="hidden" name="nombreActual" <?php echo 'value="'.$nombreB.'"'; ?>/>
            <input type="hidden" name="tipoPos" id="tipoPos" <?php echo 'value="'.$tipoPos.'"'; ?>/>
            <input type="hidden" name="posicionesD" id="posicionesD" value=""/>
            <h3>Posiciones Premium</h3>
            <div class="row">
                  <div class="form-group col-sm-4 mt-2">
                    <label for="tipodirectorio">Seleccionar directorio</label>
                    <select name="posdirectorio" class="form-control" id="tipodirectorio">
                    <option value="Ambulancias">Ambulancia</option>
                    <option value="Clinicas">Clinica</option>
                    <option value="Enfermeras">Enfermera</option>
                    <option value="Farmacias">Farmacia</option>
                    <option value="Laboratorios">Laboratorio</option>
                    <option value="Suministros">Suministro</option>
                    </select>
                  </div>
                  <div class="col-sm-3" style="padding-top:2.5rem">
                    <button type="submit" name="posicionDirectorio" class="btn mb-2" style="background-color: rgb(255,255,153)"><i class="fa fa-xs fa-retweet" aria-hidden="true"></i>
                    </button>
                    <button type="submit" id="enviarPos" class="btn btn-info" name="enviarPos">Cambiar Posiciones</button>
                  </div>
                  </div>
              </div>
              <ul id = "sortable-8">
                 <?php echo $lista; ?>
              </ul>
              <br>
              <h3><span id ="sortable-9"></span></h3> 
          
        </div>
        <div class="modal fade" id="modal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Advertencia!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                 Esta seguro(a) que desea eliminar el directorio: <?echo $nombreB; ?>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a class="btn btn-info" href="php/borrar.php?id=<?echo $id; ?>&tabla=directorio&fila=id">Continuar</a>
              </div>
            </div>
          </div>
        </div>
        
        
      

 <?php include('php/admin-footer.php'); ?>