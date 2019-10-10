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
	public function gestionar(){
    $resultado = array();
    switch($this->aa_Form['operacion']){
      case 'buscar': 
        $resultado['success'] = $this->buscar();
        $resultado['categoria'] = $this->get();
        break;
      case:'listar':
				$resultado['categorias'] = $this->listar();				
				$resultado['success']=(count($resultado['categorias'])>0)
        break;
    }
    return $resultado;
  }
  public function asignacion($externo){
    foreach ($externo as $clave => $valor){
      $this->aa_Form[$clave] = $valor; 
    }
  }
}
?>
