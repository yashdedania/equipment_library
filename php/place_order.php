<?php

session_start();

$logpid = $_SESSION["logpid"];

$po_name = $_REQUEST["po_name"]; $po_class = $_REQUEST["po_class"];
$po_contact = $_REQUEST["po_contact"]; $po_email = $_REQUEST["po_email"]; $po_desp = $_REQUEST["po_desp"];

$prof_email = $_REQUEST["prof_email"]; $prof_email = strtolower($prof_email); 

$status = "requested"; $equipments = "";

$byperson = "Name : ".$po_name."<br>Class : ".$po_class."<br>Contact : ".$po_contact."<br>E-mail".$po_email."<br>Reason :".$po_desp; 

include 'db.php';

$conn = mysqli_connect($host, $user, $pass, $database);
if($conn){
	
	$sql2 = 'INSERT INTO `order`(pid,date_taken,status,name,class,contact,reason,email,prof_email) VALUES ("'.$logpid.'","'.date("Y-m-d H:i:s").'","active","'.$po_name.'","'.$po_class.'","'.$po_contact.'","'.$po_desp.'","'.$po_email.'","'.$prof_email.'")';
	if(mysqli_query($conn, $sql2)){
		$last_id = mysqli_insert_id($conn);
	
		$sql = 'SELECT * FROM `cart` WHERE pid="'.$logpid.'"'; $ok = 1;
		if(mysqli_query($conn, $sql)){
			$retval = mysqli_query($conn, $sql);
			if(mysqli_num_rows($retval) > 0){
				while($row = mysqli_fetch_assoc($retval)){
					$item_id = $row["items_id"]; $item_qty = $row["qty"];

					$sql1 = 'SELECT * FROM `items` WHERE p_key="'.$item_id.'"';
					$retval1 = mysqli_query($conn, $sql1);
					$row1 = mysqli_fetch_array($retval1);
					$item_name = $row1["item"]; $item_gen_name = $row1["gen_name"];
					//$item_name = $item_name . " " . $item_gen_name;
					
						$sql3 = 'INSERT INTO `orderdetails`(item,item_id,qty,order_id) VALUES ("'.$item_name.'","'.$item_id.'""'.$item_qty.'","'.$last_id.'")';
						if(mysqli_query($conn, $sql3)){
							$equipments = $equipments . "<br>" . $item_name . " " . $item_gen_name . "(".$item_qty.")" ;
						}
						else{
							$ok = 0; break;
						} 
				}
			}

			if($ok == 1){
				$sql4 = 'DELETE FROM `cart` WHERE pid="'.$logpid.'"';
				if(mysqli_query($conn,$sql4)){
	
					//ini_set("SMTP","aspmx.l.google.com"); // mail server domain
					//ini_set("smtp_port","25");
					//ini_set("auth_username","radlab@sfitengg.org");
					//ini_set("auth_password","pass");
					//ini_set("sendmail_from","radlab@sfitengg.org");

					$to = $prof_email ; 
   					$subject = "SFIT RadLab Equipment Library : Confirmation";  

   					$message = '<html><body>
   						<p>Please click on this link to confirm the order</p><br>
   							<a href="http://localhost/equipnew/php/prof_confirm.php?order_id="'.$last_id.'"&method="confirm">Accept</a><br>
   							<a href="http://localhost/equipnew/php/prof_confirm.php?order_id="'.$last_id.'"&method="reject">Reject</a><br>
   							<br><br>Equipments Requested : "'.$equipments.'"<br><br>By : <br>"'.$byperson.'"</body></html>'; 
   					
   					$header = "From:radlab@sfitengg.org\r\n";  
   					$header .= 'MIME-Version: 1.0' . "\r\n";
   					$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
   					$result = mail ($to,$subject,$message,$header);  

   					if($result){
   						echo "success";
   					}else{

   					}
				}
			}
		}
	}

}

?>