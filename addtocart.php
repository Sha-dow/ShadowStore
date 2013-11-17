<?php
	session_start();
	include 'functions.php';
	print_head("Added to cart");

	$role = '';

	if (isset($_SESSION['username'])) {
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}
	else {
		header('Location: index.php');
	}

	print_navigation($role, '');
?>
	
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Following item is now added to your shopping cart:</h1>
		<p>
			<?php echo $_POST['pid']; ?>
		</p>
	</div>
	
<?php 
	shopping_cart($firstname, $lastname, 0, 0);
	print_footer();
?>