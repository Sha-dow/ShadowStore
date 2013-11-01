<?php
	session_start();

	//If user is logged in...
	if (isset($_SESSION['username'])) {

		//...destroy all session variables and session
		$_SESSION = array(); 
    	session_destroy();
	} 

	//Redirect to first page
    header('Location: index.php');
?>