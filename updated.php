<?php
	session_start();
	include 'functions.php';
	print_head("Updated");

	$role = '';

	if (isset($_SESSION['username'])) {
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}
	else {
		header('Location: index.php');
	}

	unset($_SESSION['sort']);
	$_SESSION['filter'] = 'all';

	print_navigation($role, '');
?>
	
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>User information updated successfully.</h1>
		<p>
			Please continue shopping.
		</p>
	</div>
	
<?php 
	shopping_cart($firstname, $lastname, 0, 0);
	print_footer();
?>