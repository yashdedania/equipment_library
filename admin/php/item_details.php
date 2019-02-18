<!DOCTYPE html>
<html>
<head>
	<title>Equipment Library</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
</head>

<script type = "text/javascript" src = "http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

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

$item_name = $_GET["item_name"];

include 'db.php';

$conn = mysqli_connect($host, $user, $pass, $database);
if($conn){
	$sql = "SELECT * FROM `items`";  $count = 0; 
	echo "<p style=\"font-size:20px;\" align=\"center\">$item_name</p>";
	$arr = array();
	$retval=mysqli_query($conn, $sql);
	if($retval != false){
		if(mysqli_num_rows($retval) > 0){
			while($row = mysqli_fetch_assoc($retval)){
				if($row['gen_name'] == $item_name){
					$item = $row['item']; $cost = $row['cost']; $quantity = $row['quantity']; $mode = $row['mode']; $id=$row['p_key'];

					$sql2 = "SELECT SUM(qty) AS qty FROM `orderdetails` WHERE `item`='".$item."'";
					$result2=mysqli_query($conn,$sql2); $row2 = mysqli_fetch_assoc($result2); $ordered=$row2['qty'];
					$avail = $quantity - $ordered;
					$sql2 = "SELECT SUM(qty) AS qty FROM `loss` WHERE `item`='".$item."'";
					$result2=mysqli_query($conn,$sql2); $row2 = mysqli_fetch_assoc($result2); $lost=$row2['qty'];
					$avail = $avail - $lost;

					echo "<div class=\"floated_block_item\" style=\"position:relative;\">";
					echo "<p onclick=\"edititemshow($id,'".$item."','".$item_name."',$cost,$quantity,'".$mode."');\" style=\"cursor:pointer; color:blue; position:absolute; bottom:0%; left:10%;\"><u>EDIT</u></p>";
					echo "<p style=\"font-size:18px; position:absolute; top:0%; left:10%;\"><b>$item</b></p>";
					echo "<p style=\"font-size:16px; position:absolute; top:20%; left:10%;\">Cost : $cost</p>";
					echo "<p style=\"font-size:17px; position:absolute; top:50%; left:10%;\">Availability : $avail / $quantity</p>";
					echo "<p style=\"font-size:16px; position:absolute; top:35%; left:10%;\">Mode : $mode</p>";
					echo "</div>";
				}
			}
		}
	}

}

?>


<div id="myDialog" class="dialog-box">

	<div class="box-content">

		<div class="box-header">
	      <span class="close">&times;</span>
	      <h2>Update Item Details</h2>
	      <p onclick="editp();" style="position:absolute; top:0; right:30%; cursor:pointer; color:black;"><u>Edit</u></p> 
	      <p onclick="lostp();" style="position:absolute; top:0; right:20%; cursor:pointer; color:black;"><u>Lost</u></p>
	      <p onclick="deletep();" style="position:absolute; top:0; right:10%; cursor:pointer; color:black;"><u>Delete</u></p>
	    </div>
	    <div class="box-body" style="height:200px; overflow:scroll;">
	    	<div style="width:100%; display:none;" id="editi">
	    		<pre style="font-size:18px; color:black;">Name : <input id="iname" type="text"/>	General Name : <input id="igname" type="text"/>	Mode : <input type="text" id="imode"/><br><br>Cost : <input id="icost" type="number"/>	Quantity : <input type="number" id="iqty"/></pre><br>
	    		<p id="submitedit" style="cursor:pointer; font-weight:bold;" onclick="submitedit();"><u>Submit</u></p>
	    	</div>
	    	<div style="display:none; width:100%;" id="losti">
	    		<pre style="font-size:18px; color:black;">Name : <input id="lname" type="text" defaultValue="null"/>	PID: <input id="lpid" type="number" defaultValue=0 min=0/>	Quantity : <input id="lqty" type="number" defaultValue=0 min=0/><br><br>Reason : <input type="text" id="lreason" defaultValue="null" style="width:50%;" /></pre><br>
	    		<p id="submitlost" style="cursor:pointer; font-weight:bold;" onclick="submitlost();"><u>Submit</u></p>
	    	</div>
	    	<div style="display:none; width:100%;" id="deletei">
	    		<p> Delete this item completely ? </p>
	    		<p id="submitdelete" style="cursor:pointer; color:red;" onclick="submitdelete();"><u>DELETE</u></p>
	    	</div>
	    	<div style="text-align:center;"><p id="result" style="font-weight:bold;"></p></div>
	    </div>
  	</div>
</div>	
		
</body>

<script type="text/javascript">
	var modal = document.getElementById('myDialog');
	var iid,icost; var update, item_name;
	function edititemshow(id,name,gname,cost,qty,mode){
		iid=id; icost=cost; item_name = name;
		modal.style.display="block"; 
		document.getElementById("iname").placeholder = name; document.getElementById("igname").placeholder = gname;
		document.getElementById("icost").value = cost;
		document.getElementById("iqty").value = qty; document.getElementById("iqty").min = qty; 
		document.getElementById("imode").placeholder = mode;
	}
	window.onclick = function(event) {
    	if (event.target == modal) {
    		modal.style.display="none";
    	}
	}
	span.onclick = function() {
    	modal.style.display = "none"; 
	}

	function editp() {
		document.getElementById("editi").style.display="block"; document.getElementById("losti").style.display="none"; document.getElementById("deletei").style.display="none"; document.getElementById("result").style.display="none";
	}
	function lostp() {
		document.getElementById("editi").style.display="none"; document.getElementById("losti").style.display="block"; document.getElementById("deletei").style.display="none"; document.getElementById("result").style.display="none";
	}
	function deletep() {
		document.getElementById("editi").style.display="none"; document.getElementById("losti").style.display="none"; document.getElementById("deletei").style.display="block"; document.getElementById("result").style.display="none";
	}

	function submitedit(){
		update = "edit";
		var en=document.getElementById("iname").value; var egn=document.getElementById("igname").value;
		var ec=document.getElementById("icost").value; var eq=document.getElementById("iqty").value;
		var em=document.getElementById("imode").value;
		$.post("update_item.php", { update: update, eid: iid, ename: en, egname: egn, ecost: ec, eqty: eq, emode: em },
    	function(data) {
    		document.getElementById("result").style.display="block";
	 	$('#result').html(data);
    	});	
	}

	function submitlost(){
		update = "lost";
		var ln=document.getElementById("lname").value; var lp=document.getElementById("lpid").value;
		var lr=document.getElementById("lreason").value; var lq=document.getElementById("lqty").value;
		$.post("update_item.php", { update: update, lid: iid, lname: ln, lpid: lp, lreason: lr, lqty: lq, lcost: icost, iname: item_name },
    	function(data) {
    		document.getElementById("result").style.display="block";
	 	$('#result').html(data);
    	});	
	}
	function submitdelete(){
		update = "delete";
		$.post("update_item.php", { update: update, did: iid },
    	function(data) {
    		document.getElementById("result").style.display="block";
	 	$('#result').html(data);
    	});	
	}
</script>
</html>