<?php
/**
 * Conver a CSV file into a JSON format
 * 
 * Usage: >php csv2json.php CSV_FILE_NAME
 */

if( !$argv[1] ){
	echo "No file provided\n";
	exit();
}
ini_set("auto_detect_line_endings", true);
$handle = fopen( $argv[1], "r" );
if( ! $handle) exit( "Cannot open file");

$obj = array();

$sub = array();

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	
	
	
    $num = count($data);
	
	$ary = explode( "_",$data[1] , 4);
	//var_dump($ary);
	$name = implode( "_", array($ary[0], $ary[1],$ary[2]));
	
	// if no color (finale and east egg)
	
	if( !isset($ary[3])){
		//$name = implode( "_", array($ary[0], $ary[1],$ary[2]));
		$sub[$name] = array(
			"playerId" => (INT)$data[3]
		);
		//echo $name."\n";
	}else{
		//$name = implode( "_", array($ary[0], $ary[1],$ary[2]));
	
		// already created, just add color
		
		if( isset( $sub[$name] )){
			$sub[$name]["variants"][$ary[3]]=(INT)$data[5];
		}else{
			//echo "create : ".$name."\n";
			//create and put first color
			$sub[$name] = array(
				"playerId" => (INT)$data[3],
				"variants" => array(
					$ary[3] => (INT)$data[5]
				)
			);
		}
	}
	
}

fclose($handle);
//var_dump($sub);
$obj = array();
$obj["assets"]=$sub;
echo (json_encode($obj));
