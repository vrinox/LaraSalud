<?php
    include('php/dbmanage.php');
    header("Content-Type: text/html;charset=utf-8");
    $query= "SELECT * FROM especialidades WHERE profesional='M';";
    $resultado= db_query($query);
    $numeroEsp = mysqli_num_rows($resultado);
    $mitad = ceil($numeroEsp/2);
    $cont = 1;
    while($fila=mysqli_fetch_array($resultado))
    {
        if($cont <= $mitad){
            if($cont==1 || $cont%2!=0)
            {
              $listaEsp .= "<a href=\"https://larasalud.com/larasalud-OEmedicos.php?especialidad=".$fila['especialidad']."\" style=\"text-decoration:none\"><span class=\"pr-1 w-25 h-25 float-left circulo\"></span><div class=\"especialidades\" style=\"background-color: #e4e0e0;\"><h4>".$fila['especialidad']."</h4></div></a>";
            }    
            else
            {
                $listaEsp .= "<a href=\"https://larasalud.com/larasalud-OEmedicos.php?especialidad=".$fila['especialidad']."\" style=\"text-decoration:none\"><span class=\"pr-1 w-25 h-25 float-left circulo\"></span><div class=\"especialidades\" style=\"background-color:  #c0bebe;\"><h4>".$fila['especialidad']."</h4></div></a>";
            }
        }
        else
        {
            if($cont==$mitad+1)
            {$listaEsp .= "</div>
                            <div class=\"Oespecialidades col-sm-475 h-80\">";}
            if($cont%2!=0)
            {
              $listaEsp .= "<a href=\"https://larasalud.com/larasalud-OEmedicos.php?especialidad=".$fila['especialidad']."\" style=\"text-decoration:none\"><span class=\"pr-1 w-25 h-25 float-left circulo\"></span><div class=\"especialidades\" style=\"background-color: #e4e0e0;\"><h4>".$fila['especialidad']."</h4></div></a>";
            }    
            else
            {
                $listaEsp .= "<a href=\"https://larasalud.com/larasalud-OEmedicos.php?especialidad=".$fila['especialidad']."\" style=\"text-decoration:none\"><span class=\"pr-1 w-25 h-25 float-left circulo\"></span><div class=\"especialidades\" style=\"background-color:  #c0bebe;\"><h4>".$fila['especialidad']."</h4></div></a>";
            }
        }
        $cont++;
    }
    db_close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
<title>LS - Especialidades</title>
<?php include 'php/header.php'; ?>
  <section id="Directorio">
    <!--Carrusel con los destacados de la semana-->
    <div class="container" style="margin-right:20%; margin-left:0.2%;">
    <h1 class="ml-4 mt-4 mb-0" style="color:#969494;">DIRECTORIO / ESPECIALIDADES MEDICAS</h1>
    
    <div class="row pt-4 ml-2">
      <div class="col-sm-475 pr-1 h-80">
       <?php echo $listaEsp; ?>
      </div> 
      <div class="col-sm-25 pl-1 pr-1">
        <div class="mb-2"><img class="img-fluid publicidad" src="https://via.placeholder.com/230x588"></div>
        <div class="mb-2"><img class="img-fluid publicidad" src="https://via.placeholder.com/230x550"></div>
      </div>
    </div>
  </section>
  <section class="ml-3 mr-3 pl-0" id="Anuncios">
    <div class="row mt-0 ml-4 mr-5">
         <!--Carrusel con los destacados de la semana-->
        <div id="carouselIndicatorsdirec" class="carousel slide w-100 pl-2 pr-0 mr-0 pt-2 pb-2" data-ride="carousel" style="background-color:#c7ede3;">
          <ol class="carousel-indicators">
            <li data-target="#carouselIndicatorsdirec" data-slide-to="0" class="active"></li>
            <li data-target="#carouselIndicatorsdirec" data-slide-to="1"></li>
            <li data-target="#carouselIndicatorsdirec" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active w-20">
              <img src="imagenes/thumbnails/x200/hemosvuelto.jpg" class="d-block w-100 ml-3 mr-3" alt="antivacuna">
              <img src="imagenes/thumbnails/x200/Patatus.jpg" class="d-block w-100 mr-3" alt="menopausia">
              <img src="imagenes/thumbnails/x200/sufijos terminologia.jpg" class="d-block w-100 mr-3" alt="menopausia">
              <img src="imagenes/thumbnails/x200/me mordio un perro.jpg" class="d-block w-100 mr-3" alt="menopausia">
              <img src="imagenes/thumbnails/x200/sufijos terminologia.jpg" class="d-block w-100 mr-3" alt="menopausia">
            
            </div>
            <div class="carousel-item w-20">
                <img src="imagenes/thumbnails/x200/hemosvuelto.jpg" class="d-block w-100 ml-3 mr-3" alt="antivacuna">
              <img src="imagenes/thumbnails/x200/Patatus.jpg" class="d-block w-100 mr-3" alt="menopausia">
              <img src="imagenes/thumbnails/x200/sufijos terminologia.jpg" class="d-block w-100 mr-3" alt="menopausia">
              <img src="imagenes/thumbnails/x200/me mordio un perro.jpg" class="d-block w-100 mr-3" alt="menopausia">
              <img src="imagenes/thumbnails/x200/sufijos terminologia.jpg" class="d-block w-100 mr-3" alt="menopausia">
         
            </div>
            <div class="carousel-item w-20">
               <img src="imagenes/thumbnails/x200/hemosvuelto.jpg" class="d-block w-100 ml-3 mr-3" alt="antivacuna">
              <img src="imagenes/thumbnails/x200/Patatus.jpg" class="d-block w-100 mr-3" alt="menopausia">
              <img src="imagenes/thumbnails/x200/sufijos terminologia.jpg" class="d-block w-100 mr-3" alt="menopausia">
              <img src="imagenes/thumbnails/x200/me mordio un perro.jpg" class="d-block w-100 mr-3" alt="menopausia">
              <img src="imagenes/thumbnails/x200/sufijos terminologia.jpg" class="d-block w-100 mr-3" alt="menopausia">
          
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselIndicatorsdirec" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
          </a>
          <a class="carousel-control-next" href="#carouselIndicatorsdirec" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
          </a>
        </div>   

         <div class="w-100"></div>
          <div class="col-md-12 pt-3 mt-1 pb-3 text-center">
              <img class="img-fluid h-100 w-70 position-relative" src="https://via.placeholder.com/830x188">
          </div>
        </div>
  </div>  
  </div>
  </section>

  <?php
    include 'php/footer.php';
?>
<!-- JQuery script -->
<script src="js/jQuery.js"></script>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script type="js/myJQuery.js"></script>
</body>
</html>