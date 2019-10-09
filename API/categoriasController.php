<?php
$mensaje="";
$categoria="";
include('php/dbmanage.php');
include('php/usuario.php');
header("Content-Type: text/html;charset=utf-8");
if(array_key_exists("agregar",$_POST))
{        
  if(!$_POST['categoria'])
  {
    $mensaje = "<div class=\"alert alert-danger\" role=\"alert\">Coloque una categoría</div>";
  }       
  else
  {
    $categoria = strtoupper($_POST['categoria']); 
    $query= "SELECT * FROM categorias WHERE categoria='".$categoria."' LIMIT 1";
    $resultado= db_query($query);
    if(mysqli_num_rows($resultado)>0)
    {
      $mensaje="<div class=\"alert alert-danger\" role=\"alert\">Ya existe la categoria</div>";
    }
    else
    {
      $query = "INSERT INTO categorias(categoria) VALUES('".$categoria."')";
      if (!db_query($query))
      {
        $mensaje="<div class=\"alert alert-danger\" role=\"alert\">No hemos podido completar el registro, por favor inténtelo más tarde</div>";
      }
      else
      {
        $mensaje="<div class=\"alert alert-success\" role=\"alert\">Categoria agregada exitosamente</div>";
      }
    }
  }
}
else if(array_key_exists("buscar",$_POST))
{    
  $query= "SELECT * FROM categorias";
  $resultado= db_query($query);
  $i=0;
  $o=0;
  while($fila=mysqli_fetch_array($resultado))
  {
      $id[]=$fila[0];
      $cat[]= $fila[1];
      $idactual=(string)$id[$o++];
      $catactual=$cat[$i++];
      if(array_key_exists("modificar",$_POST)){$catmodificada = strtoupper($_POST['catmod']);}
        $lista= $lista."<tr><td>".$catactual."</td>
        <td class=\"text-center\"><button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#edit".$idactual."\"><i class=\"fa fa-xs fa-edit\" aria-hidden=\"true\"></i>
          </button> 
          <div class=\"modal fade\" id=\"edit".$idactual."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"editLabel\" aria-hidden=\"true\">
            <div class=\"modal-dialog\" role=\"document\">
              <div class=\"modal-content\">
                <div class=\"modal-header\">
                  <h5 class=\"modal-title\" id=\"editLabel\">Modificar la categoría: $catactual</h5>
                  <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                  </button>
                </div>
                <div class=\"modal-body\">
                  <form>
                    <div class=\"form-group\">
                      <label for=\"cat-modificada\" class=\"col-form-label\">Nueva Categoría:</label>
                      <input type=\"text\" class=\"form-control\" id=\"cat-modificada".$idactual."\" name=\"catmod\">
                    </div>
                      </form>
                    </div>
                    <div class=\"modal-footer\">
                      <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancelar</button>
                      <button type=\"button\" id=\"catmodificar\" class=\"btn btn-info\"  onclick=\"catmodif(".$idactual.")\" >Modificar</button>
                    </div>
                  </div>
                </div>
              </div>
              </td>
              <td class=\"text-center\"><button type=\"button\" class=\"btn btn-info\" data-toggle=\"modal\" data-target=\"#modal".$idactual."\"><i class=\"fa fa-xs fa-trash\" aria-hidden=\"true\"></i>
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
                  Esta seguro(a) que desea eliminar la especialidad: ".$catactual."
                </div>
                <div class=\"modal-footer\">
                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancelar</button>
                <a class=\"btn btn-info\" href=\"php/borrar.php?id=".$idactual."&tabla=categorias&fila=id\">Continuar</a>
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