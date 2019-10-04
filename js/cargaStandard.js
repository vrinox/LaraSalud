function cargarTemplatesS(){
  let templates = ['header','footer'];
  let baseTemplateUrl = 'html-Templates/'
  templates.map((templateName)=>{
    //link
    let link = document.querySelector('link[href="'+baseTemplateUrl+templateName+'.html"]')
    var template = link.import.querySelector('template');
    var clone = document.importNode(template.content, true);
    //conatiner    
    let id = templateName+'Container';
    document.querySelector('#'+id).appendChild(clone);
  })
}
cargarTemplatesS();