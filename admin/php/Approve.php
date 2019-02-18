<?php

$primary = $_REQUEST["primary"]; $approve = $_REQUEST["approve"]; $flag = $_REQUEST["flag"];

if($approve==1){
	$count=0;
	$prim = explode("%",$primary);

	include 'db.php';
	$conn = mysqli_connect($host, $user, $pass, $database);
	if($conn){

				$sql2 = "UPDATE `order` SET `status`='approved' WHERE `p_key`=$primary";
				$result = mysqli_query($conn, $sql2);
				if($result){ 

					$sql3 = "SELECT * FROM `order` WHERE p_key='".$primary."'";
					$retval3 = mysqli_query($conn,$sql3);
					$row3 = mysqli_fetch_array($retval3); $stud_mail=$row3['email']; $stat = $row3["status"];

					$to = $stud_mail ;
   					$subject = "RadLab : Equipment Request Approved";  

   					$message = '<html><body><p>Your Request Has Been Approved. You can now come and collect Equipments.</p></body></html>'; 
   					
   					$header = "From:radlab@sfitengg.org\r\n";  
   					$header .= 'MIME-Version: 1.0' . "\r\n";
   					$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
   					$result = mail ($to,$subject,$message,$header);  

   					if($result){
   						echo "Approve Successfull";
   					}

				}else{
					echo "Approve NOT successfull";
				}
	}else{
		echo "connection error";
	}
}
else{
	
$count=0;
$prim = explode("%",$primary);

include 'db.php';
$conn = mysqli_connect($host, $user, $pass, $database);
if($conn){

				$sql2 = "UPDATE `order` SET `status`='returned' WHERE `p_key`=$primary";
				$result1 = mysqli_query($conn, $sql2);
				$sql2 = "UPDATE `order` SET `date_return`='".date("Y-m-d H:i:s")."' WHERE `p_key`=$primary";
				$result2 = mysqli_query($conn, $sql2);
				$sql2 = "UPDATE `order` SET `flag`='".$flag."' WHERE `p_key`=$primary";
				$result3 = mysqli_query($conn, $sql2);
				if($result1 && $result2 && $result3){ 
					echo "Return Successfull"; 
				}else{
					echo "Return Unsuccessfull"; break;
				}

}else{
	echo "connection error";
}
}

?>