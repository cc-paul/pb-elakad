<?php
	include dirname(__FILE__,2) . '/config.php';
	include $main_location . '/connection/conn.php';

	if(!isset($_SESSION)) { session_start(); } 

	$username = $_POST["username"];
	$password = $_POST["password"];

	$sql      = "
		SELECT
			a.id,
			CONCAT( a.firstName, ' ', a.middleName, ' ', a.lastName ) AS fullName,
			a.username,
			DATE_FORMAT( a.dateCreated, '%m/%d/%Y' ) AS member_since,
			a.isPasswordChange
		FROM
			el_user_registration a
		WHERE
			a.username = '$username' 
		AND 
			a.`password` = MD5( '$password' )
		AND 
			a.isActive = 1
	";
	
	$result   = mysqli_query($con,$sql);
	$count    = mysqli_num_rows($result);


	if ($count != 0) {
		while ($row = mysqli_fetch_row($result)) {
			$_SESSION['id']               = $row[0];
			$_SESSION['fullName']         = $row[1];
			$_SESSION['username']         = $row[2];
			$_SESSION['date_created']     = $row[3];
			$_SESSION['isPasswordChange'] = $row[4];
		}

		echo 1;
	} else {
		echo 0;
	}
	
	mysqli_close($con);
?>