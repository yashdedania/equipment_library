<?php

$c = $_REQUEST["c"]; 

if($c == 1){
	get_item_list();
}
if($c == 2){
	get_item_det();
}

function get_item_list(){
	include 'db.php'; $gen_all = "all";

	echo "<p class=\"menu_item_temp\">INVENTORY</p>"; 
	echo "<p class=\"menu_item\" onclick=\"itemdet('".$gen_all."')\">ALL</p>";

$conn = mysqli_connect($host, $user, $pass, $database);
if($conn){
	$sql = "SELECT * FROM `items`";  $count = 0; 
	//echo "<p style=\"font-size:20px;\" align=\"center\">Inventory</p>";
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
		echo "<p class=\"menu_item\" onclick=\"itemdet('".$arr[$i]."')\">$arr[$i]</p>";
	}

}

}

function get_item_det(){
	$item_gen_name = $_REQUEST["item_gen_name"];

include 'db.php';

$conn = mysqli_connect($host, $user, $pass, $database);
if($conn){
	$sql = "SELECT * FROM `items`";  $count = 0; $temp1 = strtoupper($item_gen_name);
	echo "<p style=\"font-size:20px;\" align=\"center\">$temp1</p>";
	$arr = array();
	$retval=mysqli_query($conn, $sql);
	if($retval != false){
		if(mysqli_num_rows($retval) > 0){
			while($row = mysqli_fetch_assoc($retval)){
				if($item_gen_name == "all"){
					$item = $row['item']; $cost = $row['cost']; $quantity = $row['quantity']; $mode = $row['mode']; $id=$row['p_key'];
					$temp_gen_name = $row['gen_name'];

					$sql2 = "SELECT SUM(qty) AS qty FROM `orderdetails` WHERE `item`='".$item."'";
					$result2=mysqli_query($conn,$sql2); $row2 = mysqli_fetch_assoc($result2); $ordered=$row2['qty'];
					$avail = $quantity - $ordered;
					$sql2 = "SELECT SUM(qty) AS qty FROM `loss` WHERE `item`='".$item."'";
					$result2=mysqli_query($conn,$sql2); $row2 = mysqli_fetch_assoc($result2); $lost=$row2['qty'];
					$avail = $avail - $lost;

					echo "<div class=\"floated_block_item\" style=\"position:relative;\">";
					echo "<p onclick=\"askqty($id);\" style=\"cursor:pointer; color:blue; position:absolute; bottom:0%; left:10%; color:#042D55\"><u><b>Add to Cart</u></b></p>";
					echo "<div id=\"iname\"><p style=\"font-size:18px; position:absolute; top:0%; left:10%;\"><b>$item $temp_gen_name</b></p></div>";
					echo "<p style=\"font-size:16px; position:absolute; top:40%; left:10%;\">Cost : $cost</p>";
					echo "<p style=\"font-size:17px; position:absolute; top:60%; left:10%;\">Availability : $avail / $quantity</p>";
					//echo "<p style=\"font-size:16px; position:absolute; top:35%; left:50%;\">Mode : $mode</p>";
					echo "</div>";				
				}
				else if($row['gen_name'] == $item_gen_name){
					$item = $row['item']; $cost = $row['cost']; $quantity = $row['quantity']; $mode = $row['mode']; $id=$row['p_key'];

					$sql2 = "SELECT SUM(qty) AS qty FROM `orderdetails` WHERE `item`='".$item."'";
					$result2=mysqli_query($conn,$sql2); $row2 = mysqli_fetch_assoc($result2); $ordered=$row2['qty'];
					$avail = $quantity - $ordered;
					$sql2 = "SELECT SUM(qty) AS qty FROM `loss` WHERE `item`='".$item."'";
					$result2=mysqli_query($conn,$sql2); $row2 = mysqli_fetch_assoc($result2); $lost=$row2['qty'];
					$avail = $avail - $lost;

					echo "<div class=\"floated_block_item\" style=\"position:relative;\">";
					echo "<p onclick=\"askqty($id);\" style=\"cursor:pointer; color:blue; position:absolute; bottom:0%; left:10%; color:#042D55\"><u><b>Add to Cart</b></u></p>";
					echo "<div id=\"iname\"><p style=\"font-size:18px; position:absolute; top:0%; left:10%;\"><b>$item</b></p></div>";
					echo "<p style=\"font-size:16px; position:absolute; top:40%; left:10%;\">Cost : $cost</p>";
					echo "<p style=\"font-size:17px; position:absolute; top:60%; left:10%;\">Availability : $avail / $quantity</p>";
					//echo "<p style=\"font-size:16px; position:absolute; top:35%; left:50%;\">Mode : $mode</p>";
					echo "</div>";
				}
			}
		}
	}

}

}

?>