arranque();
function arranque() {
  cargarMedicos();
  cargarCategorias();
}
function cargarMedicos() {
  let select = document.querySelector('#autor');
  let json = {
    "modelo": "medico",
    "operacion": "listar"
  }
  postAd(json).then((data) => {
    if (data.success) {
      data.medicos.forEach((medico) => {
        let option = document.createElement('option');
        option.value = medico.id;
        option.textContent = medico.nombre.trim();
        select.appendChild(option);
      })
    }
  })
}
function cargarCategorias() {
  let json = {
    "modelo": "categoria",
    "operacion": "listar"
  }
  postAd(json).then((data) => {
    if (data.success) {
      let contenedor = document.querySelector('#categorias');
      let html = '';
      data.categorias.forEach((categoria) => {
        let nombre = categoria.categoria;
        let valor = categoria.id;
        html += `<input type="checkbox" name="${nombre}" value="${valor}" id="${nombre}" />
       <label class="list-group-item" for="${nombre}">${nombre}</label>`;
      })
      contenedor.innerHTML = html;
    }
  })
}
// FORMULARIO
function limpiar() {
  let inputs = Array.from(document.querySelector('#form').querySelectorAll('input'));
  let selects = Array.from(document.querySelector('#form').querySelectorAll('select'));
  let textarea = Array.from(document.querySelector('#form').querySelectorAll('textarea'));
  let todos = inputs.concat(selects).concat(textarea);
  todos.forEach((each) => {    
    if(each.type == 'checkbox'){
      each.checked = false;
    }else{
      each.value = '';
    }
  });
  //tinyMCE
  tinyMCE.get('contenido').setContent('');
}
function getFormValues() {
  return new Promise((resolve, reject) => {
    let valores = {};
    let inputs = Array.from(document.querySelector('#form').querySelectorAll('input'));
    let selects = Array.from(document.querySelector('#form').querySelectorAll('select'));
    let textarea = Array.from(document.querySelector('#form').querySelectorAll('textarea'));
    let todos = inputs.concat(selects).concat(textarea);
    todos.forEach((each) => {
      if (each.type !== 'file' && each.type !== 'checkbox') {
        valores[each.name] = each.value;
        if (each.name == "id") {
          valores[each.name] = parseInt(each.value);
        }
      }
    });
    //tinyMCE
    valores['contenido'] = escapeHtml(tinyMCE.get('contenido').getContent({ format: 'raw' }));
    //checkbox 
    let categorias = Array.from(document.querySelector('#form').querySelectorAll('input[type="checkbox"]'))
      .map((input) => {
        if (input.checked) {
          return input.value;
        }
      })
      .filter(Boolean);
    valores['categorias'] = categorias;
    console.log(valores)
    resolve(valores);
  })
}
function validarFiles(inputs) {
  let validado = true;
  inputs.forEach((input) => {
    if (!input.files[0]) {
      validado = false;
    }
  });
  return validado;
}
function escapeHtml(unsafe) {
  return unsafe
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
//file
const toBase64 = input => new Promise((resolve, reject) => {
  const reader = new FileReader();
  let file = input.files[0];
  if (file) {
    reader.readAsDataURL(file);
    reader.onload = () => resolve({
      "id": input.id,
      "string": reader.result
    });
    reader.onerror = error => reject(error);
  } else {
    reject('');
  }
});
function subirImagenes() {
  return new Promise((resolve, reject) => {
    //obtengo todos los archivos del formulario
    let inputs = document.querySelector('#form').querySelectorAll('input[type="file"]');
    if (validarFiles(inputs)) {
      //ejecuto de forma paralela la tansformacion a base64
      Promise.all(Array.from(inputs).map((input) => {
        return toBase64(input);
      }))
        .then((base64Files) => {
          //ejecuto en paralelo la subida de los archivos      
          return Promise.all(base64Files.map((file) => {
            return subirImagen({ "nombre": file.id, "cadena": file.string });
          }))
        })
        .then((rutas) => {
          resolve(rutas);
        })
        .catch((err) => {
          console.log('[Error]', err);
          reject('Error al subir la imagenes');
        })
    } else {
      reject('Selecciona las 3 imagenes antes de guardar los cambios');
    }
  })
}
function subirImagen(file) {
  return new Promise((resolve, reject) => {
    let json = {
      "modelo": "articulo",
      "operacion": "subirImagen",
      "nombre": file.nombre,
      "base64": file.cadena
    }
    postAd(json).then((data) => {
      if (data.success) {
        resolve({ "nombre": data.nombre, "ruta": data.ruta })
      } else {
        console.log('[Error]', data.mensaje)
        reject();
      }
    })
  })
}
// OERACIONES BASICAS
function agregar() {
  let json = {};
  if (document.forms.form.checkValidity()) {
    subirImagenes()
      .then((rutas) => {
        let valores = {};
        //transformo las rutas de los archivos subidos en un objeto de tipo json
        rutas.forEach((obj) => {
          valores[obj.nombre] = obj.ruta;
        })
        //mezclo los objetos para mantener las anteriores 
        json = { ...json, ...valores };
        return getFormValues()
      })
      .then((values) => {
        json.modelo = 'articulo';
        json.operacion = 'agregar';
        //mezclo los objetos para mantener las anteriores 
        json = { ...json, ...values };
        return postAd(json);
      })
      .then((data) => {
        alert(data.mensaje);
        if (data.success) {
          limpiar();
        }
      });
  }
}
function buscar() {
  let titulo = document.querySelector('#titulo').value;
  let json = {
    "modelo": "articulo",
    "operacion": "buscar",
    "titulo": titulo
  }
  if (titulo) {
    postAd(json).then((data) => {
      if (data.success) {
        setFormulario(data.articulo);
      }
    })
  }
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