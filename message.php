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
	
	echo "<!-- Main container includes two minor containers -->" . PHP_EOL;
	echo "<div id='main-container'>" . PHP_EOL;
	echo "<div id='container'>" . PHP_EOL;
	echo "<h1>" . $_GET['header'] . "</h1>" . PHP_EOL;
	echo "<p>";
	echo $_GET['message'] . PHP_EOL;
	echo "</p>";
	echo "</div>" . PHP_EOL;
	
	shopping_cart($firstname, $lastname);
	print_footer();
?>