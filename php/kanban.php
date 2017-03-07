<?php

  //include ('session.php');

  //Parsing 
  $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
  $context = stream_context_create($opts);
  $jsonString = file_get_contents('../events.json', FALSE, $context);
  $data = json_decode($jsonString,true);


	function changeBoard($id){
		
		//TODO

		//Save the modified parsed JSON to the JSON file
    $newJsonString = json_encode($data);
    file_put_contents('events.json',$newJsonString);
	}

  function consolelog($data){
    if (is_array( $data))
      $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data ) . "'  );</script>";
    else
      $output = "<script>console.log( 'Debug Objects: " . $data . "'  );</script>";
    echo $output;
  }
  consolelog("Test");
?>

