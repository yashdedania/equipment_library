<?php

$html_ip = file_get_contents("http://sfitengg.org/library_app/sfitapp_ip.php");

$html = explode("_@_0",$html_ip);

/*------------------------------------------------------*/


$prof_query_link = "http://" . $html[0] . "/sms/rnd_equip_staff_list.asp";

$html = file_get_contents($prof_query_link);

$prof_email = explode("@_@", $html);

/*------------------------------------------------------*/

for($i = 0; $i < count($prof_email); $i++){

	$prof_email2 = explode("_",$prof_email[$i]); 
	$temp1 = $prof_email2[2]; 
	$temp2 = ucwords(trim(strtolower($prof_email2[0])));
	echo "<option value=\"$temp1\">Prof. $temp2</option>";

}

?>

