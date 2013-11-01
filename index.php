<?php
	session_start();
	include 'functions.php';
	print_head("Index");
	$role = '';

	if (isset($_SESSION['username'])) {

		$username = $_SESSION['username'];
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}

	print_navigation($role, 'index');
?>
	
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Welcome</h1>
		<p>
			Contents here...
		</p>
	</div>
	
<?php

	if (isset($_SESSION['username'])) {
		shopping_cart($firstname);
	}
	else {
		login_form(true);
	}
	
	print_footer();
?>