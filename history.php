<?php
	session_start();
	include 'functions.php';
	print_head("Order History");
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

	print_navigation($role, 'history');
		
	echo "<!-- Main container includes two minor containers -->" . PHP_EOL;
	echo "<div id='main-container'>" . PHP_EOL;
	echo "<div id='container'>" . PHP_EOL;
	echo "<h1>Order history</h1>" . PHP_EOL;
	
	//Connect to DB
	$conn = connect_db();

	$query = "select * from cart where uid='" . $_SESSION['uid'] . "';";
	$resultset = mysqli_query($conn, $query);

	//If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}

	//If orders were found...
	if (mysqli_num_rows($resultset) > 0) {

		//Get through fecthed data and collect to array
		while ($data = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
			$orders[] = $data;
		}

		//Print order information
		for ($i = 0; $i < count($orders); $i++) {
			echo "<p><b>Order ID:</b> " . $orders[$i]['cid'] . "<br/>" . PHP_EOL;
			echo "<b>Ordered:</b> " . $orders[$i]['orderdate'] . "<br/>" . PHP_EOL;
			echo "<b>Status:</b> " . $orders[$i]['status'] . "<br/>" . PHP_EOL;
			echo "<b>Delivery address:</b> " . $orders[$i]['deladdress'] . "<br/></p>" . PHP_EOL;
			print_ordercontent($orders[$i]['cid']);
		}
	}
	//If there was no orders show message
	else {
		echo "<p>You have not ordered anything so far.</p>";
	}

	echo "</div>";

	//Free memory and close DB connection
	mysqli_free_result($resultset);
	mysqli_close($conn);
	 
	shopping_cart($firstname, $lastname);
	print_footer();
?>