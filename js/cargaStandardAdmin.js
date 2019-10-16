function cargarTemplatesS(){
  let templates = ['adminHeader','adminFooter'];
  let baseTemplateUrl = '../html-Templates/'
  templates.map((templateName)=>{
    //link
    let link = document.querySelector('link[href="'+baseTemplateUrl+templateName+'.html"]')
    var template = link.import.querySelector('template');
    var clone = document.importNode(template.content, true);
    //conatiner    
    let id = templateName+'Container';
    document.querySelector('#'+id).appendChild(clone);
  })
  let link = document.querySelector('link[href="'+baseTemplateUrl+'metaAdds.html"]')
  var template = link.import.querySelector('template');
  var clone = document.importNode(template.content, true);
  //conatiner    
  document.head.appendChild(clone);
}
cargarTemplatesS();