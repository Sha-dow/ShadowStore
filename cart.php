<?php
	session_start();
	include 'functions.php';
	print_head("Shopping Cart");

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
		<h1>Shopping cart</h1>
<?php 
	
	if (!isset($_SESSION['cid'])) {
		echo "<p>No items in shopping cart.</p>";
	}

	else {
		print_cart();
	}

	echo "</div></div>"; 
	print_footer();
?>