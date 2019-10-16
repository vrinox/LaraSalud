"use stric";
class Especialidades {

  crearEspecialidades(contenedores,templates,data){
    var mitad = Math.ceil(data.length/2);
      var numero = 0;
      data.forEach((each)=>{
        let template = ((numero%2)==0)?templates.par:templates.inpar;
        let newEspecialidad = document.importNode(template.firstElementChild, true);
        numero++;
        let cont = (numero >= mitad)?0:1;
        contenedores[cont].appendChild(newEspecialidad);
        newEspecialidad.outerHTML = newEspecialidad.outerHTML.split('$especialidad$').join(each.especialidad);
      })
  }
  buscarEspecialidades(tipo){
    let json = {"modelo":"especialidad","operacion":"listar","busqueda":tipo}
    return this.post(json).then((data)=>{
      return Promise.resolve(data.especialidades)
    });
  }

  post(json,headers = {}){
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

  cargarTemplatesExta(){  
    let baseTemplateUrl = '../html-Templates/'
    let link = document.querySelector('link[href="'+baseTemplateUrl+'medicos.templates.html"]')
    var templates = {
      par   : link.import.querySelector('#especialidadMinWidget').content,
      inpar : link.import.querySelector('#especialidadMinWidgetInpar').content
    }
    return templates;
  }
}
