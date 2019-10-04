<?php
    header("Content-Type: text/html;charset=utf-8");
    session_start();
    $error="";
    if(array_key_exists("Logout",$_GET))
    {
        //viene de la pagina sesion iniciada
        session_unset();
       // Borra todas las variables de sesión 
        $_SESSION = array(); 
        // Borra la cookie que almacena la sesión 
        if(isset($_COOKIE[session_name()])) { 
            setcookie('usuario', '', 1); 
        } 
        // Finalmente, destruye la sesión 
        session_destroy(); 
        $_GET = array();
    }
    else if((array_key_exists('usuario',$_SESSION) AND $_SESSION['usuario']) OR (array_key_exists('usuario',$_COOKIE) AND $_COOKIE['usuario']))
    {
        header("Location: larasalud-admin.php");
    }
    if(array_key_exists("submit",$_POST))
    {
        $enlace=mysqli_connect("51.91.31.196", "larasalu_admin", "conejototuga.1", "larasalu_directorio");
        if (mysqli_connect_error()) 
        {
          die("Error de conexión en la base de datos");
        }
        if(!$_POST['clave'])
        {
            $error .= "<br>Contraseña requerida.";
        }
        if($error!="")
        {
            $error="<p>Hay errores en el formulario, por favor chequear:".$error. "</p>";
        }
        else
        {
            $query= "SELECT * FROM usuarios WHERE usuario='Administrador'";
            $resultado= mysqli_query($enlace,$query);
            $fila= mysqli_fetch_array($resultado);
            if(isset($fila))
            {
                $clave=(md5($_POST['clave']));
                if($clave==$fila['clave'])
                {
                    $_SESSION['usuario'] = "Administrador";
                    if($_POST['permanecerIniciada']=='1')
                    {                    
                     setcookie("usuario",$_SESSION['usuario'], time()+60*60*24*365);
                    }
                    header("Location: larasalud-admin.php");
                }
                else if($_POST['clave']!="" AND $_POST['clave']!="Escribe la contraseña")
                {
                    $error= "Contraseña Incorrecta!";
                }
            }
        }
    }
    mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Lara Salud</title>
  <link rel="shortcut icon" href="imagenes/iconos/LOGO.ico" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/EstilosLS.css"></head>
  <style type="text/css">
      body, html {
            height: 100% !important;
        }
        .bg-img {
            /* The image used */
            background-image: url("imagenes/adminlogin.jpg") !important; 

            /* Control the height of the image */
            min-height: 380px !important;
            height: 100% !important;
            width: 100% !important;
            /* Center and scale the image nicely */
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
            position: relative !important;
        }
  </style>

<body class="bg-img">
<a href="larasalud.php"><img class="mb-3 mt-5 ml-auto mr-auto" style="display:block;" src="imagenes/LOGO.png"></a>
    <div class="container-fluid w-50 pb-3" style="background-color: rgba(0, 0, 0, 0.3);">
        
        <h3 class="text-center" style="color: white;">Administrador</h3>
        <div id="error">
            <?php echo $error; ?>
        </div>
        <form method="POST">
            <fieldset class="formgroup">
                <input class="form-control" type="password" name="clave" placeholder="Escribe la contraseña">
            </fieldset>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="permanecerIniciada" value=1>Permanecer Iniciada
                </label>
            </div>
            <fieldset class="formgroup">
                <input class="btn btn-info ml-auto mr-auto" style="display:block;" type="submit" name="submit" value="Inciar Sesión">
            </fieldset>
        </form>
    </div>
</body>
</html>
