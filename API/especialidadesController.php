<?php
    $mensaje="";
    $especialidad="";
    include('php/dbmanage.php');
    include('php/usuario.php');
    header("Content-Type: text/html;charset=utf-8");
    if(array_key_exists("agregar",$_POST))
    {
        
        if(!$_POST['especialidad'])
        {
          $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">Coloque una especialidad</div>";
        }       
        else
        {
            $especialidad = strtoupper($_POST['especialidad']); 
            $query= "SELECT * FROM especialidades WHERE especialidad='".$especialidad."' LIMIT 1";
            $resultado= db_query($query);
            if(mysqli_num_rows($resultado)>0)
            {
              $mensaje="<div class=\"alert alert-danger\" role=\"alert\">Ya existe la especialidad</div>";
            }
            else if($_POST['medicos']=="1" OR $_POST['medicos']=="0")
            {
              if($_POST['medicos']=="1") $profesional= "M";
              else $profesional= "O";              
              $query = "INSERT INTO especialidades(especialidad,profesional) VALUES('".$especialidad."','".$profesional."')";
              if (!db_query($query))
              {
                  $mensaje="<div class=\"alert alert-danger\" role=\"alert\">No hemos podido completar el registro, por favor inténtelo más tarde</div>";
              }
              else
              {
                  $mensaje="<div class=\"alert alert-success\" role=\"alert\">Especialidad agregada exitosamente</div>";
                  
              }
            }
            else
            {
              $mensaje="<div class=\"alert alert-danger\" role=\"alert\">Seleccione algún profesional</div>";
            }
        }
    }
    else if(array_key_exists("buscar",$_POST))
    {
        $query= "SELECT * FROM especialidades WHERE profesional='".$_POST['busqueda']."'";
        $resultado= db_query($query);
        $i=0;
        $o=0;
        while($fila=mysqli_fetch_array($resultado))
        {
            $id[]=$fila[0];
            $esp[]= $fila[1];
            $idactual=(string)$id[$o++];
            $espactual=$esp[$i++];
            if(array_key_exists("modificar",$_POST)) $espmodificada = strtoupper($_POST['espmod']); 
        	$lista= $lista."<tr><td>".$espactual."</td>
        	<td class=\"text-center\"><button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#ed".$idactual."\"><i class=\"fa fa-xs fa-edit\" aria-hidden=\"true\"></i>
            </button> 
            <div class=\"modal fade\" id=\"ed".$idactual."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"editLabel\" aria-hidden=\"true\">
              <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                  <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"espLabel\">Modificar la especialidad: $espactual</h5>
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                      <span aria-hidden=\"true\">&times;</span>
                    </button>
                  </div>
                  <div class=\"modal-body\">
                    <form>
                      <div class=\"form-group\">
                        <label for=\"esp-modificada\" class=\"col-form-label\">Nueva Especialidad:".$idactual."</label>
                        <input type=\"text\" class=\"form-control\" id=\"esp-modificada".$idactual."\" name=\"espmod\">
                      </div>
                       </form>
                      </div>
                      <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancelar</button>
                        <button type=\"button\" id=\"espmodificar\" class=\"btn btn-info\" onclick=\"espmodif(".$idactual.")\">Modificar</button>
                      </div>
                    </div>
                  </div>
                </div>
            </td>
    		<td><button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#modal".$idactual."\"><i class=\"fa fa-xs fa-trash\" aria-hidden=\"true\"></i>
            </button> 
            <div class=\"modal fade\" id=\"modal".$idactual."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
               <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"exampleModalLabel\">Advertencia!</h5>
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                </div>
                <div class=\"modal-body\">
                 Esta seguro(a) que desea eliminar la especialidad: ".$espactual."
                </div>
                <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cerrar</button>
                <a class=\"btn btn-info\" href=\"php/borrar.php?id=".$idactual."&tabla=especialidades&fila=id\">Continuar</a>
              </div>
            </div>
          </div>
        </div>
        </td>
       </tr>";
	    } 
    }
   db_close();
?>