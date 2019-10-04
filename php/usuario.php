<?php
  session_start();
  if(array_key_exists("usuario",$_COOKIE) or array_key_exists("usuario",$_SESSION)){
    $_SESSION['usuario'] = $_COOKIE['usuario'];
  }
  else
  {
    header("Location: adminlogin.php");
  }
?>