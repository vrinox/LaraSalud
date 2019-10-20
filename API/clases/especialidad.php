<?php
include_once("/home2/larasalu/public_html/API/clases/core.php");
class  cls_Especialidad extends Core{
  private $aa_Form;

  public function __construct(){
    $this->aa_Form=Array();
  }

  public function f_SetsForm($pa_Form){
    $this->aa_Form=$pa_Form;
    $this->aa_Form['especialidad'] = strtoupper($pa_Form['especialidad']); 
	}		
  
  public function	f_GetsForm(){			
		return $this->aa_Form;				
  }
  
  public function buscar(){
    $lsSql = "SELECT * FROM especialidades WHERE id ='".$this->aa_Form['id']."'";
    $this->f_Con();	
		$lr_Tabla=$this->f_Filtro($lsSql);				
		if($la_Tupla=$this->f_Arreglo($lr_Tabla)){
			$this->asignacion($la_Tupla);
			$lb_Enc=true;
		}				
		$this->f_Cierra($lr_Tabla);						
		$this->f_Des();	
		return $lb_Enc;	
  }
	
	public function listar(){				
    $laMatriz=Array();
    $lsSql="SELECT * FROM especialidades WHERE profesional='".$this->aa_Form['busqueda']."'";
    $this->f_Con();
    $lrTb=$this->f_Filtro($lsSql);				
    While($laTupla=$this->f_Arreglo($lrTb)){	
      array_push($laMatriz,$laTupla);
    }
    $this->f_Cierra($lrTb);		
    $this->f_Des();
    return $laMatriz;							
  }

  
	public function modificar(){
		$lb_Hecho = false; 
		$lsSql = "UPDATE especialidades SET especialidad='".$this->aa_Form['nombre']."' WHERE id = '".$this->aa_Form['id']."';";
		$this->f_Con();
		$lb_Hecho=$this->f_Ejecutar($lsSql);		
		$this->f_Des();
		return $lb_Hecho;
	}
  public function agregar(){
    $this->aa_Form['profesional']=($this->aa_Form['profesional']=="1")?"M":"O";
    $sql = $query = "INSERT INTO especialidades(especialidad,profesional) VALUES('".$this->aa_Form['nombre']."','".$this->aa_Form['profesional']."')";
    $this->f_Con();
    $lb_Hecho=$this->f_Ejecutar($sql);		
    $this->f_Des();    
    $result['mensaje']=(!$lb_Hecho)?"Directorio agregado exitosamente":"No hemos podido completar el registro, por favor inténtelo más tarde";
    
    return $result;
  }
  public function listarTodas()						
		{				
			$laMatriz=Array();
			$lsSql="SELECT * FROM especialidades";
			$this->f_Con();
			$lrTb=$this->f_Filtro($lsSql);				
			While($laTupla=$this->f_Arreglo($lrTb)){
        array_push($laMatriz,$laTupla);
			}
			$this->f_Cierra($lrTb);		
			$this->f_Des();
			return $laMatriz;							
  }
  public function borrar(){
		$lb_Hecho = false; 
		$lsSql = "DELETE FROM especialidades WHERE id = '".$this->aa_Form['id']."';";
		$this->f_Con();
		$lb_Hecho=$this->f_Ejecutar($lsSql);		
		$this->f_Des();
		return $lb_Hecho;
	}
	
	public function gestionar(){
    $resultado = array();
    switch($this->aa_Form['operacion']){
      case 'buscar': 
        $resultado['success'] = $this->buscar();
        $resultado['especialidad'] = $this->f_GetsForm();
        break;
      case 'listar':
        $resultado['especialidades'] = $this->listar();
        $resultado['success']=(count($resultado['especialidades'])>0);
        break;
      case 'listarTodas':
        $resultado['especialidades'] = $this->listarTodas();
        $resultado['success']=(count($resultado['especialidades'])>0);
        break;
      case 'agregar':
				if(!$this->validar()){
					$resultado['success'] = $this->agregar();
					if(!$resultado['success']){
						$resultado['mensaje'] = "Error al guardar especialidad";
					}
				}else{
					$resultado['success']=false;
					$resultado['mensaje']="especialidad ya existe";
				}				
				break;
			case 'borrar':
				$resultado['success'] = $this->borrar();
				if(!$resultado['success']){
					$resultado['mensaje'] = "Error al borrar especialidad";
				}					
				break;
			case 'modificar':
				$resultado['success'] = $this->modificar();
				if(!$resultado['success']){
					$resultado['mensaje'] = "Error al modificar especialidad";
				}					
				break;
      default:
				$resultado['success']=false;
				$resultado['mensaje']='operacion no seleccionada';
				break;
    }
    return $resultado;
  }
  public function asignacion($externo){
    foreach ($externo as $clave => $valor){
      $this->aa_Form[$clave] = $valor; 
    }
  }
  
	public function validar(){							
    $lb_Enc=false;	    
		$lsSql="SELECT * FROM espcialidades WHERE especialidad='".$this->aa_Form['especialidad']."' LIMIT 1;";			
		$this->f_Con();	
		$lr_Tabla=$this->f_Filtro($lsSql);				
		if($la_Tupla=$this->f_Arreglo($lr_Tabla)){
			$lb_Enc=true;
		}				
		$this->f_Cierra($lr_Tabla);						
		$this->f_Des();	
		return $lb_Enc;	
	}
	
}
?>
