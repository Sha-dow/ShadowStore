<?php
	session_start();
	include 'functions.php';
	print_head("Index");
	$role = '';

	if (isset($_SESSION['username'])) {
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}

	unset($_SESSION['sort']);
	$_SESSION['filter'] = 'all';

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
		shopping_cart($firstname, $lastname, 0, 0);
	}
	else {
		login_form(true);
	}
	
	print_footer();
?>