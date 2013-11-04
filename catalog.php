<?php
	session_start();
	include 'functions.php';
	print_head("Catalog");
	$role = '';

	if (isset($_SESSION['username'])) {

		$username = $_SESSION['username'];
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$email = $_SESSION['email'];
		$phone = $_SESSION['phone'];
		$address = $_SESSION['address'];
		$role = $_SESSION['role'];	
	}

	print_navigation($role, 'catalog');
?>
		
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Products catalog</h1>
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