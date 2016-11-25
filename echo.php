<?php 
$arr = json_encode($_POST);
sendData($_POST);
?>


<?php
function sendData($user){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "myDB";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$t = time();
	$id = 0;
	$tspan = json_encode($t);
	$usr = $user["Username"];
	//$sql = "SELECT * FROM `users`";
	$sql = "SELECT * FROM `users` WHERE user like '$usr'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
				$user = $row["user"];
				$tmspan = $row["timespan"];
				$id = $row["id"];
		}
		$sql = "UPDATE `users` SET timespan='$tspan' WHERE id='$id'";
	} else {
		$sql = "INSERT INTO `users` (user, timespan) VALUES ('$usr', '$tspan')";
	}
	$result = $conn->query($sql);

	$arr = array();
	$i = 0;
	$sql = "SELECT * FROM `users` WHERE timespan > $tspan-300";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
				$user = $row["user"];
				$tmspan = $row["timespan"];
				$id = $row["id"];
				$arr["User"][$i] = $user;
				$arr["Timespan"][$i] = $tmspan;
				$arr["Id"][$i] = $id;
				$i = $i + 1;
				//echo json_encode(array('user'=>$user));
		}
		$sql = "UPDATE `users` SET timespan='$tspan' WHERE id='$id'";
	} else {
		$sql = "INSERT INTO `users` (user, timespan) VALUES ('$usr', '$tspan')";
	}
	$conn->close();
	echo json_encode($arr);
}
?>
