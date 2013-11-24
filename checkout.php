<?php
	session_start();
	include 'functions.php';
	print_head("Updated");

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

?>

<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Checkout</h1>


<?php
	
	//If cid is not found redirect to index page
	if (!isset($_SESSION['cid'])) {
		header('Location: index.php');
		die();
	}

	$address = "";

	//Load authentication info for store 
	include 'config.php';

	//Set payment-processor and Curl parameters
	$pay = "https://www4.comp.polyu.edu.hk/~cstmatsumoto/COMP321PAY/"; 
	$comp321pay = curl_init($pay);
	curl_setopt($comp321pay, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($comp321pay, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($comp321pay, CURLOPT_POST, true);

	//If result was ok...
	if (isset($_GET["result"])) { 
		if (!strcmp($_GET["result"], "ok")) {
			//Array to be sent to payment processor 
			$getxc = array( 
				'METHOD' => 'GetExpressCheckoutDetails',
				'USER' => $user,
				'PWD' => $pwd,
				'SIGNATURE' => $signature,
				'TOKEN' => $_GET["token"]);

			//Send array and parse result
			curl_setopt($comp321pay, CURLOPT_POSTFIELDS, http_build_query($getxc));
			parse_str(curl_exec($comp321pay), $response);

			//Parse address from result if changed
			if (isset($response["PAYMENTREQUEST_0_SHIPTONAME"])) {
				$address = $address . $response["PAYMENTREQUEST_0_SHIPTONAME"];
			}
			if (isset($response["PAYMENTREQUEST_0_SHIPTOSTREET"])) {
				$address = $address . ", " . $response["PAYMENTREQUEST_0_SHIPTOSTREET"];
			}
			if (isset($response["PAYMENTREQUEST_0_SHIPTOCITY"])) {
				$address = $address . ", " . $response["PAYMENTREQUEST_0_SHIPTOCITY"];
			}
			
			//If optional address is not set use the default address
			if (strlen($address) == 0) {
				$address = $_SESSION['address'];
			}

			//Save delivery address to session
			$_SESSION['deladdress'] = $address;

			echo "<h2>Order information:</h2>" . PHP_EOL;
			print_ordercontent($_SESSION['cid']);

			echo "<h2>Delivery information:</h2>" . PHP_EOL;
			echo "<p>";
			echo "<b>Name:</b></br>" . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . "<br/><br/>" . PHP_EOL;
			echo "<b>Email:</b></br>" . $_SESSION['email'] . "<br/><br/>" . PHP_EOL;
			echo "<b>Phone:</b></br>" . $_SESSION['phone'] . "<br/><br/>" . PHP_EOL;
			echo "<b>Delivery Address:</b></br>" . $address . "<br/>" . PHP_EOL;
			echo "</p></br>" . PHP_EOL;

			echo "<form name='payform' id='payform' action='" . $_SERVER['PHP_SELF'] . "' method='post'>" . PHP_EOL;
			echo "<input type=hidden name='TOKEN' value='" . $response["TOKEN"] . "'/>" . PHP_EOL; 
			echo "<input type=hidden name='PAYERID' value='" . $response["PAYERID"] . "'/>" . PHP_EOL;
			echo "<input type='submit' id='submit' name='submit' value='Pay now'/>" . PHP_EOL;
			echo "</form>"; 
		}

		//If user cancels payment, redirect to information page
		if (!strcmp($_GET["result"], "cancelled")) { 
			header('Location: message.php?header=Payment cancelled.&message=You have cancelled your payment.');
			die();
		}
	}

	//When user presses Pay now button
	if (isset($_POST['submit'])) {
		if ($_POST['submit'] == 'Pay now') {

			//Confirm payment with payment-processor
			$doxc = array(
		        'METHOD' => 'DoExpressCheckout', 
		        'USER' => $user,
		        'PWD' => $pwd,
		        'SIGNATURE' => $pwd,
		        'PAYERID' => $_POST["PAYERID"], 
		        'TOKEN' => $_POST["TOKEN"]);

			curl_setopt($comp321pay, CURLOPT_POSTFIELDS, http_build_query($doxc));
    		parse_str(curl_exec($comp321pay), $response); 

    		//If trasaction completed successfully change cart status to 'ordered' and insert delivery address and timestamp
    		if ($response["ACK"] == "Success") {

    			//Connect to DB
		    	$conn = connect_db();

		    	//Update order information to DB
		    	$query = "update cart set status='ordered', deladdress='" . htmlentities($_SESSION['deladdress']) . 
		    				"', orderdate=CURRENT_TIMESTAMP where uid='" . $_SESSION['uid'] . "' and cid='" . $_SESSION['cid'] . "';";

		    	//If query fails print error and die
				if (!mysqli_query($conn, $query)) {
					echo "FAILURE: SQL-operation failed";
					die();
				}

				//Close DB connection
				mysqli_close($conn);

				//Unset card id from sessiondata
    			unset($_SESSION['cid']);
    			header('Location: message.php?header=Order completed successfully.&message=Your order has been completed.<br/>Thank you for choosing ShadowFishing.');
    			die();
    		}
    		else {
    			header('Location: message.php?header=Payment failed.&message=Payment has failed for some reason.<br/>Please try again later');
    			die();
    		}
		}
	}
	curl_close($comp321pay);

	echo "</div></div>"; 
	print_footer();
?>