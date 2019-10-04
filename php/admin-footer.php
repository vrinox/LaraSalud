     <!-- Footer -->
      <footer class="sticky-footer" style="background-color: #F8F9FC">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Edmara Guerrero 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

 
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cerrar Sesión</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">¿Estas seguro(a) que deseas salir de la sesión?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="adminlogin.php?Logout=1">Salir</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  
  <!--Jquery interfaz-->
  <script src="js/jqueryUI/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="js/jquery.min.js"></script>
<!-- jQuery library -->

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script "text/javascript">
        tinymce.init({
          selector: 'textarea#basic-example',
          height: 500,
          menubar: false,
          plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
          ],
          toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tiny.cloud/css/codepen.min.css'
          ]
        });
         $(function() {
            $('#sortable-8').sortable({
               update: function(event, ui) {
                  var posicionOrden = $(this).sortable('toArray').toString();
                  $("#sortable-9").text (posicionOrden);
                  document.getElementById("posicionesD").value = posicionOrden;
               }
            });
         });
 
  /*  function enviarPosD(){
          $.ajax({
        	        url: 'https://larasalud.com/php/posDirectorio.php',
        	        type: 'POST',
        	        dataType: 'html',
        	        data: "posicionOrden="+posicionOrden+"&directorio="+<?php echo $tipoPos?>+"
                   });
            }*/
        
 
        $( "#tipodirectorio" )
          .change(function () {
            var str = "";
            $( "#tipodirectorio option:selected" ).each(function() {
              str += $( this ).text() + " ";
            });
            $( "#direct" ).text( str );
          })
          .change();
     
    function catmodif(id){
      
       var idModal = 'edit'+id;
       var catm = $('#cat-modificada'+id).val().toUpperCase();
       if(catm.trim() == '' ){
        alert('Por favor introduzca nueva categoria');
        $('#cat-modificada'+id).focus();
        return false;
       }
       else
       {
           $.ajax({
	        url: 'https://larasalud.com/php/modificar.php',
	        type: 'POST',
	        dataType: 'html',
	        data: "id="+id+"&tabla=categorias&columna=categoria&fila=id&valor="+catm,
	        beforeSend: function(){
                $('#catmodificar').css({
                'display': 'block'
            }); 
	        },
           })
	       .done(function(data) {
                alert("Categoria modificada satisfactoriamente!");
                $('#'+idModal+' .close').click();
            })
            .fail(function() {
                console.log('Error');   })
            .always(function() {
                console.log("complete");
        });
          
       }
  }

  function espmodif(id){
       var idModalesp = 'ed'+id;
       var espm = $('#esp-modificada'+id).val().toUpperCase();
         
       if(espm.trim() == '' ){
        alert('Por favor introduzca nueva especialidad');
        $('#esp-modificada').focus();
        return false;
       }
       else
       {
           $.ajax({
	        url: 'https://larasalud.com/php/modificar.php',
	        type: 'POST',
	        dataType: 'html',
	        data: "id="+id+"&tabla=especialidades&columna=especialidad&valor="+espm+"&columna2=profesional&valor2="+valor2+"&fila=id",
	        beforeSend: function(){
                $('#espmodificar').css({
                'display': 'block'
            }); 
	        },
           })
	       .done(function(data) {
                alert("Especialidad modificada satisfactoriamente!");
                $('#'+idModalesp+' .close').click();
            })
            .fail(function() {
                console.log('Error');   })
            .always(function() {
                console.log("complete"+valor2+idModalesp+espm);
        });
          
       }
  }
  </script>
  <!-- Page level plugins 
  <script src="vendor/chart.js/Chart.min.js"></script>
-->
  <!-- Page level custom scripts
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
 -->

</body>

</html>