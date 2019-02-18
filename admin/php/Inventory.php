<!DOCTYPE html>
<html>
<head>
	<title>Equipment Library</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
</head>

<body>
		
		<div id="header">
			
			<ul id="menu">
				<li style="position:absolute; left:5%;"><a href="requests.php">Requested</a></li>
				<li style="position:absolute; left:20%;"><a href="ToBeReturned.php">To Be Returned</a></li>
				<li style="position:absolute; left:40%;"><a href="Inventory.php">Inventory</a></li>
				<li style="position:absolute; left:55%;"><a href="Records.php">Records</a></li>
				<li style="position:absolute; left:70%;"><a href="Item_update.php">Item Update</a></li>
				<li style="position:absolute; left:90%;"><a href="logout.php">Logout</a></li>
			</ul>

		</div>

<?php

include 'db.php';

$conn = mysqli_connect($host, $user, $pass, $database);
if($conn){
	$sql = "SELECT * FROM `items`";  $count = 0; 
	echo "<p style=\"font-size:20px;\" align=\"center\">Inventory</p>";
	$arr = array();
	$retval=mysqli_query($conn, $sql);
	if($retval != false){
		if(mysqli_num_rows($retval) > 0){
			while($row = mysqli_fetch_assoc($retval)){
				if(!in_array($row['gen_name'], $arr)){ 
					array_push($arr, $row['gen_name']);
				}
			}
		}
	}
	for($i=0; $i < count($arr); $i++){
		echo "<div class=\"floated_block\" style=\"\">";
		echo "<p style=\"font-size:25px; margin-top:10%; margin-left:20%;\">$arr[$i]</p>";
		echo "<a href=\"item_details.php?item_name=$arr[$i]\" style=\"cursor:pointer; font-size:18px; margin:top:40%; margin-left:40%; color:white;\"><u>Types</u></a>";
		echo "</div>";
	}

}

?>	
		
</body>
</html>