<?php
include_once("/home2/larasalu/public_html/API/clases/core.php");
class  cls_Usuario extends Core{
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
  
  public function logIn ()						
		{				
      $lb_Enc=false;	    
      $lsSql="SELECT * FROM usuarios WHERE usuario='Administrador'";			
      $this->f_Con();	
      $lr_Tabla=$this->f_Filtro($lsSql);				
      if($la_Tupla=$this->f_Arreglo($lr_Tabla)){
        $lb_Enc=true;      
        if(isset($la_Tupla))
        {
          $clave=(md5($this->aa_Form['clave']));
          if($clave==$la_Tupla['clave'])
          {
              $_SESSION['usuario'] = "Administrador";
              if($this->aa_Form['permanecerIniciada']=='1')
              {                    
                setcookie("usuario",$_SESSION['usuario'], time()+60*60*24*365);
              }
              $resultado['success'] = true;
          }
          else if($this->aa_Form['clave']!="" && $this->aa_Form['clave']!="Escribe la contraseña")
          {
              $resultado['success']= false;
              $resultado['success']= "Contraseña Incorrecta!";
          }
        }				
      }      
      $this->f_Cierra($lr_Tabla);						
      $this->f_Des();	
  }
	
	public function gestionar(){
    $resultado = array();
    switch($this->aa_Form['operacion']){
      case 'logIn': 
        $resultado['success'] = $this->logIn();
        break;
      case 'logOut': 
        $resultado['success'] = $this->logIn();
        break;
      default:
				$resultado['success']=false;
				$resultado['mensaje']='operacion no seleccionada';
				break;
    }
    return $resultado;
  }
  public function logOut(){
     //viene de la pagina sesion iniciada
     session_unset();
     // Borra todas las variables de sesión 
      $_SESSION = array(); 
      // Borra la cookie que almacena la sesión 
      if(isset($_COOKIE[session_name()])) { 
          setcookie('usuario', '', 1); 
      } 
      // Finalmente, destruye la sesión 
      session_destroy(); 
      return true;
  }
}
?>
