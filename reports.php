<?php
	session_start();
	include 'functions.php';
	print_head("Reports");
	$role = '';

	if (isset($_SESSION['username'])) {
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}

	if ($role != 'A') {
		header('Location: index.php');
		die();
	}

	unset($_SESSION['sort']);
	$_SESSION['filter'] = 'all';

	print_navigation($role, 'reports');
?>
		
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Reports</h1>
		<h2>This page contains various statistics about shop status.</h2>
	
	
<?php 
	
	//Connect to DB
	$conn = connect_db();
	
	//Amount of users
	$query = "select count(*) as amount from users;";
	$resultset = mysqli_query($conn, $query);

	//If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}
	$data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
	echo "<p>Number of registered users: " . $data['amount'] . "<br/>";


	//Amount of products
	$query = "select count(*) as amount from products;";
	$resultset = mysqli_query($conn, $query);

	//If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}
	$data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
	echo "Number of products available: " . $data['amount'] . "<br/><br/>";

	//Amount of delivered orders
	$query = "select cid from cart where status='ordered';";
	$resultset = mysqli_query($conn, $query);

	//If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}
	echo "Number of completed orders: " . mysqli_num_rows($resultset) . "<br/>";

	$items;
	$ordered = 0;
	$total = 0;

	//Count total sales and total of sold items
	while ($data = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
		$items[] = $data;
	}

	for ($i = 0; $i < count($items); $i++) {
		$query = "select price, amount from cart_items where cid='" . $items[$i]['cid'] . "';";
		$resultset = mysqli_query($conn, $query);

		//If query fails print error and die
		if (!$resultset) {
			echo "FAILURE: Cant retrieve data from database";
			die();
		}

		while ($data = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
			$ordered += $data['amount'];
			$total += ($data['amount'] * $data['price']);
		}
	}
	echo "Total number of items delivered: " . $ordered . "<br/>";
	echo "Total sales: " . number_format($total, 2, '.', '') . "&euro;<br/>";

	if ($ordered == 0) {
		echo "Average item price: " . number_format(0, 2, '.', '') . "&euro;<br/>";
	}
	else {
		echo "Average item price: " . number_format(($total/$ordered), 2, '.', '') . "&euro;<br/>";
	}

	echo "</p></div>";

	mysqli_free_result($resultset);
	
	//Close DB connection
	mysqli_close($conn);

	shopping_cart($firstname, $lastname);
	print_footer();
?>