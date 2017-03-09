<?php

  //include ('session.php');

  $func = $_POST['func'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $id = $_POST['id'];
  $type = $_POST['type'];
  $old_type = $_POST['old_type'];

  //Parsing 
  $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
  $context = stream_context_create($opts);
  $jsonString = file_get_contents('events.json', FALSE, $context);
  $data = json_decode($jsonString,true);

  //the only thing php needs to do is delete and insert data in the json
  //parameters: col number, id

  function insertAtSpecificPos($type,$id,$title,$description){
    global $data;
    array_splice($data,"ideas",1,"test");

    $newJsonString = json_encode($data);
    file_put_contents('events.json',$newJsonString);

  }
	function addItem($type,$id,$title,$description){
    
    global $data;
    $index=count($data[$type]);

    consolelog($data["ideas"][1]["title"]);
    $data[$type][$index][id]=$index;
    $data[$type][$index][title]=$title;
    $data[$type][$index][description]=$description;

		//Save the modified parsed JSON to the JSON file
    $newJsonString = json_encode($data);
    file_put_contents('events.json',$newJsonString);
	}
  function removeItem($id,$type){
    
    global $data;

    unset($data[$type][$id]);
		
		//TODO

		//Save the modified parsed JSON to the JSON file
    $newJsonString = json_encode($data);
    file_put_contents('events.json',$newJsonString);
	}
	function moveItem($id,$old_type,$type,$title,$description){
    
    //combination of remove and add
    removeItem($id,$old_type);
    addItem($type,$id,$title,$description);
    
		
	}


  function consolelog($data){
    if (is_array( $data))
      $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data ) . "'  );</script>";
    else
      $output = "<script>console.log( 'Debug Objects: " . $data . "'  );</script>";
    echo $output;
  }
  consolelog("Test");
  //addItem("ideas",1,"testTtile","testdesc");
  removeItem(1,"ideas");
?>

