<?php
include_once("/home2/larasalu/public_html/API/clases/core.php");
class  cls_Categoria extends Core{
  private $aa_Form;

  public function __construct(){
    $this->aa_Form=Array();
  }

  public function f_SetsForm($pa_Form){	
		$this->aa_Form=$pa_Form;
		$this->aa_Form['categoria'] = strtoupper($this->aa_Form['categoria']);
	}		
  
  public function	f_GetsForm(){			
		return $this->aa_Form;				
	}		
	
	public function buscar(){							
		$laMatriz=Array();
		$lsSql="SELECT * FROM categorias WHERE categoria  like '%".$this->aa_Form['categoria']."%';";
		$this->f_Con();
		$lrTb=$this->f_Filtro($lsSql);				
		While($laTupla=$this->f_Arreglo($lrTb)){	
			array_push($laMatriz,$laTupla);
		}
		$this->f_Cierra($lrTb);
		$this->f_Des();
		return $laMatriz;
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
	public function agregar(){
		$lb_Hecho = false; 
		$lsSql = "INSERT INTO categorias (categoria) values ('".$this->aa_Form['categoria']."');";
		$this->f_Con();
		$lb_Hecho=$this->f_Ejecutar($lsSql);		
		$this->f_Des();
		return $lb_Hecho;
	}

	public function borrar(){
		$lb_Hecho = false; 
		$lsSql = "DELETE FROM categorias WHERE id = '".$this->aa_Form['id']."';";
		$this->f_Con();
		$lb_Hecho=$this->f_Ejecutar($lsSql);		
		$this->f_Des();
		return $lb_Hecho;
	}
	public function validar(){							
    $lb_Enc=false;	    
		$lsSql="SELECT * FROM categorias WHERE categoria='".$this->aa_Form['categoria']."' LIMIT 1;";			
		$this->f_Con();	
		$lr_Tabla=$this->f_Filtro($lsSql);				
		if($la_Tupla=$this->f_Arreglo($lr_Tabla)){
			$lb_Enc=true;
		}				
		$this->f_Cierra($lr_Tabla);						
		$this->f_Des();	
		return $lb_Enc;	
	}
	
	public function gestionar(){
    $resultado = array();
    switch($this->aa_Form['operacion']){
      case 'buscar': 
        $resultado['categorias'] = $this->buscar();
				$resultado['success']=(count($resultado['categorias'])>0);
        break;
      case 'listar':
				$resultado['categorias'] = $this->listar();				
				$resultado['success']=(count($resultado['categorias'])>0);
				break;
			case 'agregar':
				if(!$this->validar()){
					$resultado['success'] = $this->agregar();
					if(!$resultado['success']){
						$resultado['mensaje'] = "Error al guardar categoria";
						$resultado['sql'] = "INSERT INTO categorias (categoria) values ('".$this->aa_Form['categoria']."');";
					}
				}else{
					$resultado['success']=false;
					$resultado['mensaje']="Categoria ya existe";
				}				
				break;
			case 'borrar':
				$resultado['success'] = $this->borrar();
				if(!$resultado['success']){
					$resultado['mensaje'] = "Error al borrar categoria";
					$resultado['sql'] = "INSERT INTO categorias (categoria) values ('".$this->aa_Form['categoria']."');";
				}					
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
