arranque();
function arranque() {
  document.getElementById('buscar').onclick = () => {
    buscar();
  }
  $('#sortable-8').sortable({
    update: function (event, ui) {
      var posicionOrden = $(this).sortable('toArray').toString();
      $("#sortable-9").text(posicionOrden);
      document.getElementById("posicionesD").value = posicionOrden;
    }
  });
  buscarDirectorios('Ambulancia');
}

// control
function cargarTemplatesDir() {
  let baseTemplateUrl = '../html-Templates/'
  let link = document.querySelector('link[href="' + baseTemplateUrl + 'directorio.templates.html"]')
  var templates = {
    elementoLista: link.import.querySelector('#elementoLista').content,
  }
  return templates;
}

function setFormValues(valores = {}) {
  let inputs = document.querySelector('#form').querySelectorAll('input');
  inputs.forEach((each) => {
    Object.keys(valores).forEach((key) => {
      if (each.name == key && key != "logo") {
        //TODO: problemas con el checkbox
        each.value = valores[key];
      }
    })
  });
  //combos
  let selects = document.querySelector('#form').querySelectorAll('select');
  selects.forEach((each) => {
    Object.keys(valores).forEach((key) => {
      if (each.name == key) {
        //TODO: problemas con el checkbox
        each.value = valores[key];
      }
    })
  });
}
function getFormValues() {
  return new Promise((resolve, reject) => {
    let valores = {};
    let inputs = document.querySelector('#form').querySelectorAll('input');
    inputs.forEach((each) => {
      valores[each.name] = each.value;
      if (each.name == "id") {
        valores[each.name] = parseInt(each.value);
      }
    });
    //combos
    let selects = document.querySelector('#form').querySelectorAll('select');
    selects.forEach((each) => {
      valores[each.name] = each.value;
    })
    let file = $('#logo').prop('files')[0];
    if (file) {
      toBase64(file).then((string) => {
        valores.file = string;
        resolve(valores);
      }).catch((err) => {
        console.log(err);
        reject();
      })
    } else {
      resolve(valores);
    }
  })
}
function limpiar() {
  let inputs = document.querySelector('#form').querySelectorAll('input');
  inputs.forEach((each) => {
    each.value = '';
  });
  //combos
  let selects = document.querySelector('#form').querySelectorAll('select');
  selects.forEach((each) => {
    each.value = '';
  });
}
// consultas
function buscar() {
  let tipo = document.getElementById('tipodirectorio').value;
  let nombre = document.getElementById('titulo').value;
  if (nombre) {
    let json = {
      "modelo": "directorio",
      "operacion": "buscar",
      "tipo": tipo,
      "nombre": nombre
    }
    postAd(json).then((data) => {
      setFormValues(data.directorio);
    })
  }
}
function buscarDirectorios(valor) {
  let json = {
    "modelo": "directorio",
    "operacion": "posicionar",
    "tipo": valor
  }
  llenarLista(json);
}
function listar() {
  let json = {
    "modelo": "directorio",
    "operacion": "listar"
  }
  llenarLista(json);
}
//operaciones basicas
function agregar() {
  getFormValues().then((json) => {
    json['modelo'] = "directorio";
    json['operacion'] = "agregar";
    if (!json.id) {
      if (document.forms.form.checkValidity()) {
        postAd(json).then((data) => {
          alert(data.mensaje);
        })
      } else {
        alert('Llene todos los campos para continuar');
      }
    } else {
      alert('Limpie el formulario antes de continuar');
    }
  });
}
function modificar() {
  getFormValues().then((json) => {
    json['modelo'] = "directorio";
    json['operacion'] = "modificar";
    postAd(json).then((data) => {
      if (data.success) {
        alert("Cambios guardados de forma correcta");
      } else {
        alert(data.mensaje);
      }
    })
  });
}
function borrar() {
  let json = {
    "modelo": "directorio",
    "operacion": "borrar",
    "id": document.getElementById('id').value
  }
  postAd(json).then((data) => {
    if (data.success) {
      limpiar();
    }
    alert(data.mensaje);
  })
}
function llenarLista(json) {
  let templates = cargarTemplatesDir();
  let container = document.querySelector('#sortable-8');
  container.innerHTML = '';
  postAd(json).then((data) => {
    if (data.success) {
      data.directorios.forEach((each) => {
        let newEspecialidad = document.importNode(templates.elementoLista.firstElementChild, true);
        container.appendChild(newEspecialidad);
        newEspecialidad.outerHTML = newEspecialidad.outerHTML
          .split('$id$').join(each.id)
          .split('$nombre$').join(each.nombre);
        newEspecialidad.ondou
      })
    } else {
      if (data.mensaje) {
        alert(data.mensaje)
      }
    }
  })
}
function posicionar() {
  let posicionOrden = document.getElementById("posicionesD").value;
  let x = 0;
  let arreglo = posicionOrden.split(',').map((id)=>{
    x++;
    return {"id":id,"posicion":x}
  });
  let json = {
    "modelo":"directorio",
    "operacion":"enviarPos",
    "posiciones":arreglo
  }
  postAd(json).then((data)=>{
    alert(data.mensaje);
  })
}
function postAd(json, headers = {}) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: 'https://www.larasalud.com/API/',
      type: 'post',
      data: JSON.stringify(json),
      crossDomain: true,
      headers: { "Accept": "application/json" },
      dataType: 'json',
      success: function (data) {
        resolve(data);
      }
    });
  });
}
//file
const toBase64 = file => new Promise((resolve, reject) => {
  const reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onload = () => resolve(reader.result);
  reader.onerror = error => reject(error);
});
