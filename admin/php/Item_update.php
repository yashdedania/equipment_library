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


		<div style="height:10%; width:100%; background:#a7f0ea;">
			<p style="position:absolute; left:30%; font-size:18px; cursor:pointer;" onclick="display_add();"><u>Add Item</u></p>
			<a style="position:absolute; left:60%; font-size:18px; cursor:pointer; top:27%; color:black;" href="Inventory.php"><u>Update Item Details</u></a>
		</div>

		<div style="height:60%; width:100%; display:block" id="add_item">
		<input type="text" placeholder="Item name" id="addin" defaultValue="null" style="position:absolute; top:40%; right:45%;" />
		<input type="text" placeholder="General Name" id="addgn" defaultValue="null" style="position:absolute; top:50%; right:45%;" />
		<input type="number" placeholder="Cost" id="addc" defaultValue=0 min=0 style="position:absolute; top:60%; right:45%;" />
		<input type="number" placeholder="Quantity" id="addq" defaultValue=0 min=0 style="position:absolute; top:70%; right:45%;" />
		<input type="text" placeholder="Mode" id="addm" defaultValue="null" style="position:absolute; top:80%; right:45%;" />
		<p style="position:absolute; top:90%; right:50%;" class="submit" onclick="additem();">ADD ITEM</p>
		</div>

</body>

<script type="text/javascript">

	function display_add(){
		document.getElementById("add_item").style.display="block";
		document.getElementById("update_item").style.display="none";
	}

	function additem(){
		var cost,qty,iname,gname,mode; var update = "add";
		iname = document.getElementById("addin").value;
		gname = document.getElementById("addgn").value; mode = document.getElementById("addm").value;
		cost = document.getElementById("addc").value; qty = document.getElementById("addq").value; 
		$.post("update_item.php", { update: update, iname: iname, gname: gname, cost: cost, qty: qty, mode: mode },
    	function(data) {
	 	alert(data);
    	});
	}
</script>

</html>