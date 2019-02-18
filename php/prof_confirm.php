<?php

$method = $_GET["method"]; $order_id = $_GET["order_id"];

if($method == "confirm"){
	confirm();
}
if($method == "reject"){
	reject();
}
if($method == "view"){
	view();
}


function confirm(){
	
	$sql2 = "UPDATE `order` SET `status`='requested' WHERE `p_key`=$order_id";
	$result = mysqli_query($conn, $sql2);
	if($result){ 
		echo "Requested Approved";
	}else{
		echo "Error Occurred. Requested Not Approved.";
	}

}

function reject(){
	
	$sql2 = "UPDATE `order` SET `status`='rejected' WHERE `p_key`=$order_id";
	$result = mysqli_query($conn, $sql2);
	if($result){ 
		echo "Requested Rejected";
	}else{
		echo "Error Occurred. Requested Not Rejected.";
	}

}

function view(){
	
	$sql = "SELECT * FROM `order` WHERE p_key='".$order_id."'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result); 

	$pid=$row['pid']; $date_taken=$row['date_taken']; $date_return=$row['date_return']; $status=$row['status']; $name=$row['name']; $class=$row['class']; $contact=$row['contact']; $p_key=$row['p_key']; $email = $row['email']; $reason = $row["reason"];

	echo "NAME : $name<br>E-mail : $email<br>";

	$sql2 = "SELECT * FROM `orderdetails` WHERE order_id='".$order_id."'";
	$result2 = mysqli_query($conn, $sql2);
	if(mysqli_num_rows($result2) > 0){
		while($row2 = mysqli_fetch_assoc($result2)){

		}
	}
}

?>