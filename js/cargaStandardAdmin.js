function cargarTemplatesS(){
  let templates = [
    {
      name:'adminHeader',
      id:"header"
    },{
      name:'adminFooter',
      id:'footer'
    },{
      name:'sidebar',
      id:"sidebar"
    }
  ];
  let baseTemplateUrl = '../html-Templates/'
  templates.map((templateOb)=>{
    //link
    let link = document.querySelector('link[href="'+baseTemplateUrl+templateOb.name+'.html"]')
    var template = link.import.querySelector('template');
    var clone = document.importNode(template.content, true);
    //container 
    if(document.querySelector('#'+templateOb.id)){
      document.querySelector('#'+templateOb.id).appendChild(clone);
    }
  })
  let link = document.querySelector('link[href="'+baseTemplateUrl+'metaAdds.html"]')
  var template = link.import.querySelector('template');
  var clone = document.importNode(template.content, true);
  //conatiner    
  document.head.appendChild(clone);
}
cargarTemplatesS();