<?php
include_once("./core.php");
class  cls_Directorio extends Core{
  private $aa_Form;

  public function __construct(){
    $this->aa_Form=Array();
    $this->aa_Files=Array();
  }

  public function f_SetsForm($pa_Form,$pa_Files){
    $this->aa_Form=$pa_Form;
    $this->aa_Form['nombre'] = strtoupper($this->aa_Form['nombre']);
    $this->aa_Files=$pa_Files;
    $this->aa_Form['dir_subida'] = "imagenes/logos/".$this->aa_Form['tipo']."/";
	}		
  
  public function	f_GetsForm(){			
		return $this->aa_Form;				
	}		
	
	public function buscar(){							
    $lb_Enc=false;	    
		$ls_Sql="SELECT * FROM directorio WHERE nombre='".$this->aa_Form['nombre']."' AND tipo='".$this->aa_Form['tipo']."' LIMIT 1";
		$this->f_Con();	
		$lr_Tabla=$this->f_Filtro($ls_Sql);				
		if($la_Tupla=$this->f_Arreglo($lr_Tabla)){
			$this->aa_Form['id']=$la_Tupla["id"];
			$this->aa_Form['premium']=$la_Tupla["premium"];
			$this->aa_Form['direccion']=$la_Tupla["direccion"];
			$this->aa_Form['ciudad']=$la_Tupla["ciudad"];
			$this->aa_Form['mapa']=$la_Tupla["mapa"];
			$this->aa_Form['telefono']=$la_Tupla["telefono"];
			$this->aa_Form['descripcion']=$la_Tupla["descripcion"];
			$this->aa_Form['horario']=$la_Tupla["horario"];
			$this->aa_Form['facebook']=$la_Tupla["facebook"];
			$this->aa_Form['correo']=$la_Tupla["correo"];
			$this->aa_Form['instagram']=$la_Tupla["instagram"];
      $this->aa_Form['correo']=$la_Tupla["linkedin"];
			$lb_Enc=true;
		}				
		$this->f_Cierra($lr_Tabla);						
		$this->f_Des();	
		return $lb_Enc;	
  }

  public function buscarPremium(){
    $lb_Enc=false;	    
		$ls_Sql="SELECT * FROM directorio WHERE premium='1' AND tipo='".$this->aa_Form['tipo']."'";
		$this->f_Con();	
		$lr_Tabla=$this->f_Filtro($ls_Sql);				
		if($la_Tupla=$this->f_Arreglo($lr_Tabla)){
			$this->aa_Form['id']=$la_Tupla["id"];
			$this->aa_Form['premium']=$la_Tupla["premium"];
			$this->aa_Form['direccion']=$la_Tupla["direccion"];
			$this->aa_Form['ciudad']=$la_Tupla["ciudad"];
			$this->aa_Form['mapa']=$la_Tupla["mapa"];
			$this->aa_Form['telefono']=$la_Tupla["telefono"];
			$this->aa_Form['descripcion']=$la_Tupla["descripcion"];
			$this->aa_Form['horario']=$la_Tupla["horario"];
			$this->aa_Form['facebook']=$la_Tupla["facebook"];
			$this->aa_Form['correo']=$la_Tupla["correo"];
			$this->aa_Form['instagram']=$la_Tupla["instagram"];
      $this->aa_Form['correo']=$la_Tupla["linkedin"];
      
			$lb_Enc=true;
		}				
		$this->f_Cierra($lr_Tabla);						
		$this->f_Des();	
		return $lb_Enc;
  }

