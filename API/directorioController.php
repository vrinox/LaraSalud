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