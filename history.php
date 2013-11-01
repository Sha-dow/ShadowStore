<?php
	session_start();
	include 'functions.php';
	print_head("Order History");
	$role = '';

	if (isset($_SESSION['username'])) {

		$username = $_SESSION['username'];
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}
	else {
		header('Location: index.php');
	}

	print_navigation($role, 'history');
?>
		
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Order history</h1>
		<p>
			Contents here...
		</p>
	</div>
	
<?php 
	shopping_cart($firstname);
	print_footer();
?>