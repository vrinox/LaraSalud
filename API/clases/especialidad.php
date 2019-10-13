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
  

	
	public function listar(){				
    $laMatriz=Array();							
    $liI=1;		
    $lsSql="SELECT * FROM especialidades WHERE profesional='".$this->aa_Form['busqueda']."'";
    $this->f_Con();
    $lrTb=$this->f_Filtro($lsSql);				
    While($laTupla=$this->f_Arreglo($lrTb)){	
      $laMatriz [$liI]= $laTupla;
      $liI++;   
    }
    $this->f_Cierra($lrTb);		
    $this->f_Des();
    return $laMatriz;							
  }

  public function agregar(){
    $this->aa_Form['profesional']=($this->aa_Form['medicos']=="1")?"M":"O";
    $sql = $query = "INSERT INTO especialidades(especialidad,profesional) VALUES('".$this->aa_Form['especialidad']."','".$this->aa_Form['profesional']."')";
    $this->f_Con();
    $lb_Hecho=$this->f_Ejecutar($sql);		
    $this->f_Des();    
    $result['mensaje']=(!$lb_Hecho)?"Directorio agregado exitosamente":"No hemos podido completar el registro, por favor inténtelo más tarde";
    
    return $result;
  }
  public function listarTodas()						
		{				
			$laMatriz=Array();							
			$liI=1;		
			$lsSql="SELECT * FROM especialidades";
			$this->f_Con();
			$lrTb=$this->f_Filtro($lsSql);				
			While($laTupla=$this->f_Arreglo($lrTb)){	
				$laMatriz [$liI] = $laTupla;
				$liI++;   
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
        $resultado['especialidad'] = $this->get();
        break;
      case 'listar':
        $resultado['especialidades'] = $this->listar();
        $resultado['success']=(count($resultado['especialidades'])>0);
        break;
      case 'listarTodas':
        $resultado['especialidades'] = $this->listarTodas();
        $resultado['success']=(count($resultado['especialidades'])>0);
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
}
?>
