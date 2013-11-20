<?php
	session_start();
	include 'functions.php';
	print_head("Cart saved");

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
		<h1>Shopping cart saved successfully.</h1>
		<p>
			Your shopping cart is now saved and will be retrieved when you log in next time. </br>
			All changes you will made during this session will be taken into account and your cart will </br>
			return to state where it was before logout. 
		</p>
	</div>
	
<?php 
	shopping_cart($firstname, $lastname);
	print_footer();
?>