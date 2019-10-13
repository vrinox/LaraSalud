<?php
class Core {
   
  private $ar_Con;
  
  protected function f_Con(){																				
		$ls_Serv="51.91.31.196";																				
		$ls_Usr="larasalu_admin";																						
		$ls_Pass="conejototuga.1";																					
		$ls_Bd="larasalu_directorio";																						
		$this->ar_Con=mysqli_connect($ls_Serv,$ls_Usr,$ls_Pass) or die ('coneccion fallida'.mysqli_error());	
		mysqli_select_db($this->ar_Con,$ls_Bd);																
		mysqli_query($this->ar_Con,"SET NAMES utf8");																		
	}																										
	protected function f_Ejecutar($ps_Sql){									
		$lb_Hecho=false;													
		mysqli_query($this->ar_Con,$ps_Sql);									
		if(mysqli_affected_rows($this->ar_Con)>0){							
			$lb_Hecho=true;													
		}																	
		return $lb_Hecho;													
	}																		
	protected function f_Filtro($ps_Sql){									
		$lr_Tabla=mysqli_query($this->ar_Con,$ps_Sql);						
		return $lr_Tabla;													
	}																		
	protected function f_Arreglo($pr_Tabla){								
		$la_Tupla=mysqli_fetch_array($pr_Tabla);								
		return $la_Tupla;													
	}																		
	protected function f_Cierra($pr_Tabla){									
		mysqli_free_result($pr_Tabla);										
	}																		
	protected function f_Des(){												
		mysqli_close($this->ar_Con);											
	}																		
	protected function f_Begin(){											
		mysqli_query($this->ar_Con,"BEGIN");									
	}																		
	protected function f_Commit(){											
		mysqli_query($this->ar_Con,"COMMIT");								
	}																		
	protected function f_RollBack(){										
		mysqli_query($this->ar_Con,"ROLLBACK");								
	}
	protected function f_Registro($prTb){
		$li_Registros=mysqli_num_rows($prTb);
		return $li_Registros;
	}
}
?>