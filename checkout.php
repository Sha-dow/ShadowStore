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
	
	if (!isset($_SESSION['cid'])) {
		header('Location: index.php');
		die();
	}

	$address = "";

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

	if (isset($_GET["result"])) { 
		if (!strcmp($_GET["result"], "ok")) { 
			$getxc = array( 
				'METHOD' => 'GetExpressCheckoutDetails',
				'USER' => $user,
				'PWD' => $pwd,
				'SIGNATURE' => $signature,
				'TOKEN' => $_GET["token"]);

			curl_setopt($comp321pay, CURLOPT_POSTFIELDS, http_build_query($getxc));
			parse_str(curl_exec($comp321pay), $response);

			if (isset($response["PAYMENTREQUEST_0_SHIPTONAME"])) {
				$address = $address . $response["PAYMENTREQUEST_0_SHIPTONAME"];
			}
			if (isset($response["PAYMENTREQUEST_0_SHIPTOSTREET"])) {
				$address = $address . ", " . $response["PAYMENTREQUEST_0_SHIPTOSTREET"];
			}
			if (isset($response["PAYMENTREQUEST_0_SHIPTOCITY"])) {
				$address = $address . ", " . $response["PAYMENTREQUEST_0_SHIPTOCITY"];
			}
			
			if (strlen($address) == 0) {
				$address = $_SESSION['address'];
			}

			$_SESSION['deladdress'] = $address;

			echo "<h2>Order information:</h2>";
			print_ordercontent($_SESSION['cid']);

			echo "<h2>Delivery information:</h2>";
			echo "<p>";
			echo "<b>Name:</b></br>" . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . "</br></br>";
			echo "<b>Email:</b></br>" . $_SESSION['email'] . "</br></br>";
			echo "<b>Phone:</b></br>" . $_SESSION['phone'] . "</br></br>";
			echo "<b>Delivery Address:</b></br>" . $address . "</br>";
			echo "</p></br>";

			echo "<form name='payform' id='payform' action='" . $_SERVER['PHP_SELF'] . "' method='post'>" . PHP_EOL;
			echo "<input type=hidden name='TOKEN' value='" . $response["TOKEN"] . "'>"; 
			echo "<input type=hidden name='PAYERID' value='" . $response["PAYERID"] . "'>";
			echo "<input type='submit' id='submit' name='submit' value='Pay now'/>" . PHP_EOL;
			echo "</form>"; 
		}

		if (!strcmp($_GET["result"], "cancelled")) { 
			header('Location: message.php?header=Payment cancelled.&message=You have cancelled your payment.');
			die();
		}
	}

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

    			unset($_SESSION['cid']);
    			header('Location: message.php?header=Order completed successfully.&message=Your order has been completed.</br>Thank you for choosing ShadowFishing.');
    			die();
    		}
    		else {
    			header('Location: message.php?header=Payment failed.&message=Payment has failed for some reason.</br>Please try again later');
    			die();
    		}
		}
	}
	curl_close($comp321pay);

	echo "</div></div>"; 
	print_footer();
?>