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
			header('Location: message.php?header=Shopping cart saved successfully.&message=
				Your shopping cart is now saved and will be retrieved when you log in next time.
				</br>All changes you will made during this session will be taken into account and your cart will
				</br>return to state where it was before logout.');
			die();
		}
		//If 'Checkout'
		else if ($_POST['submit'] == 'Checkout') {

			//Authentication info for store 
			$store = "http://localhost/dev"; 
			$user = "ShadowFishing";
			$pwd = $user;
			$signature = $user;
			
			//Set payment-processor and Curl parameters
			$pay = "https://www4.comp.polyu.edu.hk/~cstmatsumoto/COMP321PAY/"; 
			$comp321pay = curl_init($pay);
			curl_setopt($comp321pay, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($comp321pay, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($comp321pay, CURLOPT_POST, true);

			//Request collected to associative array
			//First method is always SetExpressCheckout
			//Paymentaction is always Sale
			$setxc = array(
		        'METHOD' => 'SetExpressCheckout', 
		        'RETURNURL' =>  $store .'/checkout.php?result=ok', 
		        'CANCELURL' => $store  . '/checkout.php?result=cancelled', 
		        'USER' => $user,
		        'PWD' => $pwd,
		        'SIGNATURE' => $signature,
		        'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale');

			$conn = connect_db();
			$query = "select * from cart_items where cid='" . $_SESSION['cid'] . "';";
			$resultset = mysqli_query($conn, $query);

			//If query fails print error and die
			if (!$resultset) {
				echo "FAILURE: Cant retrieve data from database";
				die();
			}

			$total = 0;
			$shipping = 10;

			//Get through fecthed data and add items to array
			while ($data = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
				$items[] = $data;
				$total = $total + ($data['amount'] * $data['price']);
			}

			$total = $total + $shipping;

			//Collect information to array
			for ($i = 0; $i < count($items); $i++) {
				$query = "select pid, name, description from products where pid='" . $items[$i]['pid'] . "';";
				$resultset = mysqli_query($conn, $query);

				//If query fails print error and die
				if (!$resultset) {
					echo "FAILURE: Cant retrieve data from database";
					die();
				}

				while ($productdata = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
					$setxc['L_PAYMENTREQUEST_0_NAME' . $i] = $productdata['name'];
				   	$setxc['L_PAYMENTREQUEST_0_NUMBER' . $i] = $productdata['pid'];
				   	$setxc['L_PAYMENTREQUEST_0_DESC' . $i] = $productdata['description'];
				   	$setxc['L_PAYMENTREQUEST_0_AMT' . $i] = $items[$i]['price'];
					$setxc['L_PAYMENTREQUEST_0_QTY' . $i] = sprintf('%05d', $items[$i]['amount']);
				}
			}

		   	$setxc['PAYMENTREQUEST_0_AMT'] = sprintf('%0.2f', $total);
		   	$setxc['PAYMENTREQUEST_0_SHIPPINGAMT'] = sprintf('%0.2f', $shipping);

		   	mysqli_free_result($resultset);
			mysqli_close($conn);

			//Send array and parse response
			curl_setopt($comp321pay, CURLOPT_POSTFIELDS, http_build_query($setxc));
			parse_str(curl_exec($comp321pay), $response);

			if ($response["ACK"] == "Success") { 
		        header('Location: '. $pay .'?cmd=_express-checkout&token='. $response["TOKEN"]); 
		        die();
		    }
		    else {
		    	header('Location: message.php?header=Payment failed.&message=Payment has failed for some reason.</br>Please try again later');
		        die();	
		    }
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