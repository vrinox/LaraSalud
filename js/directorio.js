arranque();
function arranque(){
  let templates = buscarTemplates();
  let search = capturarDirectorioFormURL();
  document.getElementById('nombreDirectorio').innerHTML = "DIRECTORIO / "+search['tipo'].toUpperCase();
  buscarEspecialidades(search['tipo']).then((directorios)=>{
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
  })
}
function buscarEspecialidades(tipo){
  return new Promise((resolve,reject)=>{
    console.log('[busqueda]empezo')
    let json = {
      "modelo":"directorio",
      "operacion":"posicionar",
      "tipo":tipo
    }
    $.post('https://www.larasalud.com/API/',JSON.stringify(json))
    .done((data)=>{
      console.log('[busqueda]termino')
      resolve(data.directorios);
    }).fail((err)=>{
      console.log("[busqueda]fallo",err)
      reject();
    })
  })
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