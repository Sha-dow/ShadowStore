<?php
	session_start();
	include 'functions.php';
	
	if (!isset($_SESSION['username'])) {
		header('Location: index.php');	
	}

	//Catch submit-action and act according to value 
	if (isset($_POST['submit'])) {
		//If 'register':
		if ($_POST['submit'] == 'Update cart') {
			//TODO: ADD FUCTIONALITY
		}
		else if ($_POST['submit'] == 'Clear cart') {
			
			//Connect to DB
		    $conn = connect_db();

		    $query = "delete from cart_items where cid='" . $_SESSION['cid'] . "';";

		    //If query fails print error and die
			if (!mysqli_query($conn, $query)) {
				echo "FAILURE: SQL-operation failed";
				die();
			}
			
		    //Close DB connection
			mysqli_close($conn);

			header('Location: cart.php');	
		}
		else if ($_POST['submit'] == 'Checkout') {
			//TODO: ADD FUCTIONALITY
		}
	}
	
	//Connect to DB
    $conn = connect_db();

    //Delete selected item from cart
    $iid = mysqli_escape_string($conn, $_POST['iid']);
    $cid = mysqli_escape_string($conn, $_SESSION['cid']);

    $query = "delete from cart_items where cid='" . $cid . "' and iid='" . $iid . "';";

    //If query fails print error and die
	if (!mysqli_query($conn, $query)) {
		echo "FAILURE: SQL-operation failed";
		die();
	}
	
    //Close DB connection
	mysqli_close($conn);

	//Redirect back to cart-page
	header('Location: cart.php');
?>