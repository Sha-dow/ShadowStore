<?php
	session_start();
	include 'functions.php';

	//If user is logged in...
	if (isset($_SESSION['username'])) {

		//Connect to DB
    	$conn = connect_db();

    	//Delete current shopping cart
    	$query = "delete from cart where uid='" . $_SESSION['uid'] . "' and status='current';";

    	//If query fails print error and die
		if (!mysqli_query($conn, $query)) {
			echo "FAILURE: SQL-operation failed";
			die();
		}

		//...destroy all session variables and session
		$_SESSION = array(); 
    	session_destroy();
	} 

	//Redirect to first page
    header('Location: index.php');
?>