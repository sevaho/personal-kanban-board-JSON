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

<<<<<<< HEAD
function checkForItems(){
  $.getJSON('../events.json',function(data){
    $()
      })
}
=======
>>>>>>> 88737f4ad66ae0f8e904723821ee0cc0ca24a8b0
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
<<<<<<< HEAD

$(document).ready(function(){
  $("button").onclick()
  //AJAX
    $.ajax({
      method:'POST',
      url:'php/kanban.php',
      data:
      datatype:'json',
      succes:function(){
        clean();
        updateAll();
      }
    });
    e.preventDefault();
});
=======
>>>>>>> 88737f4ad66ae0f8e904723821ee0cc0ca24a8b0
