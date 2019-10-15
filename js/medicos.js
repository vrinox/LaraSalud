arranque();
function arranque(){
  let esp = new Especialidades();
  let contenedores = document.querySelectorAll('.contenedorListaEspecialidades');
  let templates = esp.cargarTemplatesExta();
  esp.buscarEspecialidades('M').then((data)=>{
    esp.crearEspecialidades(contenedores,templates,data);
  })
}
