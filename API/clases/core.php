<?php
class Core {
   
  private $ar_Con;
  
  protected function f_Con(){																				
		$ls_Serv="51.91.31.196";																				
		$ls_Usr="larasalu_admin";																						
		$ls_Pass="conejototuga.1";																					
		$ls_Bd="larasalu_directorio";																						
		$this->ar_Con=mysqli_connect($ls_Serv,$ls_Usr,$ls_Pass) or die ('coneccion fallida'.mysql_error());	
		mysql_select_db($ls_Bd,$this->ar_Con);																
		mysql_query("SET NAMES utf8");																		
	}																										
	protected function f_Ejecutar($ps_Sql){									
		$lb_Hecho=false;													
		mysql_query($ps_Sql,$this->ar_Con);									
		if(mysql_affected_rows($this->ar_Con)>0){							
			$lb_Hecho=true;													
		}																	
		return $lb_Hecho;													
	}																		
	protected function f_Filtro($ps_Sql){									
		$lr_Tabla=mysql_query($ps_Sql,$this->ar_Con);						
		return $lr_Tabla;													
	}																		
	protected function f_Arreglo($pr_Tabla){								
		$la_Tupla=mysql_fetch_array($pr_Tabla);								
		return $la_Tupla;													
	}																		
	protected function f_Cierra($pr_Tabla){									
		mysql_free_result($pr_Tabla);										
	}																		
	protected function f_Des(){												
		mysqli_close($this->ar_Con);											
	}																		
	protected function f_Begin(){											
		mysql_query("BEGIN",$this->ar_Con);									
	}																		
	protected function f_Commit(){											
		mysql_query("COMMIT",$this->ar_Con);								
	}																		
	protected function f_RollBack(){										
		mysql_query("ROLLBACK",$this->ar_Con);								
	}
	protected function f_Registro($prTb)									
    {																		  
 	    $li_Registros=mysql_num_rows($prTb);								
 	    return $li_Registros;												
    }			

  }									
    
}
?>