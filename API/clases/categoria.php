<?php
include_once("/home2/larasalu/public_html/API/clases/core.php");
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
		$lsSql="SELECT * FROM categorias WHERE id='".$this->aa_Form['id']."' LIMIT 1;";			
		$this->f_Con();	
		$lr_Tabla=$this->f_Filtro($lsSql);				
		if($la_Tupla=$this->f_Arreglo($lr_Tabla)){
			$this->aa_Form['id']=$la_Tupla["id"];
			$this->aa_Form['nombre']=$la_Tupla["nombre"];
			$lb_Enc=true;
		}				
		$this->f_Cierra($lr_Tabla);						
		$this->f_Des();	
		return $lb_Enc;	
  }
  
  public function listar(){
		$laMatriz=Array();
		$lsSql="SELECT * FROM categorias";
		$this->f_Con();
		$lrTb=$this->f_Filtro($lsSql);				
		While($laTupla=$this->f_Arreglo($lrTb)){	
			array_push($laMatriz,$laTupla);
		}
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
      case 'listar':
				$resultado['categorias'] = $this->listar();				
				$resultado['success']=(count($resultado['categorias'])>0);
				break;
			default:
				$resultado['success']=false;
				$resultado['mensaje']='operacion no seleccionada';
				break;
    }
    return $resultado;
  }
}
?>
