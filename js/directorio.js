arranque();
function arranque(){
  let templates = buscarTemplates();
  let search = capturarDirectorioFormURL();
  document.getElementById('nombreDirectorio').innerHTML = "DIRECTORIO / "+search['tipo'].toUpperCase();
  buscarEspecialidades(search['tipo']).then((directorios)=>{
    llenarDirectorios(directorios,templates);
  })
}
function llenarDirectorios(directorios,templates){
  let contenedor = document.querySelector('#listaPremiumContainer');
    directorios.forEach((each)=>{      
      let newTemplate;
      if(each.premium != 1){
        newTemplate = document.importNode(templates.clinica.firstElementChild, true);        
      }else{
        newTemplate = document.importNode(templates.medico.firstElementChild, true);
        newTemplate.innerHTML = newTemplate.innerHTML         
          .replace('$horario$',each.horario)
          .replace('$mapa$',each.mapa)
          .replace('$instagram$',each.instagram)
          .replace('$linkedin$',each.linkedin)
          .replace('$facebook$',each.facebook)
          .replace('$imagen$',each.logo)
          .replace('$correo$',each.correo)
      }
      newTemplate.innerHTML = newTemplate.innerHTML
      .replace('$nombre$',each.nombre)
      .replace('$descripcion$',each.descripcion)
      .replace('$direccion$',each.direccion)
      .replace('$telefonos$',each.telefono)
      contenedor.appendChild(newTemplate);
    })
}
function post(json){
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
function buscarEspecialidades(tipo){
  let json = {
    "modelo":"directorio",
    "operacion":"posicionar",
    "tipo":tipo
  }
  return post(json).then((data)=>{
    return Promise.resolve(data.directorios)
  })
}
function buscarPorCiudad(ciudad){
  let search = capturarDirectorioFormURL();
  let json = {
    "modelo":"directorio",
    "operacion":"listarPorCiudad",
    "tipo":search['tipo'],
    "ciudad":ciudad
  }
  return post(json)
}
function buscarTemplates(){
  let baseTemplateUrl = '../html-Templates/'
  let link = document.querySelector('link[href="'+baseTemplateUrl+'directorio.templates.html"]')
  var templates = {
    "medico"  : link.import.querySelector('#medico').content,
    "clinica" : link.import.querySelector('#clinica').content,
  };
  return templates;
}
function capturarDirectorioFormURL(){
  let search = window.location.search.substr(1).split('&');
  let objSearch = {};
  search.forEach((each)=>{
    let split = each.split('=');
    objSearch[split[0]] = split[1];
  })
  return objSearch;
}
//TODO:cargar el directorio nombre y asignarlo en el id nombreDirectorio