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
        $resultado['directorio'] = $this->get();
        break;
      case 'agregar':
        $resultado['success'] = $this->agregar();
        break;
      case 'modificar':
        $resultado['success'] = $this->modificar();
        break;
      case 'posicionar':
        $resultado['directorios'] = $this->buscarPremium();
        break;  
      case 'listarPorCiudad':
        $resultado['directorios'] = $this->listarPorCiudad();
        break;
      case 'enviarPos':
      //TODO: por hacer
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

  public function buscarPremium(){
    $laMatriz=Array();
    $lsSql="SELECT * FROM directorio WHERE premium='1' AND tipo='".$this->aa_Form['tipo']."'";
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
    $result = array(
      'success' => $success,
      'mensaje' => $mensaje,
      'logo'    => $logo_subido
    );
    return $result;
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
			$lb_Hecho=$this->f_Ejecutar($sql);		
      $this->f_Des();
      
      if ($lb_Hecho)
      {
        $result['mensaje']="No hemos podido modificar el registro, por favor inténtelo más tarde";
      }
      else
      {
        $result['mensaje'].="Directorio modificado exitosamente";
      }
      return $result;
    }
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
  
      $dir_subida = "imagenes/logos/".$tipoD."/";
      $logo_subido = $dir_subida.basename($_FILES['logoD']['name']);
      //esta es una validacion en el caso que el usuario no suba imagen se coloca un icono que ya esta en el servidor
      $result = $this->captarLogo('insertar');
      if($premium=="1"){
        $sql = "INSERT INTO directorio";
        $sql.= "(tipo,premium,nombre,direccion,ciudad,mapa,telefono,descripcion,horario,logo,correo,facebook,instagram,linkedin,posicion) ";
        $sql.= "VALUES('".$this->aa_Form["tipo"]."','".$this->aa_Form["premium"]."','".$this->aa_Form["nombre"]."','".$this->aa_Form["direccion"]."','".$this->aa_Form["ciudad"]."','".$this->aa_Form["mapa"]."','".$this->aa_Form["telefono"]."','".$this->aa_Form["descripcion"]."'";
        $sql.=",'".$this->aa_Form["horario"]."','".$this->aa_Form["logo_subido"]."','".$this->aa_Form["correo"]."','".$this->aa_Form["facebook"]."','".$this->aa_Form["instagram"]."','".$this->aa_Form["linkedin"]."','".$this->aa_Form["posicion"]."')";
      } 
      else {
        $sql = "INSERT INTO directorio";
        $sql .= "(tipo,premium,nombre,direccion,ciudad,mapa,telefono,descripcion,horario,logo,correo,facebook,instagram,linkedin) ";
        $sql .= "VALUES('".$this->aa_Form["tipo"]."','".$this->aa_Form["premium"]."','".$this->aa_Form["nombre"]."','".$this->aa_Form["direccion"]."','".$this->aa_Form["ciudad"]."','".$this->aa_Form["mapa"]."','".$telefono."','".$this->aa_Form["descripcion"]."',";
        $sql .= "'".$this->aa_Form["horario"]."','".$this->aa_Form["logo_subido"]."','".$this->aa_Form["correo"]."','".$this->aa_Form["facebook"]."','".$this->aa_Form["instagram"]."','".$this->aa_Form["linkedin"]."')";
      }
      
      $this->f_Con();
			$lb_Hecho=$this->f_Ejecutar($sql);		
      $this->f_Des();
      
      $result['mensaje']=(!$lb_Hecho)?"Directorio agregado exitosamente":"No hemos podido completar el registro, por favor inténtelo más tarde";
      
      return $result;
    }
  }
}
?>
