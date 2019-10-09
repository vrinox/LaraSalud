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