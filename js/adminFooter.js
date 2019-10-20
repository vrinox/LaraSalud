verificarSesion();
tinymce.init({
  selector: 'textarea#contenido',
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

// side bar
$(document).ready(function () {
  $('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
  });
});