
<!DOCTYPE html>
<html lang="es">

<head>
<title>LS - Nosotros</title>
<?php
  $error="";
  $mensajeExito="";
  include("php/header.php"); 
  if($_POST)
    {
      $emailA = "edxilcoil@gmail.com";            
      $nombre = $_POST['nombre'];
      $contenido = $_POST['contenido']."\r\n Telefono de contacto: ".$_POST['telefono'];
      $cabeceras = "From: ".$_POST['email'];
      if (mail($emailA, $nombre, $contenido, $cabeceras)) 
      {
        $mensajeExito = '<div class="alert alert-success" role="alert">Mensaje enviado con éxito, nos pondremos en contacto pronto!</div>';
      } 
      else {
        $error = '<div class="alert alert-danger" role="alert"><p><strong>El mensaje no pudo ser enviado, por favor inténtalo más tarde</div>';
      }
    }

?>
  <section id="Nosotros">
    <div class="row pt-4 ml-4 mr-3">
      <div class="col-sm-9 pr-1 h-80">
        <h1 class="ml-4 mt-4 mb-0" style="color:rgb(11,166,156);">MISIÓN</h1>
        <h4 class="ml-4 mr-5 text-justify">Proveer a la población larense y de centro occidente
          información de interés, y contacto con aquellos servicios
          necesarios para su salud. a través de medios digitales
          y de comunicación actuales. Aportando así bienestar y
          comodidad a sus clientes y seguidores, respetando
          siempre sus intereses y/o necesidades principales.</h4>
        <h1 class="ml-4 mt-4 mb-0" style="color:rgb(11,166,156);">VISIÓN</h1>
        <h4 class="ml-4 mr-5 text-justify">Ser la principal guía medica e informativa
          de centro occidente</h4>
          <div class="container">
              <h1 class="ml-4 mt-5 mb-5 text-center" style="color:rgb(11,166,156);">TAMBIÉN NOS ESPECIALIZAMOS EN:</h1>
              <div class="row  pl-3 pr-3">
                <div class="col-sm text-center p-0">
                  <img class="img-fluid publicidad" style="width: 100px;" src="imagenes/iconos/servicios-adicionales/comunity manager.jpg">
                  <h4 class="m-2 mt-3">MANEJO DE REDES <br> SOCIALES</h4>
                </div>
                <div class="col-sm text-center p-0">
                  <img class="img-fluid publicidad" style="width: 100px;" src="imagenes/iconos/servicios-adicionales/grafico.jpg">
                  <h4 class="m-2 mt-3">DISEÑO GRÁFICO</h4>  
                </div>
                <div class="col-sm text-center p-0">
                  <img class="img-fluid publicidad" style="width: 100px;" src="imagenes/iconos/servicios-adicionales/fotografia.jpg">
                  <h4 class="m-2 mt-3">FOTOGRAFÍA <br> PROFESIONAL</h4>
                </div>
              </div>
              <div class="row mt-2 pl-3 pr-3">
                  <div class="col-sm text-center p-0">
                      <img class="img-fluid publicidad" style="width: 100px;" src="imagenes/iconos/servicios-adicionales/web.jpg">
                      <h4 class="m-2 mt-3">PÁGINAS WEB</h4>
                    </div>
                  <div class="col-sm text-center p-0">
                      <img class="img-fluid  publicidad" style="width: 100px;" src="imagenes/iconos/servicios-adicionales/aplicaciones.jpg">
                      <h4 class="m-2 mt-3">APLICACIONES</h4>  
                    </div>
                  <div class="col-sm text-center p-0">
                      <img class="img-fluid publicidad" style="width: 100px;" src="imagenes/iconos/servicios-adicionales/redaccion de contenido.jpg">
                      <h4 class="m-2 mt-3">REDACCIÓN CONTENIDO</h4>
                    </div>
                </div>
            </div>
            <h1 class="ml-4 mt-5 mb-5 text-center" style="color:rgb(11,166,156);">¿QUIERES CONTACTARNOS?</h1>
            <div class="container w-50 pb-2 pt-1 mb-4" style="background-color: #c7ede3;">
            <form method="POST" class="was-validated mt-2">
                <fieldset class="form-group">
                  <label for="nombre">NOMBRE</label>
                  <input type="text" class="form-control is-invalid" id="nombre" name="nombre" placeholder="nombre y apellido" value="" required>
                </fieldset>
                <fieldset class="form-group">
                  <label for="email">EMAIL</label>
                  <input type="email" class="form-control is-invalid" id="email" aria-describedby="emailHelp" placeholder="nombre@correo.com" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="" required>
                  <small id="emailHelp" class="form-text text-muted">Colocar el correo electrico correctamente para responder a tu contacto.</small>
                </fieldset>
                <fieldset class="form-group">
                  <label for="telefono">TELEFONO</label>
                  <input type="tel" class="form-control is-invalid" id="telefono" name="telefono" placeholder="nnnn-nnnnnnnn" pattern="[0-9]{4}-[0-9]{7}" value="" required>
                </fieldset>
                <fieldset class="form-group">
                    <label for="contenido">MENSAJE</label>
                    <textarea class="form-control is-invalid" id="contenido" placeholder="Campo de mensaje obligatorio" required name="contenido" rows="3"></textarea> 
                  </fieldset>
                  <button type="submit" id="submit" class="btn btn-info">Enviar</button>
                </form>
                <div id="error"><? echo $error.$mensajeExito; ?></div>
              </div>
      </div> 
      <div class="col-sm-3 pr-4 text-center">
        <img class="img-fluid publicidad" src="http://via.placeholder.com/230x588">
        <img class="img-fluid publicidad mt-4 mb-2" src="http://via.placeholder.com/230x550">
        <div class="embed-container mt-3 mr-4">
        <iframe src="https://calendar.google.com/calendar/embed?height=200&amp;wkst=1&amp;bgcolor=%23ffffff&amp;ctz=America%2FCaracas&amp;src=NHNtYTF1MTU2c2x0ajliMjBkMmIzdXU2dWtAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;color=%23009688&amp;showNav=1&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0" style="border-width:0" width="400" height="200" frameborder="0" scrolling="no"></iframe>
        </div>
      </div>
    </div>
  </section>
  <?php include("php/footer.php"); ?>
<!-- JQuery script -->
<script src="js/jQuery.js"></script>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script type="js/myJQuery.js"></script>
</body>
</html>