  public function captaLogo($operacion){
    $success = true;
    //esta es una validacion en el caso que el usuario no suba imagen se coloca un icono que ya esta en el servidor
    if(!basename($_FILES['logo']['name'])){ 
      if(!$operacion == 'modificar'){
        $logo_subido = "imagenes/iconos/50x50/".$this->aa_Form['tipo'].".png";
      }
    }else if(move_uploaded_file($_FILES['logo']['tmp_name'], $logo_subido)){
      $mensaje = "El logo es válido y se subió con éxito<br>";
    }else{
      $success = false;
      $mensaje = "¡No se logro subir el logo, por favor intente de nuevo!";
    }
    return new Array(
      'success' => $success,
      'mensaje' => $mensaje,
      'logo'    => $logo_subido
    );
  }
  public function modificar(){
    $lb_Hecho =  false;
    $lb_Enc = $this.buscar();
    echo $_POST['idActual'].$listaBD['id'];
    if($lb_Enc && $this->aa_Form['idActual']!=$this->aa_Form['id'])
    {
      $error="Ya existe el directorio con ese registro";
      $_POST = array();
    }
    else
    {
      $result = $this->captaLogo('modificar');
      if($result['success']){
        $sqlLogo = '';
        if(!strpos($result['logo'],'50x50')) {
          $sqlLogo = "logo='".$result['logo']."'";
        }
        $sql = "update directorio ";
        $sql.= "set tipo='".$this->aa_Form['tipo']."', premium='".$this->aa_Form['premium']."', nombre='".$this->aa_Form['nombre']."', ";
        $sql.= "direccion='".$this->aa_Form['direccion']."', ciudad='".$this->aa_Form['ciudad']."', mapa='".$this->aa_Form['mapa']."', ";
        $sql.= "telefono='".$this->aa_Form['telefono']."', descripcion='".$this->aa_Form['descripcion']."', ";
        $sql.= "horario='".$this->aa_Form['horario']."', $sqlLogo , correo='".$this->aa_Form['correo']."', ";
        $sql.= "facebook='".$this->aa_Form['facebook']."', instagram='".$this->aa_Form['instagram']."', linkedin='".$this->aa_Form['linkedin']."' where id='".$this->aa_Form['idActual']."'";
      }

      $this->f_Con();
			$lb_Hecho=$this->f_Ejecutar($ls_Sql);		
      $this->f_Des();
      
      if ($lb_Hecho)
      {
        $result['mensaje']="No hemos podido modificar el registro, por favor inténtelo más tarde";
      }
      else
      {
        $result['mensaje'].="Directorio modificado exitosamente";
      }
      return $result
    }      
  }
  public function listar()						
		{				
			$laMatriz=Array();							
			$liI=1;		
			$ls_Sql="SELECT * FROM categorias";
			$this->f_Con();
			$lrTb=$this->f_Filtro($lsSql);				
			While($laTupla=$this->f_Arreglo($lrTb)){	
				$laMatriz [$liI] [0]= $laTupla ["id"];
				$laMatriz [$liI] [1]= $laTupla ["nombre"];
				$liI++;   
			}					
			$lrTb=$this->f_Filtro($lsSql);
			$this->f_Cierra($lrTb);		
			$this->f_Des();
			return $laMatriz;							
  }
  
  // public function f_Operacion(){						
	// 	$lb_Hecho=false;
	// 	if($this->aa_Form['Operacion']=="incluir"){		
	// 		$ls_Sql="INSERT INTO ambiente (codigo,nombre,direccion,estatus,borrado,tip_cod)";						
	// 		$ls_Sql.="VALUES";							
	// 		$ls_Sql.="('".$this->aa_Form['Codigo']."','".$this->aa_Form['Nombre']."',";
	// 		$ls_Sql.="'".$this->aa_Form['Direccion']."','".$this->aa_Form['Estatus']."'";							
	// 		$ls_Sql.=",'I','".$this->aa_Form['Tipo']."')";
	// 	}else if($this->aa_Form['Operacion']=="modificar"){
	// 		$ls_Sql="UPDATE ambiente SET nombre='".$this->aa_Form['Nombre']."',";	
	// 		$ls_Sql.="direccion='".$this->aa_Form['Direccion']."', estatus='".$this->aa_Form['Estatus']."',";		
	// 		$ls_Sql.="tip_cod='".$this->aa_Form['Tipo']."' ";
	// 		$ls_Sql.=" WHERE(codigo='".$this->aa_Form['Codigo']."')";				
	// 	}else if($this->aa_Form['Operacion']=="eliminar"){
	// 		$ls_Sql="UPDATE ambiente SET borrado='A' WHERE(codigo='".$this->aa_Form['Codigo']."')";					
	// 	}				
	// 	if($this->f_Supervisar("Ambiente",$ls_Sql,"Usuario en session")){			
	// 		$this->f_Con();
	// 		$lb_Hecho=$this->f_Ejecutar($ls_Sql);		
	// 		$this->f_Des();
	// 	}				
	// 	return $lb_Hecho;
	// }										
}
?>
