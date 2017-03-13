<?php

  //include ('session.php');

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5e80dde8d72e9b630fa148b353b76c932d5e2ac6
  //Variables
  $title = $_POST['title'];
  $description = $_POST['description'];
  $id = $_POST['id'];
  $table = $_POST['table'];
  $table_new = $_POST['table_new'];
  $table_old = $_POST['table_old'];
  $function = $_POST['function'];
  $date_string = $_POST['date_string'];

  //Parsing existing JSON into a associative array NOT objects! object array will not work due to fixed index
  //fe. 1: { title: .. } instead of { title: .. } 
  $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
  $context = stream_context_create($opts);
  $jsonString = file_get_contents('../events.json', FALSE, $context);
  $data = json_decode($jsonString,TRUE);
<<<<<<< HEAD

  //TODO
  function insertAtSpecificPos($table,$id,$title,$description){

    global $data;
    array_splice($data,"ideas",1,"test");
=======

  //TODO
  function insertAtSpecificPos($table,$id,$title,$description){

    global $data;
    array_splice($data,"ideas",1,"test");
=======
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
>>>>>>> 88737f4ad66ae0f8e904723821ee0cc0ca24a8b0
>>>>>>> 5e80dde8d72e9b630fa148b353b76c932d5e2ac6

    $newJsonString = json_encode($data);
    file_put_contents('events.json',$newJsonString);
  }

	function addItem($id,$table,$title,$description,$date_string){
    
    global $data;
    $index=count($data[$table]);

    $data[$table][$index][id]=$id;
    $data[$table][$index][title]=$title;
    $data[$table][$index][description]=$description;
    $data[$table][$index][date_string]=$date_string;

    $newJsonString = json_encode($data);
    file_put_contents('../events.json',$newJsonString);
<<<<<<< HEAD
	}

  function removeItem($id,$table){
    
    global $data;
    $arrayNr= searchKey($id,$table);

    unset($data[$table][$arrayNr]);
		
    //This line is of uttermost importance this line will parse the php array back to an associative array instead of objects
    //Default is an array of objects
    $data[$table] = array_values($data[$table]);

    $newJsonString = json_encode(($data));
    file_put_contents('../events.json',$newJsonString);
	}

  //Combination of add and remove
	function moveItem($id,$table_old,$table_new){
    
    global $data;
    $arrayNr= searchKey($id,$table_old);

    addItem($id,$table_new,$data[$table_old][$arrayNr][title],$data[$table_old][$arrayNr][description],$data[$table_old][$arrayNr][date_string]);

    removeItem($id,$table_old);
	}

=======
	}
	function moveItem($id,$old_type,$type,$title,$description){
    
    //combination of remove and add
    removeItem($id,$old_type);
    addItem($type,$id,$title,$description);
    
		
	}


  function removeItem($id,$table){
    
    global $data;
    $arrayNr= searchKey($id,$table);

    unset($data[$table][$arrayNr]);
		
    //This line is of uttermost importance this line will parse the php array back to an associative array instead of objects
    //Default is an array of objects
    $data[$table] = array_values($data[$table]);

    $newJsonString = json_encode(($data));
    file_put_contents('../events.json',$newJsonString);
	}

  //Combination of add and remove
	function moveItem($id,$table_old,$table_new){
    
    global $data;
    $arrayNr= searchKey($id,$table_old);

    addItem($id,$table_new,$data[$table_old][$arrayNr][title],$data[$table_old][$arrayNr][description],$data[$table_old][$arrayNr][date_string]);

    removeItem($id,$table_old);
	}

>>>>>>> 5e80dde8d72e9b630fa148b353b76c932d5e2ac6
  function searchKey($id,$table){

    global $data;

    foreach ($data[$table] as $key => $entry){
      if ($entry[id] == $id)
       return $key;
    }
  }
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5e80dde8d72e9b630fa148b353b76c932d5e2ac6

  if ($function == "additem")
    addItem($id,"idea",$title,$description,$date_string);
  elseif ($function == "removeitem")
    removeItem($id, $table);
  elseif ($function == "moveitem")
    moveItem($id,$table_old,$table_new);
    
<<<<<<< HEAD
=======
=======
  consolelog("Test");
  //addItem("ideas",1,"testTtile","testdesc");
  removeItem(1,"ideas");
>>>>>>> 88737f4ad66ae0f8e904723821ee0cc0ca24a8b0
>>>>>>> 5e80dde8d72e9b630fa148b353b76c932d5e2ac6
?>

