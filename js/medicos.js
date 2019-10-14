arranque();
function arranque(){
  let contenedores = document.querySelectorAll('.contenedorListaEspecialidades');
  let templates = cargarTemplatesExta();
  let templatePar = templates.querySelector('#especialidadMinWidget').content;
  let templateInpar = templates.querySelector('#especialidadMinWidgetInpar').content;
  buscarEspecialidades().then((data)=>{
    var mitad = Math.ceil(data.length/2);
    var numero = 0;
    data.forEach((each)=>{
      let template = ((numero%2)==0)?templatePar:templateInpar;
      let newEspecialidad = document.importNode(template.firstElementChild, true);
      numero++;
      let cont = (numero >= mitad)?0:1;
      contenedores[cont].appendChild(newEspecialidad);
      newEspecialidad.outerHTML = newEspecialidad.outerHTML.split('$especialidad$').join(each.especialidad);
    })
  })
}
function buscarEspecialidades(){
  return new Promise((resolve,reject)=>{
    console.log('[busqueda]empezo')
    $.post('https://www.larasalud.com/API/','{"modelo":"especialidad","operacion":"listar","busqueda":"M"}')
    .done((data)=>{
      console.log('[busqueda]termino')
      resolve(data.especialidades);
    }).fail((err)=>{
      console.log("[busqueda]fallo",err)
      reject();
    })
  })
}
function cargarTemplatesExta(){  
  let baseTemplateUrl = '../html-Templates/'
  let link = document.querySelector('link[href="'+baseTemplateUrl+'medicos.templates.html"]')
  var templates = link.import;
  return templates;
}
//TODO:cargar el directorio nombre y asignarlo en el id nombreDirectorio