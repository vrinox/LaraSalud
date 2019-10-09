<?php
include_once("./core.php");
class  cls_Categoria extends Core{
  private $aa_Form;

  public function __construct(){
    $this->aa_Form=Array();
  }

  public function f_SetsForm($pa_Form){	
		$this->aa_Form=$pa_Form;			
	}		
  
  public function	f_GetsForm(){			
		return $this->aa_Form;				
	}		
	
	public function buscar(){							
    $lb_Enc=false;	    
		$ls_Sql="SELECT * FROM categoria WHERE id='".$this->aa_Form['id']."' LIMIT 1;";			
		$this->f_Con();	
		$lr_Tabla=$this->f_Filtro($ls_Sql);				
		if($la_Tupla=$this->f_Arreglo($lr_Tabla)){
			$this->aa_Form['id']=$la_Tupla["id"];
			$this->aa_Form['nombre']=$la_Tupla["nombre"];
			$lb_Enc=true;
		}				
		$this->f_Cierra($lr_Tabla);						
		$this->f_Des();	
		return $lb_Enc;	
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
