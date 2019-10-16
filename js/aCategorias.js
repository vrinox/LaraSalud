arranque();
function arranque(){
  document.getElementById('buscar').onclick= ()=>{
    buscar();
  }
  document.getElementById('agregar').onclick= ()=>{
    agregar();
  }
  listar();
}
function buscar(){
  let json = {
    "modelo":"categoria",
    "operacion":"buscar",
    "categoria":document.getElementById('nombre').value
  }
  llenarLista(json);
}
function agregar(){
  let json = {
    "modelo":"categoria",
    "operacion":"agregar",
    "categoria":document.getElementById('nombre').value
  }
  postAd(json).then((data)=>{
    if(data.success){
      listar();
    }else{
      alert(data.mensaje);
    }
  })
}
function borrar(id){
  let json = {
    "modelo":"categoria",
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
    "modelo":"categoria",
    "operacion":"listar"
  }
  llenarLista(json);
}
function llenarLista(json){
  let templates = cargarTemplatesCategorias();
  let container = document.querySelector('#listaContainer');
  container.innerHTML = '';
  postAd(json).then((data)=>{
    if(data.success){      
      data.categorias.forEach((each)=>{
        let newEspecialidad = document.importNode(templates.elementoLista.firstElementChild, true);
          container.appendChild(newEspecialidad);
          newEspecialidad.outerHTML = newEspecialidad.outerHTML
          .split('$idactual$').join(each.id)
          .split('$catactual$').join(each.categoria);
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

function cargarTemplatesCategorias(){  
  let baseTemplateUrl = '../html-Templates/'
  let link = document.querySelector('link[href="'+baseTemplateUrl+'categorias.template.html"]')
  var templates = {
    elementoLista : link.import.querySelector('#elementoLista').content,
  }
  return templates;
}