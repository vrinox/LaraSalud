arranque();
function arranque(){
  document.getElementById('buscar').onclick= ()=>{
    listar();
  }
  document.getElementById('agregar').onclick= ()=>{
    agregar();
  }
  listar();
}
function buscar(){
  let json = {
    "modelo":"especialidad",
    "operacion":"buscar",
    "especialidad":document.getElementById('nombre').value
  }
  llenarLista(json);
}
function agregar(){
  let json = {
    "modelo":"especialidad",
    "operacion":"agregar",
    "nombre":document.getElementById('nombre').value,
    "profesional": $("input[type='radio'][name='profesional']:checked").val(),
  }
  if(json.nombre && json.profesional){    
    postAd(json).then((data)=>{
      if(data.success){
        listar();
      }else{
        alert(data.mensaje);
      }
    })
  }else{
    alert('llene todos los campos para continuar');
  }
}
function borrar(id){
  let json = {
    "modelo":"especialidad",
    "operacion":"borrar",
    "id":id
  }
  postAd(json).then((data)=>{
    if(data.success){
      listar();
    }else{
      alert(data.mensaje);
    }
  })
}
function listar(){
  let json = {
    "modelo":"especialidad",
    "operacion":"listar",
    "busqueda":document.getElementById('busqueda').value
  }
  llenarLista(json);
}
function llenarLista(json){
  let templates = cargarTemplatesEspecialidades();
  let container = document.querySelector('#listaContainer');
  container.innerHTML = '';
  postAd(json).then((data)=>{
    if(data.success){      
      data.especialidades.forEach((each)=>{
        let newEspecialidad = document.importNode(templates.elementoLista.firstElementChild, true);
          container.appendChild(newEspecialidad);
          newEspecialidad.outerHTML = newEspecialidad.outerHTML
          .split('$id$').join(each.id)
          .split('$nombre$').join(each.especialidad);
      })
    }else{
      if(data.mensaje){        
        alert(data.mensaje)
      }
    }
  })
}
function postAd(json,headers = {}){
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

function cargarTemplatesEspecialidades(){  
  let baseTemplateUrl = '../html-Templates/'
  let link = document.querySelector('link[href="'+baseTemplateUrl+'especialidades.templates.html"]')
  var templates = {
    elementoLista : link.import.querySelector('#elementoLista').content,
  }
  return templates;
}

function espmodif(id) {

  var idModal = 'ed' + id;
  var espm = $('#esp-modificada' + id).val().toUpperCase();
  if (espm.trim() == '') {
    alert('Por favor introduzca nueva especialidad');
    $('#esp-modificada' + id).focus();
    return false;
  }
  else {
    let json = {
      "modelo":"especialidad",
      "operacion":"modificar",
      "id":id,
      "nombre":espm
    }
    $('#espmodificar').css({
      'display': 'block'
    });
    postAd(json)
      .then(()=>{
        alert("especialidad modificada satisfactoriamente!");
        $('#' + idModal + ' .close').click();
        listar();
      })
  }
}