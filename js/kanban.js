$.ajaxSetup({ cache: false  }); 

  //start working from JSON to APP

var item = function(type, id, title, description){
  var self = {}
  self.type = type;
  self.id = id;
  self.title = title;
  self.description = description;

  return self;
}

function newItem(){
  //add new dom element inside idea
  //call php to save in json
  test= $('<div></div>');
  test.attr('class','items');
  $('#idea').append(test);
}
function moveItem(){
  //move to another col
  //call php to save in json
}
function deleteItem(){
  //deletes item
}
