<?php
	$name = $_REQUEST["name"];
	
		        $host = "127.0.0.1";
				$user = "root";
				$pwd = "*";
				$dbs = "evanjohnston";
				//$port = "3306";
				$connect = mysqli_connect ($host, $user, $pwd, $dbs);
				$table = "Brainsurge";
	
	$names = array();
	$result = mysqli_query($connect, "SELECT * from $table");
	
	while ($row = $result->fetch_row()){
		array_push($names, $row[2]);
	}	
	if(in_array($name, $names)){
		echo "taken";	
	}
	mysqli_close($connect);

exit;
?>
