verificarSesion();
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

$("#tipodirectorio")
  .change(function () {
    var str = "";
    $("#tipodirectorio option:selected").each(function () {
      str += $(this).text() + " ";
    });
    $("#direct").text(str);
  })
  .change();

function catmodif(id) {

  var idModal = 'edit' + id;
  var catm = $('#cat-modificada' + id).val().toUpperCase();
  if (catm.trim() == '') {
    alert('Por favor introduzca nueva categoria');
    $('#cat-modificada' + id).focus();
    return false;
  }
  else {
    $.ajax({
      url: 'https://larasalud.com/php/modificar.php',
      type: 'POST',
      dataType: 'html',
      data: "id=" + id + "&tabla=categorias&columna=categoria&fila=id&valor=" + catm,
      beforeSend: function () {
        $('#catmodificar').css({
          'display': 'block'
        });
      },
    })
      .done(function (data) {
        alert("Categoria modificada satisfactoriamente!");
        $('#' + idModal + ' .close').click();
      })
      .fail(function () {
        console.log('Error');
      })
      .always(function () {
        console.log("complete");
      });

  }
}

function espmodif(id) {
  var idModalesp = 'ed' + id;
  var espm = $('#esp-modificada' + id).val().toUpperCase();

  if (espm.trim() == '') {
    alert('Por favor introduzca nueva especialidad');
    $('#esp-modificada').focus();
    return false;
  }
  else {
    $.ajax({
      url: 'https://larasalud.com/php/modificar.php',
      type: 'POST',
      dataType: 'html',
      data: "id=" + id + "&tabla=especialidades&columna=especialidad&valor=" + espm + "&columna2=profesional&valor2=" + valor2 + "&fila=id",
      beforeSend: function () {
        $('#espmodificar').css({
          'display': 'block'
        });
      },
    })
      .done(function (data) {
        alert("Especialidad modificada satisfactoriamente!");
        $('#' + idModalesp + ' .close').click();
      })
      .fail(function () {
        console.log('Error');
      })
      .always(function () {
        console.log("complete" + valor2 + idModalesp + espm);
      });
  }
}
function cerrarSesion(){
  let json = {
    "modelo":"usuario",
    "operacion":"logout"
  }
  post(json).then((data)=>{
    if(data.success){
      window.sessionStorage.larasalud = "";
      location.href = 'adminLogin.html'
    }
  })
}
 
function verificarSesion(){
  let arreglo = location.pathname.split('/');  
  if((!window.sessionStorage.larasalud)&&(arreglo[arreglo.length -1 ].toLowerCase() != "adminlogin.html")){
    location.href = 'adminlogin.html';
  }
}

function post(json,headers = {}){
  return new Promise((resolve,reject)=>{
    $.ajax({
      url: 'https://www.larasalud.com/API/',
      type: 'post',
      data: JSON.stringify(json),
      crossDomain: true,
      headers: {"Accept": "application/json"},
      dataType: 'json',
      success: function (data) {
         resolve(data);
      }
    });
  });
}