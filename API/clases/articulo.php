<?php
include_once("/home2/larasalu/public_html/API/clases/core.php");
class  cls_Articulo extends Core{
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
		$lsSql="SELECT * FROM articulos WHERE titulo='".$this->aa_Form['titulo']."' LIMIT 1;";			
		$this->f_Con();	
		$lr_Tabla=$this->f_Filtro($lsSql);				
		if($la_Tupla=$this->f_Arreglo($lr_Tabla)){
			$lb_Enc=true;
		}				
		$this->f_Cierra($lr_Tabla);						
		$this->f_Des();	
		return $lb_Enc;	
  }
  
  public function listar ()						
		{				
			$laMatriz=Array();							
			$lsSql="SELECT id,nombre from articulos";
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
        $resultado['articulo'] = $this->get();
        break;
      case 'listar':
				$resultado['articulos'] = $this->listar();
				$resultado['success']=(count($resultado['articulos'])>0);
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
