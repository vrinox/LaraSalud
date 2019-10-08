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

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LS Admin - Especialidades</title>

<?php include('php/admin-header.php'); ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Agregar Especialidades</h1>
          </div>

        <form method="POST">
            <div class="form-group">
                <label for="exampleFormControlInput1">Especialidad</label>
                <input type="input" class="form-control" id="exampleFormControlInput1" name="especialidad" placeholder="ej. Psicología">
            </div>
            <?php if($mensaje!=""){echo $mensaje; header('Location: ' . $_SERVER['PHP_SELF']);} ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="medicos" id="inlineCheckbox1" value="1">
                <label class="form-check-label" for="inlineCheckbox1">Médicos</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="medicos" id="inlineCheckbox2" value="0">
                <label class="form-check-label" for="inlineCheckbox2">Otras Especialidades</label>
            </div>
            <button type="submit" name="agregar" class="btn mb-2" style="background-color: rgb(255,255,153)">Agregar</button>
            <div class="form-group mt-2">
                <label for="exampleFormControlSelect1">Buscar especialidades existentes</label>
                <select name="busqueda" class="form-control" id="exampleFormControlSelect1">
                <option value="M">Médicos</option>
                <option value="O">Otras especialidades</option>
                </select>
            </div>
            <button type="submit" name="buscar" class="btn mb-2" style="background-color: rgb(255,255,153)">Buscar</button>
        </form>

          <!-- Content Row -->
          <div class="row">
            <!-- Formulario de especialidades-->
            <table id="busqueda" class="ml-5 mr-5 mt-2" width="40%">
        	<tr>
        		<th width="82%">Especialidades</th>
        		<th width="9%">Modificar</th>
        		<th width="9%">Eliminar</th>
        	</tr>
            <?php echo $lista; ?>
            </table>
          </div>

 <?php include('php/admin-footer.php'); ?>