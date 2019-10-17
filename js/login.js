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
function login(){
  let pass = document.getElementById('pass').value;
  let json = {
    "modelo":"usuario",
    "operacion":"login",
    "clave":pass
  }
  if(!pass){
    alert('Por favor llene la contraseña para continuar');
  }else{
    post(json).then((data)=>{
      if(data.success){
        window.sessionStorage.larasalud = "Administrador";
        location.href = 'admin.html';
      }else{
        alert(data.mensaje);
      }
    })
  }
}