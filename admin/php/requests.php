<!DOCTYPE html>
<html>
<head>
	<title>Equipment Library</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
</head>
<script type = "text/javascript" 
         src = "http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
</script>
<body>

	<div class="wrapper">
		
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

		<div class="content">

		<table style="width:100%" cellpadding="12">
				<tr>
					<th style="width:10%">Sr. No.</th>
					<th style="width:20%">PID</th>
					<th style="width:20%">Name</th>
					<th style="width:10%">Class</th>
					<th style="width:20%">Contact</th>
					<th style="width:20%">E-mail</th>
				</tr>

			<?php	
			include 'db.php';

			$conn = mysqli_connect($host, $user, $pass, $database);
			if($conn){
				$sql = "SELECT * FROM `order`"; $count = 0;
    			$retval=mysqli_query($conn, $sql);
    			if($retval != false){
    			if(mysqli_num_rows($retval) > 0){		
					while($row = mysqli_fetch_assoc($retval)){
						if($row['status'] == 'requested'){
						$count++;
						$pid=$row['pid']; $date_taken=$row['date_taken']; $date_return=$row['date_return']; $status=$row['status']; $name=$row['name']; $class=$row['class']; $contact=$row['contact']; $p_key=$row['p_key']; $email = $row['email']; $reason = $row["reason"];

						$item=""; $qty=""; $primary="";
						$sql2 = "SELECT * FROM `orderdetails`";
						$retval2 = mysqli_query($conn, $sql2);
						if(mysqli_num_rows($retval2) > 0){
							while($row2 = mysqli_fetch_assoc($retval2)){
								if($row2['order_id'] == $p_key){
									$item = $item . '%' . $row2['item']; $qty = $qty . '%' . $row2['qty'];
									$primary = $primary . '%' . $row2['p_key'];
								}
							}
						}

						echo "<tr onclick=\"details('".$pid."','".$name."','".$class."','".$contact."','".$item."','".$qty."','".$p_key."',1,'".$reason."');\">
							<td>$count</td>
							<td>$pid</td>
							<td>$name</td>
							<td>$class</td>
							<td>$contact</td>
							<td>$email</td>
						</tr>";
						}
					}
				}
				}
			}else{
					echo "Connection error";
			}
		?>
		</table>


			<div id="myDialog" class="dialog-box">

				<div class="box-content">

					<div class="box-header">
				      <span class="close">&times;</span>
				      <h2>Contact Details</h2>
				      <pre style="font-size:18px; color:black;">Pid : <a id="pid"></a>	Name : <a id="name"></a>	Class : <a id="class"></a>	Contact : <a id="contact"></a><br>Reason: <a id="reason"></a></pre>
				    </div>

				    <div class="box-body" style="height:200px; overflow:scroll;">
				      <table id="table_det" style="width:80%; position:relative; left:10%; text-align:center; margin:20px 0px; border:0px;" cellpadding="0">
				      </table>
				      <p id="approve" style="position:relative; left:50%; font-weight:bold; text-decoration:underline; cursor:pointer; padding:10px; width:5%;">Approve</p>
				      <p id="result" style="position:relative; left:60%;"></p>
				    </div>
			  	</div>
			</div>

		<script src="../js/button_clicks.js"></script>

		</div>
</body>
</html>