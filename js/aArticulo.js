arranque();
function arranque(){
  let select = document.querySelector('#autor');
  let json = {
    "modelo":"medico",
    "operacion":"listar"
  }
  postAd(json).then((data)=>{
    if(data.success){
      data.medicos.forEach((medico)=>{
        let option = document.createElement('option');
        option.value = medico.id;
        option.textContent = medico.nombre.trim();
        select.appendChild(option);
      })
    }
  })
}
// FORMULARIO
function limpiar(){
  let inputs = Array.from(document.querySelector('#form').querySelectorAll('input'));
    let selects = Array.from(document.querySelector('#form').querySelectorAll('select'));
    let textarea = Array.from(document.querySelector('#form').querySelectorAll('textarea'));
    let todos = inputs.concat(selects).concat(textarea);
    todos.forEach((each) => {
        each.value = '';
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
      if(each.type !== 'file'){
        valores[each.name] = each.value;
        if (each.name == "id") {
          valores[each.name] = parseInt(each.value);
        }
      }
    });
    //tinyMCE
    valores['contenido'] = tinyMCE.get('contenido').getContent({format:'raw'});
    //files
    let files = document.querySelector('#form').querySelectorAll('input[type="file"]');
    if(files){
      Promise.all(Array.from(files).map((input)=>{
        return toBase64(input);
      }))
      .then((base64Files)=>{
        base64Files.forEach((file)=>{
          valores[file.id] = file.string;
        })
        resolve(valores);
      })
      .catch((err)=>{
        console.log('[Error]',err);
        reject();
      })
    }else{
      resolve(valores);
    }    
  })
}
//file
const toBase64 = file => new Promise((resolve, reject) => {
  const reader = new FileReader();
  reader.readAsDataURL(file['files'][0]);
  reader.onload = () => resolve({
    "id"     : file.id,
    "string" : reader.result
  });
  reader.onerror = error => reject(error);
});
// OERACIONES BASICAS
function agregar(){
  getFormValues()
  .then((json)=>{
    json.modelo = 'articulo';
    json.operacion = 'agregar';
    return postAd(json);
  })
  .then((data)=>{
    alert(data.mensaje);
    if(data.success){
      limpiar();
    }
  });
}
function buscar(){
  let titulo = document.querySelector('#titulo').value;
  let json = {
    "modelo":"articulo",
    "operacion":"buscar",
    "titulo":titulo
  }
  if(titulo){
    postAd(json).then((data)=>{
      if(data.success){
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