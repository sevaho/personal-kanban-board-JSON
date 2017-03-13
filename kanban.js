$.ajaxSetup({ cache: false  }); 

//Global variables
var d = new Date();

//constructors
//Parameters__ id: unique id, generated by function; table: is the column it will be placed in; title; description: will be split at a dash '-' into <p/> elements; date_string: formatted to fe. 09/02, generated by function
var item = function(id,table,title,description,date_string){
  var self = {};
  self.id = id;
  self.table = table;
  self.title = title;
  self.description = description.split(/<p>|<\/p>|-/); //array
  self.date_string = date_string;
  self.draw = function(){
    var item_div = $('<div></div>');
    var item_title = $('<h4></h4>');
    var item_date = $('<div></div>');
    item_div.attr('class','item centered');
    item_div.attr('id',self.id);
    item_title.attr('class','item-h4');
    item_date.attr('class','item-date');
    item_title.html(self.title);
    item_date.html(self.date_string);
    item_div.append(item_title);
    item_div.append(item_date);
    self.description.forEach(function(element){
      var item_description = $('<p></p>');
      item_description.attr('class','item-p');
      element=element.trim();
      if (element != ""){
        item_description.html('- '+element);
        item_div.append(item_description);
      }
    });
    $('#'+self.table).append(item_div);
  }
  var draw = self.draw();

  return self;
}

function buildGrid(){
  $.getJSON('events.json', function(data){
  for (i=0;i<data.idea.length;i++){ new item(data.idea[i].id,'idea',data.idea[i].title,data.idea[i].description,data.idea[i].date_string) }
  for (i=0;i<data.todo.length;i++){ new item(data.todo[i].id,'todo',data.todo[i].title,data.todo[i].description,data.todo[i].date_string) }
  for (i=0;i<data.deliver.length;i++){ new item(data.deliver[i].id,'deliver',data.deliver[i].title,data.deliver[i].description,data.deliver[i].date_string) }
  for (i=0;i<data.review.length;i++){ new item(data.review[i].id,'review',data.review[i].title,data.review[i].description,data.review[i].date_string) }
  });
}

function cleanGrid(){
  $('.container').find('div').each(function(){
    this.remove();
  });
}

function generateID(){
  var secondCounter = d.getSeconds();
  if (secondCounter < 10)
    secondCounter = '0'+secondCounter;
  var minuteCounter = d.getMinutes();
  if (minuteCounter < 10)
    minuteCounter = '0'+minuteCounter;
  var hourCounter = d.getHours();
  if (hourCounter < 10)
    hourCounter = '0'+hourCounter;
  var dayCounter = d.getDate();  
  if (dayCounter < 10)
    dayCounter = '0'+dayCounter; 
  var monthCounter = (d.getMonth()+1);
  if (monthCounter < 10)
    monthCounter = '0'+monthCounter;
  var random = Math.floor((Math.random() * 100) + 1); //between 1 and 100

  var id = monthCounter+''+dayCounter+''+hourCounter+''+minuteCounter+''+secondCounter+''+random;
  return id;
}

function generateDate_string(){
  month = d.getMonth()+1;
  return d.getDate()+'/'+month;
}

//Parameters__ id: unique id, generated by function; tite; description; 
function addItem(id,title,description,date_string){
  if (title === "" ||  description === ""){
    return;
  }
  $.ajax({
    method:'POST',
    url:'php/kanban.php',
    data: {function: "additem",id: generateID(),title: title,description: description, date_string: date_string},
    datatype: 'json',
    success:function(){
      window.location.hash = '';
      console.log("added succes");
      cleanGrid();
      buildGrid();
    }
  });
}
//Parameters__ id: unique id, generated by function; table_old: is the column it will be moved from; table_new: is the column it will be moved to
function moveItem(id,table_old,table_new){
  var arrayIds = [];
  $("#"+table_new).children().each(function(arrayNr,element){arrayIds.push(element.id)});
  console.log(arrayIds);
  $.ajax({
    method:'POST',
    url:'php/kanban.php',
    data: {function: "moveitem",id: id,table_old: table_old, table_new: table_new, arrayIds: arrayIds},
    datatype: 'json',
    success:function(){
      console.log(" moved success");
      cleanGrid();
      buildGrid();
    }
  });
}
//Parameters__ id: unique id, generated by function; table: is the column it will be deleted from; el: complete div element
function removeItem(id,table,el){
  $.ajax({
    method:'POST',
    url:'php/kanban.php',
    data: {function: "removeitem",id: id,table: table},
    datatype: 'json',
    success:function(){
      console.log("deleted success");
      cleanGrid();
      buildGrid();
    }
  });
  //Deletes div
  el.remove();
}

dragula([document.querySelector('#wastebucket'),document.querySelector('.container'), document.querySelector('#todo'),document.querySelector('#deliver'),document.querySelector('#review')]).on('drag', function (el) {
}).on('drop', function (el, table_new, table_old ) {
  if (table_new.id === 'wastebucket') {
    removeItem(el.id,table_old.id,el);
  } else {
    moveItem(el.id,table_old.id,table_new.id);
  }
  $('#wastebucket').css('background-color','white');
}).on('over', function (el, container) {
  $('#wastebucket').css('background-color','red');
  if (el.id === 'itemformdiv')
    el.remove();
}).on('out', function (el, container) {
}).on('click', function (el, container) {
});

function additemform(){
  var form_div = $('<div></div>');
  var form = $('<form></form>');
  var form_field = $('<div></div>');
  var form_input_title = $('<input></input>');
  var form_textarea = $('<textarea></textarea>');
  var form_button = $('<button></button>');
  var form_button_close = $('<i></i>');
  form_div.attr('class','item centered');
  form_div.attr('id','itemformdiv');
  form.attr('id',"itemform");
  form_button.attr('type','submit');
  form_button.attr('value','Submit');
  form_button.attr('id','buttonid');
  form_button_close.attr('id','formclose');
  form_button_close.attr('class','fa fa-times');
  form_button_close.attr('aria-hidden','true');
  form_button.html("Add");
  form_input_title.attr('id','item_title');
  form_input_title.attr('type','text');
  form_input_title.attr('name','item_title');
  form_input_title.attr('placeholder','title');
  form_input_title.attr('autocomplete','off');
  form_textarea.attr('id','item_description');
  form_textarea.attr('type','text');
  form_textarea.attr('name','item_description');
  form_textarea.attr('placeholder','description');
  form_textarea.attr('autocomplete','off');
  form.append(form_input_title);
  form.append(form_button_close);
  form.append(form_textarea);
  form.append(form_button);
  form_div.append(form);

  $('#idea').append(form_div);

  $(form_button_close).click(function(){
    $(form_div).remove();
  });

  $('#itemform').submit(function(e){
    console.log("form submitted!");
    var title = $('#item_title').val();
    var description = $('#item_description').val();
    $('#itemformdiv').fadeOut(500);

    if (title === "" | description === ""){
      console.log("sdfsdfsdf emoty");
      $(form_div).remove();
    } else {
      addItem(generateID(),title,description,generateDate_string());
    }
    $(this).get(0).reset();
    e.preventDefault();
  });
}

$(document).ready(function(){
  $('#newitem').click(function(e){
    additemform();
    e.preventDefault();
  });
});

//Build the grid once at start manually, after this it will be build automatically when  ajax is called
buildGrid();