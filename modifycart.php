<?php
	session_start();
	include 'functions.php';
	
	if (!isset($_SESSION['username'])) {
		header('Location: index.php');	
	}

	//Catch submit-action and act according to value 
	if (isset($_POST['submit'])) {
		//If 'Update cart':
		if ($_POST['submit'] == 'Update cart') {
			
			//Connect to DB
		    $conn = connect_db();

		    //Find item-ids
		    $query = "select iid from cart_items where cid='" . $_SESSION['cid'] . "';";
		    $resultset = mysqli_query($conn, $query);

			//If query fails print error and die
			if (!$resultset) {
				echo "FAILURE: Cant retrieve data from database";
				die();
			}

			$queries;

			//Update amounts to correct item ids
			while ($items = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
				$id = "amount" . $items['iid'];   

				//Take only positive amounts into account and collect sql-queries to array
				if ($_POST[$id] > 0)
				{
					$queries[] = "update cart_items set amount='" . $_POST[$id] . "' where cid='" . $_SESSION['cid'] . "' and iid='" . $items['iid'] . "';";
				} 	
			}

			//If queries were formed loop through array and execute given queries to update amounts
			if (count($queries) > 0) {
				for ($i = 0; $i < count($queries); $i++) {
					$query = $queries[$i];
					//If query fails print error and die
					if (!mysqli_query($conn, $query)) {
						echo "FAILURE: SQL-operation failed";
						die();
					}
				}
			}

			//Close DB connection
			mysqli_close($conn);
		}
		//If 'Clear cart'
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
		}
		//If 'Save cart'
		else if ($_POST['submit'] == 'Save cart') {
			
			//Connect to DB
		    $conn = connect_db();
			$query = "update cart set status='saved' where cid='" . $_SESSION['cid'] . "';";

			//If query fails print error and die
			if (!mysqli_query($conn, $query)) {
				echo "FAILURE: SQL-operation failed";
				die();
			}

			//Close DB connection
			mysqli_close($conn);
			
			//Redirect to saved-page
			header('Location: cartsaved.php');
			die();
		}
		//If 'Checkout'
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