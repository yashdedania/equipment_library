<?php

include 'db.php';

$update = $_REQUEST["update"];
if($update == "add"){
	$iname = $_REQUEST["iname"]; $gname = $_REQUEST["gname"];
	$cost = $_REQUEST["cost"]; $qty = $_REQUEST["qty"]; $mode = $_REQUEST["mode"]; $ok = 1;

	if($iname!="null" && $gname!="null" && $cost!=0 && $qty!=0 && $mode!="null"){
	$conn = mysqli_connect($host, $user, $pass, $database);
	if($conn){

		$sql2 = 'SELECT * FROM `items`'; $retval2 = mysqli_query($conn,$sql2);
		while($row2 = mysqli_fetch_assoc($retval2)){
			if($row2["item"] == $iname && $row2["gen_name"] == $gname){
				$ok = 0; break;
			}
		}

		if($ok == 1){
			$sql = 'INSERT INTO `items`(item,cost,quantity,mode,gen_name) VALUES ("'.$iname.'","'.$cost.'","'.$qty.'","'.$mode.'","'.$gname.'")';
			if(mysqli_query($conn, $sql)){
				echo "Item Added Successfully";
			}else{
				echo "Error Updating database";
			}			
		}else{
			echo "Item in database already";
		}

		mysqli_close($conn);
	}else{
		echo "error connecting to database";
	}
	}else{
		echo "Please enter all details";
	}
}
if($update == "edit"){
	$ename = $_REQUEST["ename"]; $egname = $_REQUEST["egname"];
	$ecost = $_REQUEST["ecost"]; $eqty = $_REQUEST["eqty"]; $emode = $_REQUEST["emode"]; $eid = $_REQUEST["eid"]; $ok = 1;

	$conn = mysqli_connect($host, $user, $pass, $database);
	if($conn){
		$sql1= 'SELECT * FROM `items` WHERE `p_key`="'.$eid.'"'; $result=mysqli_query($conn,$sql1); $row = mysqli_fetch_array($result);
		if($ename != null && $row['item'] != $ename){
			$sql = 'UPDATE `items` SET `item`="'.$ename.'" WHERE `p_key`="'.$eid.'"'; if(!mysqli_query($conn, $sql)){ $ok = 0; }
		}
		if($egname != null && $row['gen_name'] != $egname){
			$sql = 'UPDATE `items` SET `gen_name`="'.$egname.'" WHERE `p_key`="'.$eid.'"'; if(!mysqli_query($conn, $sql)){ $ok = 0; }
		}
		if($emode != null && $row['mode'] != $emode){
			$sql = 'UPDATE `items` SET `mode`="'.$emode.'" WHERE `p_key`="'.$eid.'"'; if(!mysqli_query($conn, $sql)){ $ok = 0; }
		}
		if($row['cost'] != $ecost){
			$sql = 'UPDATE `items` SET `cost`="'.$ecost.'" WHERE `p_key`="'.$eid.'"'; if(!mysqli_query($conn, $sql)){ $ok = 0; }		
		}
		if($row['quantity'] != $eqty){
			$sql = 'UPDATE `items` SET `quantity`="'.$eqty.'" WHERE `p_key`="'.$eid.'"'; if(!mysqli_query($conn, $sql)){ $ok = 0; }
		}

		if($ok == 1){
			echo "Item Details Edited Successfully";
		}else{
			echo "Error Updating Item Details".$conn->error;;
		}
		mysqli_close($conn);
	}else{
		echo "error connecting to database";
	}
}
if($update == "lost"){
	$lname = $_REQUEST["lname"]; $lpid = $_REQUEST["lpid"];
	$lreason = $_REQUEST["lreason"]; $lqty = $_REQUEST["lqty"]; $lcost = $_REQUEST["lcost"]; $lid = $_REQUEST["lid"]; $iname = $_REQUEST["iname"];

	if($lname!=null && $lpid!=0 && $lreason!=null && $lqty!=0){
	$conn = mysqli_connect($host, $user, $pass, $database);
	if($conn){
		$sql = 'INSERT INTO `loss` (`pid`,`name`,`reason`,`cost`,`item`,`qty`) VALUES ("'.$lpid.'","'.$lname.'","'.$lreason.'","'.$lcost.'","'.$iname.'","'.$lqty.'")';
		if(mysqli_query($conn, $sql)){
			echo "Loss Recorded Successfully";
		}else{
			echo "Error Inserting Record";
		}
		mysqli_close($conn);
	}else{
		echo "error connecting to database";
	}
	}else{
		echo "Please enter all details";
	}
}
if($update == "delete"){
	$did = $_REQUEST["did"];

	$conn = mysqli_connect($host, $user, $pass, $database);
	if($conn){
		$sql = 'DELETE FROM `items` WHERE `p_key`="'.$did.'"';
		if(mysqli_query($conn, $sql)){
			echo "Item Deleted Successfully";
		}else{
			echo "Error deleting Item";
		}
		mysqli_close($conn);
	}else{
		echo "error connecting to database";
	}
}


?>