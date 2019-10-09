<?php 
include("../clases/cls_Actualizar.php");
session_start();
if(array_key_exists(Operacion,$_POST))
{
	$laForm=$_POST;
	$lobj_Actualizar= new cls_Actualizar();
	$lobj_Actualizar->f_SetsForm($laForm);
}
if($laForm['Operacion']!="buscar")
{
	$lb_Hecho=false;
	if($laForm['Operacion']=="lista"){
		$_SESSION['matriz']=$lobj_Actualizar->fListar(); //le mando la pagina como parametro para resivir el arreglo lleno 
		$_SESSION["Campos"]=$laForm;
		header("location: ../vistas/vis_Actualizar.php?buscar");
	}
	else if($laForm['Operacion']!="lista")
	{
		$lb_Hecho=$lobj_Actualizar->f_Operacion();
		if($lb_Hecho)
		{
			unset($laForm);
			$laForm['Mensaje']="Datos Actualizados Con Exito";
			$_SESSION['usuario']["Mensaje"]=$laForm['Mensaje'];
			header("location: ../vistas/vis_Inicio.php");
		}else{
			$laForm["Mensaje"]=$_SESSION['Mensaje'];
			unset($_SESSION['Mensaje']);
			$_SESSION['usuario']["Mensaje"]=$laForm['Mensaje'];
			header("location: cor_PrimeraVez.php?Operacion=buscar");
		}
	}
}
?>