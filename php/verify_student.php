<?php

$c = $_REQUEST["c"];

if($c == 1){
	login();
}
if($c == 2){
	change_pass();
}

function login(){
	$stud_pid = addslashes($_REQUEST["stud_pid"]); 
	$stud_pass = addslashes($_REQUEST["stud_pass"]); 
	$ok = 0;

	include 'db.php';
	$mysqli = new mysqli($host, $user, $pass, $database);
	if(mysqli_connect_errno()){
		die("Connection Failed".mysqli_connect_error());
	}else{
		if ($stmt = $mysqli->prepare("SELECT uid FROM `users` WHERE pid=? AND password=?")) {
			$stmt->bind_param("ss", $stud_pid , $stud_pass);
			$stmt->execute();
			
			//$result = $stmt->get_result();			
			//while ($row = $result->fetch_assoc()) {
			//	$uid = $row["uid"]; $ok = 1; break;
			//}
			
			$stmt->bind_result($uid);
			$stmt->fetch();
			$stmt->store_result();
			
			if(!$uid){
				echo "No Such User Found";
			}else{
				session_start();
				$_SESSION["logpid"] = $stud_pid;
				//echo "Login Successfull";
			}
			$stmt->close();
		}
  		$mysqli->close();
	}
	
	/*$get_ip = file_get_contents("http://sfitengg.org/library_app/sfitapp_ip.php");
	
	$get_ip = explode("_@_",$get_ip);

	$response = file_get_contents("http://" . $get_ip[0] . "/sms/radiusauth.php?uname=" . $stud_pid . "&upass=" . $stud_pass); //INSERT STUDENT LOGIN URL HERE
	//$response = file_get_contents("http://115.248.171.105:8007/sms/radiusauth.php?uname=122126&upass=SU_1994");	
	//$ch = curl_init();
	//curl_setopt($ch, CURLOPT_URL, "http://" . $get_ip[0] . "/sms/radiusauth.php?uname=" . $stud_pid . "&upass=" . $stud_pass);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
	// This is what solved the issue (Accepting gzip encoding)
	//curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
	//$response = curl_exec($ch);
	//curl_close($ch);
	//echo $response;

	if($response == "1"){

		session_start();
		$_SESSION["logpid"] = $stud_pid;
		//echo $response;
	
	}else{
		//echo $response;
		echo "";//"http://" . $get_ip[0] . "/sms/radiusauth.php?uname=" . $stud_pid . "&upass=" . $stud_pass . "response: " . $response;
		//echo "Invalid Credentials";
	}*/

}

function change_pass(){
	$uname = $_REQUEST["uname"]; $pass_old = $_REQUEST["pass_old"]; $pass_new = $_REQUEST["pass_new"];

	include 'db.php';
	$mysqli = new mysqli($host, $user, $pass, $database);
	if(mysqli_connect_errno()){
		die("Connection Failed".mysqli_connect_error());
	}else{
		if ($stmt = $mysqli->prepare("SELECT * FROM `users` WHERE username=? AND password=?")) {
			$stmt->bind_param("ss", $uname , $pass_old);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) { 
				$uid = $row["uid"]; $ok = 1;
				break;
			}
			//$stmt->bind_result($uid);
			//$stmt->fetch();
			//$stmt->store_result();
			$stmt->close();
			if($ok == 0){
				echo "No Such User Found";
			}else{
				if ($stmt = $mysqli->prepare("UPDATE `users` SET password = ? WHERE uid = ?")) {
					$stmt->bind_param("sd", $pass_new, $uid);
					$stmt->execute();
					$stmt->close();
					echo "PassWord Updated Successfully";
				}
			}
		}
  		$mysqli->close();
	}
}

?>