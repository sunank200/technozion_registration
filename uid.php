<?php
set_time_limit(900);
$host_name = "localhost";
$db_name = "technqga_registration_13";
$user = "root";
$pass = "gopiKRISHNA";
$link = mysqli_connect($host_name, $user, $pass, $db_name);
$query = "SELECT `registration`, `userid` FROM `userdata`";
$result1 = mysqli_query($link, $query);
$uids = array();
while($row = mysqli_fetch_array($result1, MYSQL_ASSOC)){
	$uids[] = $row;
}


$query2 = "SELECT `registrationids`, `status` FROM `transactions`";
$result2 = mysqli_query($link, $query2);
$count = 0;
while($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
	$uid_arr = json_decode($row['registrationids']);
	if($row['status'] == 5){
		foreach($uid_arr as $uid){
			for($i = 0; $i<count($uids); ++$i){
				if(($uid == $uids[$i]['userid']) && ($uids[$i]['registration'] == 0) ){
					++$count;
				}
			}
		}	
	}
}
echo $count;

?>