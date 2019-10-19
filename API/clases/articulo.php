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
	public function asignacion($externo){
    foreach ($externo as $clave => $valor){
      $this->aa_Form[$clave] = $valor; 
    }
  }
	public function buscar(){							
    $lb_Enc=false;	    
		$lsSql="SELECT * FROM articulos WHERE titulo='".$this->aa_Form['titulo']."' LIMIT 1;";			
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
	public function agregar(){
		$lb_Hecho = false;

		//obtengo las imagenes
		$imagenuno = $this->gestionaImagen($this->aa_Form["imagenuno"],'iP');
		if($imagenuno['success']){
			$imagendos = $this->gestionaImagen($this->aa_Form["imagendos"],'iS');
			if($imagendos['success']){
				$sql = "INSERT INTO articulo";
				$sql.= "(titulo,subtitulo,descripcion,imagenuno,imagendos,contenido,enlace,autor) ";
				$sql.= "VALUES('".$this->aa_Form["titulo"]."','".$this->aa_Form["subtitulo"]."','".$this->aa_Form["descripcion"]."'";
				$sql.=",'".$imagenuno['ruta']."','".$imagendos['ruta']."','".$this->aa_Form["contenido"]."','".$this->aa_Form["enlace"]."'";
				$sql.=",'".$this->aa_Form["autor"]."')";
			
				$this->f_Con();
				$lb_Hecho=$this->f_Ejecutar($sql);		
				$this->f_Des();
			}else{
				$result['error'] = $imagendos['mensaje'];
			}
		}else{
			$result['error'] = $imagenuno['mensaje'];
		}		
		
		$result['mensaje']=($lb_Hecho)?"Articulo agregado exitosamente":"No hemos podido completar el registro, por favor inténtelo más tarde";
		$result['success'] = $lb_Hecho;

		return $result;
	}
	public function gestionar(){
    $resultado = array();
    switch($this->aa_Form['operacion']){
      case 'buscar': 
        $resultado['success'] = $this->buscar();
        $resultado['articulo'] = $this->f_GetsForm();
        break;
      case 'listar':
				$resultado['articulos'] = $this->listar();
				$resultado['success']=(count($resultado['articulos'])>0);
				break;
			case 'agregar':
				$resultado['success'] = $this->agregar();
				if($resultado['success']){
					$resultado['articulo']=$this->f_GetsForm();
					$resultado['mensaje'] = 'Articulo agregardo con exito';
				}else{
					$resultado['mensaje'] = 'Error al agregar el articulo por favor intent mas tarde';
				}				
				break;
			default:
				$resultado['success']=false;
				$resultado['mensaje']='operacion no seleccionada';
				break;
    }
    return $resultado;
  }
	public function gestionaImagen($string,$nombre){
    $success = true;    
		//convierto la cadena de base64 a file y lo guardo en un archivo
		try{
			$data = $string;
			if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
				$data = substr($data, strpos($data, ',') + 1);
				$type = strtolower($type[1]); // jpg, png, gif
		
				if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
						throw new \Exception('invalid image type');
				}    
				$data = base64_decode($data);    
				if ($data === false) {
						throw new \Exception('base64_decode failed');
				}
			} else {
					throw new \Exception('did not match data URI with image data');
			}
			
			$nombre .= date("Y-m-d_H:i:s");
			$ruta = "/home2/larasalu/public_html/imagenes/articulos/{$nombre}.{$type}";
			file_put_contents($ruta, $data);
			$mensaje = "El logo es válido y se subió con éxito<br>";  
		}catch(Exception $e){        
			$success = false;
			// $mensaje = "¡No se logro subir el logo, por favor intente de nuevo!";
			$mensaje = $e->getMessage();
		}      
      
    $result = array(
      'success' => $success,
      'mensaje' => $mensaje,
			'ruta'    => $ruta,
			'nombre' 	=> $nombre
    );
    return $result;
  }
}
?>
