<?php
	session_start();
	include 'functions.php';
	print_head("Contact");
	$role = '';

	if (isset($_SESSION['username'])) {

		$username = $_SESSION['username'];
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}

	print_navigation($role, 'contact');
?>
		
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Contact information</h1>
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