<?php
include_once("/home2/larasalu/public_html/API/clases/core.php");
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
  
  public function gestionar(){
    $resultado = array();
    switch($this->aa_Form['operacion']){
      case 'buscar': 
        $resultado['success'] = $this->buscar();
        $resultado['directorio'] = $this->f_GetsForm();
        break;
      case 'agregar':
        $resultado = $this->agregar();
        break;
      case 'modificar':
        $resultado = $this->modificar();
        break;
      case 'borrar':
        $resultado = $this->borrar();        
        break;
      case 'posicionar':
        $resultado['directorios'] = $this->buscarPremium();
        $resultado['success']=(count($resultado['directorios'])>0);
        break;  
      case 'listarPorCiudad':
        $resultado['directorios'] = $this->listarPorCiudad();
        $resultado['success']=(count($resultado['directorios'])>0);
        break;
      case 'listar':
        $resultado['directorios'] = $this->listar();
        $resultado['success']=(count($resultado['directorios'])>0);
        break;
      case 'enviarPos':
        $resultado= $this->enviarPos();
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
	public function buscar(){							
    $lb_Enc=false;	    
		$lsSql="SELECT * FROM directorio WHERE nombre='".$this->aa_Form['nombre']."' AND tipo='".$this->aa_Form['tipo']."' LIMIT 1";
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

  public function listarPorCiudad ()						
  {				
    $laMatriz=Array();
    $lsSql="SELECT * FROM directorio where tipo = '".$this->aa_Form['tipo']."' AND ciudad='".$this->aa_Form['ciudad']."';";
    $this->f_Con();
    $lrTb=$this->f_Filtro($lsSql);				
    While($laTupla=$this->f_Arreglo($lrTb)){
      array_push($laMatriz,$laTupla);
    }
    $this->f_Cierra($lrTb);		
    $this->f_Des();
    return $laMatriz;							
  }

  public function listar()						
  {				
    $laMatriz=Array();
    $lsSql="SELECT * FROM directorio ";
    $this->f_Con();
    $lrTb=$this->f_Filtro($lsSql);				
    While($laTupla=$this->f_Arreglo($lrTb)){
      array_push($laMatriz,$laTupla);
    }
    $this->f_Cierra($lrTb);		
    $this->f_Des();
    return $laMatriz;							
  }

  public function buscarPremium(){
    $laMatriz=Array();
    $lsSql="SELECT * FROM directorio WHERE premium='1' AND tipo='".$this->aa_Form['tipo']."' order by posicion";
    $this->f_Con();
    $lrTb=$this->f_Filtro($lsSql);				
    While($laTupla=$this->f_Arreglo($lrTb)){
      array_push($laMatriz,$laTupla);
    }
    $this->f_Cierra($lrTb);		
    $this->f_Des();
    return $laMatriz;
  }

  public function captaLogo($operacion){
    $success = true;
    //esta es una validacion en el caso que el usuario no suba imagen se coloca un icono que ya esta en el servidor
    if(!$this->aa_Form['file']){ 
      if(!$operacion == 'modificar'){
        $logo_subido = "imagenes/iconos/50x50/".$this->aa_Form['tipo'].".png";
      }
    }else{
      //convierto la cadena de base64 a file y lo guardo en un archivo
      try{
        $data = $this->aa_Form['file'];
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
        $tipo = $this->aa_Form['tipo'];
        $nombre = $this->aa_Form['nombre'];
        $logo_subido = "/home2/larasalu/public_html/imagenes/logos/{$tipo}/{$nombre}.{$type}";
        file_put_contents($logo_subido, $data);
        $mensaje = "El logo es válido y se subió con éxito<br>";  
      }catch(Exception $e){        
        $success = false;
        // $mensaje = "¡No se logro subir el logo, por favor intente de nuevo!";
        $mensaje = $e->getMessage();
      }      
      
    } 
    $result = array(
      'success' => $success,
      'mensaje' => $mensaje,
      'logo'    => $logo_subido
    );
    return $result;
  }
  public function modificar(){
    $lb_Hecho =  false;   
    $result = $this->captaLogo('modificar');
    if($result['success']){
      $sqlLogo = '';
      if(!strpos($result['logo'],'50x50') && $result['logo'] != '') {
        $sqlLogo = "logo='".$result['logo']."',";
      }
      $sql = "update directorio ";
      $sql.= "set tipo='".$this->aa_Form['tipo']."', premium='".$this->aa_Form['premium']."', nombre='".$this->aa_Form['nombre']."', ";
      $sql.= "direccion='".$this->aa_Form['direccion']."', ciudad='".$this->aa_Form['ciudad']."', mapa='".$this->aa_Form['mapa']."', ";
      $sql.= "telefono='".$this->aa_Form['telefono']."', descripcion='".$this->aa_Form['descripcion']."', ";
      $sql.= "horario='".$this->aa_Form['horario']."', $sqlLogo correo='".$this->aa_Form['correo']."', ";
      $sql.= "facebook='".$this->aa_Form['facebook']."', instagram='".$this->aa_Form['instagram']."', linkedin='".$this->aa_Form['linkedin']."'";
      $sql.= " where id='".$this->aa_Form['id']."'";
      
      $this->f_Con();
      $lb_Hecho=$this->f_Ejecutar($sql);		
      $this->f_Des();
    }

    $result['mensaje']=($lb_Hecho)?"Directorio modificado exitosamente":"No hemos podido modificar el registro, por favor inténtelo más tarde";
    return $result;
  }
  public function agregar(){
    $lb_Enc = $this->buscar();
    if($lb_Enc)
    {
      $error="Ya existe el directorio";
    }
    else
    {   
      $premiun = $this->buscarPremium();
      $posicion = count($result) + 1;
      //capturo la imagen del logo
      $result = $this->captaLogo('insertar');
      if($premium=="1"){
        $posicionStr = ",'".$posicion."'";
        $posicionV = ",posicion";
      } 
      else {
        $posicionStr = '';
        $posicionV = "";
      }
      $sql = "INSERT INTO directorio";
      $sql.= "(tipo,premium,nombre,direccion,ciudad,mapa,telefono,descripcion,horario,logo,correo,facebook,instagram,linkedin $posicionV) ";
      $sql.= "VALUES('".$this->aa_Form["tipo"]."','".$this->aa_Form["premium"]."','".$this->aa_Form["nombre"]."','".$this->aa_Form["direccion"]."','".$this->aa_Form["ciudad"]."','".$this->aa_Form["mapa"]."','".$this->aa_Form["telefono"]."','".$this->aa_Form["descripcion"]."'";
      $sql.=",'".$this->aa_Form["horario"]."','".$this->aa_Form["logo_subido"]."','".$this->aa_Form["correo"]."','".$this->aa_Form["facebook"]."','".$this->aa_Form["instagram"]."','".$this->aa_Form["linkedin"]."'$posicionStr)";
       
      $this->f_Con();
			$lb_Hecho=$this->f_Ejecutar($sql);		
      $this->f_Des();
      
      $result['mensaje']=($lb_Hecho)?"Directorio agregado exitosamente":"No hemos podido completar el registro, por favor inténtelo más tarde";
      $result['success'] = $lb_Hecho;

      return $result;
    }
  }
  public function borrar(){
    
    $sql = "DELETE FROM directorio WHERE id='".$this->aa_Form['id']."'";

    $this->f_Con();
    $lb_Hecho=$this->f_Ejecutar($sql);		
    $this->f_Des();
    $result['mensaje']=($lb_Hecho)?"Directorio borrado exitosamente":"No hemos podido completar el registro, por favor inténtelo más tarde";
    $result['success'] = $lb_Hecho;

    $result['sql'] = $sql;
    return $result;
  }
  public function enviarPos(){
    $result['mensaje'] = "";
    $this->f_Con();
    for ($i=0; $i < count($this->aa_Form['posiciones']); $i++) {
      $id = $this->aa_Form['posiciones'][$i]['id'];
      $po = $this->aa_Form['posiciones'][$i]['posicion'];
      $sql = "UPDATE directorio SET posicion='$po' WHERE id=$id";      
      $lb_Hecho=$this->f_Ejecutar($sql);
    }    	
    $this->f_Des();
    $result['success']=$lb_Hecho;
    $result['mensaje']=($lb_Hecho)?"Cambios guradados satisfactoriamente":"Error interno de servidor, por favor inténtelo más tarde";
    return $result;
  }
}
?>
