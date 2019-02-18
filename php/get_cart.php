<?php

$c = $_REQUEST["c"];

include 'db.php';

if($c == 1){
	show_cart();
}
if($c == 2){
	addtocart();
}
if($c == 3){
	removecart();
}
if($c == 4){
	shownotifications();
}


function show_cart(){
	session_start();
	$logpid = $_SESSION["logpid"];
	//$logpid = 142987;

	include 'db.php';
	$conn = mysqli_connect($host, $user, $pass, $database);

	if($conn){
		$items = array(); $count = 1;
		$sql = 'SELECT * FROM `cart` WHERE pid="'.$logpid.'"';
		if(mysqli_query($conn, $sql)){
			$retval=mysqli_query($conn, $sql);
			if(mysqli_num_rows($retval) > 0){
				while($row = mysqli_fetch_assoc($retval)){
					$item_id = $row['items_id']; $qty = $row['qty'];

					$sql2 = 'SELECT * FROM `items` WHERE p_key="'.$item_id.'"';
					$retval2 = mysqli_query($conn, $sql2); 
					$row2 = mysqli_fetch_array($retval2);

					$item = $row2['item']; $cost = $row2['cost'];
					$mode = $row2['mode']; $gen_name = $row2['gen_name'];

					echo "<div class=\"cart_item\" id=$item_id>";
					echo "<p style=\"position:absolute; right:1%; bottom:0; cursor:pointer;\" onclick=\"remove_cart('".$item_id."')\"><b>X</b></p>";
					echo "<p class=\"cart_item_name\">$count . $item $gen_name - ( $qty )</p>";
					echo "</div>";

					$count++;
				}
			}
		}
	}
}

function addtocart(){
	session_start();
	$logpid = $_SESSION["logpid"]; $ok = 1;

	$fitemid = $_REQUEST["fitemid"]; $fitemqty = $_REQUEST["fitemqty"];

	include 'db.php';
	$conn = mysqli_connect($host, $user, $pass, $database);

	if($conn){

		$sql = 'SELECT * FROM `cart`';
		if(mysqli_query($conn,$sql)){
			$retval = mysqli_query($conn,$sql);
			if(mysqli_num_rows($retval) > 0){
				while($row = mysqli_fetch_assoc($retval)){
					if($row["pid"] == $logpid && $row["items_id"] == $fitemid){
						$sql2 = 'UPDATE `cart` SET qty="'.$fitemqty.'"'; 
						mysqli_query($conn,$sql2);
						mysqli_commit($conn);
						$ok = 0;
						echo "success"; 
						break;
					}
				}
			}
		}

		if($ok == 1){
			$sql = 'INSERT INTO `cart`(pid,items_id,qty) VALUES("'.$logpid.'","'.$fitemid.'","'.$fitemqty.'")';
			mysqli_query($conn, $sql);
			if(mysqli_commit($conn)){
				echo "success";
			}else{
				//echo "ERROR";
			}
		}
		mysqli_close($conn);
	}
}

function removecart(){
	session_start();
	$logpid = $_SESSION["logpid"]; $ok = 1;

	$fitemid = $_REQUEST["item_id"];

	include 'db.php';
	$conn = mysqli_connect($host, $user, $pass, $database);

	if($conn){

		$sql = 'DELETE FROM `cart` WHERE pid="'.$logpid.'" AND items_id="'.$fitemid.'"';
		if(mysqli_query($conn,$sql)){
			mysqli_commit($conn);
			echo "success";
		}

	}
}

function shownotifications(){
	session_start();
	$logpid = $_SESSION["logpid"]; $ok = 1;

	include 'db.php';
	$conn = mysqli_connect($host, $user, $pass, $database);

	echo "<span class=\"close\" style=\"font-weight: bold; float:right; font-size:25px; cursor:pointer;\" onclick=\"diagnotify.style.display = 'none';\">&times;</span>";
	echo "<table><tr><th style=\"width:10%\">Sr. No.</th><th style=\"width:60%\">Details</th>
	<th style=\"width:20%\">Date taken</th><th style=\"width:20%\">Status</th></tr><tr></tr>";

	if($conn){

				$sql = "SELECT * FROM `order` ORDER BY date_taken desc"; $count = 0;
    			$retval=mysqli_query($conn, $sql);
    			if($retval != false){
    			if(mysqli_num_rows($retval) > 0){		
					while($row = mysqli_fetch_assoc($retval)){
						if($row['pid'] == $logpid){
						$count++;
						$pid=$row['pid']; $date_taken=$row['date_taken']; $date_return=$row['date_return']; $status=$row['status']; $name=$row['name']; $class=$row['class']; $contact=$row['contact']; $p_key=$row['p_key']; $email = $row['email']; $reason = $row["reason"];

						if($status == "active"){$status = "professor approval pending";}
						if($status == "requested"){$status = "radlab approval pending";}

						echo "<tr>
							<td>$count</td>
							<td>";

						$sql2 = "SELECT * FROM `orderdetails`";
						$retval2 = mysqli_query($conn, $sql2);
						if(mysqli_num_rows($retval2) > 0){
							while($row2 = mysqli_fetch_assoc($retval2)){
								if($row2['order_id'] == $p_key){
									$iname = $row2['item']; $iqty = $row2['qty'];
									echo "$iname ($iqty)<br>";
								}
							}
						}

						echo "</td>
							<td>$date_taken</td>
							<td>$status</td>
						</tr>";

						}
					}
				}
				}

	}

	echo "</table>";
}

?>