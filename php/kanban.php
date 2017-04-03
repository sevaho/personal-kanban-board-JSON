<?php

  //include ('session.php');

  //Variables
  $title = $_POST['title'];
  $description = $_POST['description'];
  $id = $_POST['id'];
  $table = $_POST['table'];
  $table_new = $_POST['table_new'];
  $table_old = $_POST['table_old'];
  $function = $_POST['function'];
  $date_string = $_POST['date_string'];
  $arrayIds = $_POST['arrayIds'];

  //Parsing existing JSON into a associative array NOT objects! object array will not work due to fixed index
  //fe. 1: { title: .. } instead of { title: .. } 
  $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
  $context = stream_context_create($opts);
  $jsonString = file_get_contents('../kanban.json', FALSE, $context);
  $data = json_decode($jsonString,TRUE);

  //TODO
  function insertAtSpecificPos($table,$id,$title,$description){

    global $data;
    array_splice($data,"ideas",1,"test");

    $newJsonString = json_encode($data);
    file_put_contents('../kanban.json',$newJsonString);
  }

	function addItem($id,$table,$title,$description,$date_string){
    
    global $data;
    $index=count($data[$table]);

    $data[$table][$index][id]=$id;
    $data[$table][$index][title]=$title;
    $data[$table][$index][description]=$description;
    $data[$table][$index][date_string]=$date_string;

    $newJsonString = json_encode($data);
    file_put_contents('../kanban.json',$newJsonString);
	}

  function removeItem($id,$table){
    
    global $data;
    $arrayNr= searchKey($id,$table);

    unset($data[$table][$arrayNr]);
		
    //This line is of uttermost importance this line will parse the php array back to an associative array instead of objects
    //Default is an array of objects
    $data[$table] = array_values($data[$table]);

    $newJsonString = json_encode(($data));
    file_put_contents('../kanban.json',$newJsonString);
	}

  //Combination of add and remove
	function moveItem($id,$table_old,$table_new,$arrayIds){

    global $data;
    $data_new = $data;
    $arrayIdsLength = count($arrayIds);
    $arrayNr= searchKey($id,$table_old);

    //deletes the new table 
    $ar=count($data[$table_new]);

    //deletes the new table 
    for ($x = 0; $x < $ar; $x++) {
      unset($data[$table_new][$x]);
    }

    //fill the new table with bad code
    for ($x = 0; $x < $arrayIdsLength; $x++) {

      if ($arrayIds[$x] == $id){

        $title = $data_new[$table_old][$arrayNr][title];
        $description = $data_new[$table_old][$arrayNr][description];
        $date_string = $data_new[$table_old][$arrayNr][date_string];

        addItem($arrayIds[$x],$table_new,$title,$description,$date_string);

      } else {

        $title = $data_new[$table_new][searchKeyCustom($arrayIds[$x],$table_new,$data_new)][title];
        $description = $data_new[$table_new][searchKeyCustom($arrayIds[$x],$table_new,$data_new)][description];
        $date_string = $data_new[$table_new][searchKeyCustom($arrayIds[$x],$table_new,$data_new)][date_string];

        addItem($arrayIds[$x],$table_new,$title,$description,$date_string);

      }
    }

    //if you move within 1 table this line is needed
    if ($table_new != $table_old)
      removeItem($id,$table_old);

	}

  function searchKey($id,$table){

    global $data;

    foreach ($data[$table] as $key => $entry){
      if ($entry[id] == $id)
       return $key;
    }
  }
  //search a custom array, here a copy of the original $data array
  function searchKeyCustom($id,$table,$data){

    foreach ($data[$table] as $key => $entry){
      if ($entry[id] == $id)
       return $key;
    }
  }

  if ($function == "additem")
    addItem($id,"idea",$title,$description,$date_string);
  elseif ($function == "removeitem")
    removeItem($id, $table);
  elseif ($function == "moveitem")
    moveItem($id,$table_old,$table_new,$arrayIds);

?>

