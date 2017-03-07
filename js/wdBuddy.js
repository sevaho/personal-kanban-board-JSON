colorEveryDiv();
colorEverySection();

function colorEveryDiv(){

  colors=["red","blue","green","yellow","purple", "cyan", "orange", "violet"];
  $("div").each(function(j, el){
      $(this).css({"outline-color": colors[Math.floor(Math.random() * colors.length)], "outline-style": "solid", "outline-width": "5px"});
  })
} 
function colorEverySection(){
  colors=["brown","black"];
  $("section").each(function(j, el){
    if(j % 2 == 0){
      $(this).css({"border-color": colors[1], "border-width":"6px", "border-style":"solid"}); 
    } else {
      $(this).css({"border-color": colors[0], "border-width":"4px", "border-style":"solid"});     
    }
  })
}
