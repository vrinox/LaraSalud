arranque();
function arranque(){
  let search = capturarDirectorioFormURL();
  document.getElementById('nombreDirectorio').innerHTML = "DIRECTORIO / "+search['tipo'].toUpperCase();
}
function buscarListaPremium(){
  //TODO: cargar lista premium
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