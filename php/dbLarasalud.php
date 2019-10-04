<?php
    session_start();
    header("Content-type:text/html;charset=utf-8");
    //$salt= "fhgjrig3452fwghg384%#r7";
    //$textoCifrado = md5("password");
    $error="";
    if(array_key_exists("Logout",$_GET)){
        //viene de la sesion anterior
        session_unset();
        setcookie("id","", time()-60*60);
        $_COOKIE['id']="";
    }
    else if((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id'])){
        header("Location:larasalud-admin.php");
    }
    if(array_key_exists("submit",$_POST))
    {
        $enlace = mysqli_connect("shareddb-o.hosting.stackcp.net", "LaraSalud-3130391def", "86wf48afoj", "LaraSalud-3130391def");
        if (mysqli_connect_error()) {
            die("Error de conexión en la base de datos");
        }
        if(!$_POST['clave'])
        {
            $error = '<div class="alert alert-danger" role="alert"><p><strong>El campo contraseña es obligatorio</div>';
        }
        else{
            $query = "SELECT clave from usuarios  WHERE usuario='Administrador'";
            $resultado= mysqli_query($enlace,$query);
            if($resultado==mysqli_real_escape_string($enlace,$_POST['clave']))
            {
                $_SESSION['id'] = "Administrador";
                if($_POST['permaneceriniciada']==1)
                {
                    setcookie("id","Administrador", time()+60*60*24*365);
                }
                header ("location: larasalud-admin.php"); 
            }
            else
            {
                $error = '<div class="alert alert-danger" role="alert"><p><strong>Clave incorrecta!</div>';
            }
           
            /*if($result=mysqli_query($enlace,$query))
            {
                /*
                COPIA UNA SOLA FILA DE LA TABLA
                $fila=mysqli_fetch_array($result);
                print_r($fila);
                echo "Tu nombre de usuario es ".$fila[1]." y tu clave es ".$fila[2];
             */
            /*   
                while($fila=mysqli_fetch_array($result))
                {
                    print_r($fila);
                }
        }*/
            
        }
    }
    //conectar a la base de datos
    //$enlace = mysqli_connect("shareddb-o.hosting.stackcp.net", "LaraSalud-3130391def", "86wf48afoj", "LaraSalud-3130391def");
   mysqli_close($enlace);

?>