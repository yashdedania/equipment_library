<?php

$c = $_REQUEST["c"];
include 'db.php';
if($c == 1){
	login();
}
if($c == 2){
	change_pass();
}

function login(){
	$adm_username = $_REQUEST["adm_username"]; 
	$adm_password = $_REQUEST["adm_password"]; 
	$ok = 0;
	
	//$uname=mysqli_real_escape_string($conn, $_POST["uname"]);
	//$pass=mysqli_real_escape_string($conn, $_POST["pass"]); 

	include 'db.php';
	$mysqli = new mysqli($host, $user, $pass, $database);
	if(mysqli_connect_errno()){
		die("Connection Failed".mysqli_connect_error());
		echo "Failed";
	}else{
		if ($stmt = $mysqli->prepare("SELECT uid FROM `users` WHERE username=? AND password=?")) {
			$stmt->bind_param("ss", $adm_username , $adm_password);
			$stmt->execute();
			
			//$result = $stmt->get_result();			
			/*while ($row = $result->fetch_assoc()) {
				$uid = $row["uid"]; $ok = 1; break;
			}*/
			
			$stmt->bind_result($uid);
			$stmt->fetch();
			$stmt->store_result();
			
			if(!$uid){
				echo "No Such User Found";
			}else{
				session_start();
				$_SESSION["loguid"] = $uid;
				//echo "Login Successfull";
			}
			$stmt->close();
		}
  		$mysqli->close();
	}

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