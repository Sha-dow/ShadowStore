<?php
	session_start();
	include 'functions.php';
	print_head("Users");
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

	print_navigation($role, 'users');
?>
		
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>User listing</h1>
		
	
	
<?php

	//Connect to DB
	$conn = connect_db();

	//Query for selecting users
	$query = "select uid, firstname, lastname, email, phone, address from users;";
	$resultset = mysqli_query($conn, $query);

	//If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}

	//Print table of users
	echo "<table id='ordertable' class='ordertable'><tr>" . PHP_EOL;
	echo "<th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th>" . PHP_EOL;
	$even = false;
	
	while ($data = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
		if ($even) {
			echo "<tr class='even'>" . PHP_EOL;
			$even = false;	
		}
		else {
			echo "<tr>";
			$even = true;	
		}
		
		echo "<td>" . $data['uid'] . "</td>" . PHP_EOL;
		echo "<td>" . $data['firstname'] . " " . $data['lastname'] ."</td>" . PHP_EOL;
		echo "<td>" . $data['email'] . "</td>" . PHP_EOL;
		echo "<td>" . $data['phone'] . "</td>" . PHP_EOL;
		echo "<td>" . $data['address'] . "</td>" . PHP_EOL;
		echo "</tr>";
	}
	echo "</table>" . PHP_EOL;
	echo "</div>"; 

	mysqli_free_result($resultset);

	//Close DB connection
	mysqli_close($conn);
	
	shopping_cart($firstname, $lastname);
	print_footer();
?>