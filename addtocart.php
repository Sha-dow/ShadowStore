<?php
	session_start();
	include 'functions.php';
	
	if (!isset($_SESSION['username'])) {
		header('Location: index.php');	
	}
	
	//Connect to DB
    $conn = connect_db();

    //Find if user has saved shopping cart
	$query = "select cid from cart where uid='" . $_SESSION['uid'] . "' and status='saved';";
	$resultset = mysqli_query($conn, $query);

	//If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}

	//If results are returned save cid to session data
	if (mysqli_num_rows($resultset) > 0) {
		$data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
		$_SESSION['cid'] = $data['cid'];
	}

	//Check if cid is set to session data. If not, create new temporary shopping cart to user
    if (!isset($_SESSION['cid'])) {
    	//create shopping cart to user
		$query = "insert into cart (uid, status) values ('" . $_SESSION['uid'] . "', 'current');";

		//If query fails print error and die
		if (!mysqli_query($conn, $query)) {
			echo "FAILURE: SQL-operation failed";
			die();
		}

		//Find cart id and store it to session data for later use
		$query = "select cid from cart where uid='" . $_SESSION['uid'] . "' and status='current';";
		$resultset = mysqli_query($conn, $query);

		//If query fails print error and die
		if (!$resultset) {
			echo "FAILURE: Cant retrieve data from database";
			die();
		}

		$data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
		$_SESSION['cid'] = $data['cid'];
    }


    //Set characterset before using mysqli_escape_string()
	if (!mysqli_set_charset($conn, 'utf8')) {
		echo "FAILURE: Unable to set the character set";
		die();
	}

    $pid = mysqli_escape_string($conn, $_POST['pid']);
    $cid = mysqli_escape_string($conn, $_SESSION['cid']);

	//Check if item is already in cart
	$query = "select * from cart_items where pid='" . $pid . "' and cid='" . $cid . "';";
	$resultset = mysqli_query($conn, $query);

	//If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}

	//If results are returned save cid to session data
	if (mysqli_num_rows($resultset) > 0) {
		$data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
		$amount = $data['amount'] + 1;
		$query = "update cart_items set amount='" . $amount . "' where pid='" . $pid . "' and cid='" . $cid . "';";

		//If query fails print error and die
		if (!mysqli_query($conn, $query)) {
			echo "FAILURE: SQL-operation failed";
			die();
		}
	}

	//If not found add item to cart
	else {
		//Get productinfo from DB according to pid
	    $query = "select * from products where pid='" . $pid . "';";
	    $resultset = mysqli_query($conn, $query);

		//If query fails print error and die
		if (!$resultset) {
			echo "FAILURE: Cant retrieve data from database";
			die();
		}

		$data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
		$query = "insert into cart_items (cid, pid, price, amount) values ('" . $cid ."', '" . $pid . "', '" . $data['price'] . "', '1');";

		//If query fails print error and die
		if (!mysqli_query($conn, $query)) {
			echo "FAILURE: SQL-operation failed";
			die();
		}
	}
	//Free memory
	mysqli_free_result($resultset);

	//Close DB connection
	mysqli_close($conn);

	//Redirect back to catalog-page
	header('Location: catalog.php');
?>