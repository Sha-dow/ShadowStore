<?php
	session_start();
	include 'functions.php';
	print_head($_GET['header']);

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
	
	echo "<!-- Main container includes two minor containers -->";
	echo "<div id='main-container'>";
	echo "<div id='container'>";
	echo "<h1>" . $_GET['header'] . "</h1>";
	echo "<p>";
	echo $_GET['message'];
	echo "</p>";
	echo "</div>";
	
	shopping_cart($firstname, $lastname);
	print_footer();
?>