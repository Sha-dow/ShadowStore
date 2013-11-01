<?php
/* Runtime debugging */
ini_set('display_errors', 'On');
error_reporting(-1);

function echo_head() {
	echo "<!DOCTYPE html>";
	echo "<head><title>Checkout Demo</title>";
    echo "<meta charset='utf-8'></head>";
	echo "<body>";
}

function echo_tail() {
	echo "</body>";
	echo "</html>";
}

/* Authentication info for store */
$store = "https://www4.comp.polyu.edu.hk/~cstmatsumoto/COMP321/A2"; // Store base URL
$user = "Demo Store";
$pwd = $user;
$signature = $user;

/* Setup for cURL */
$pay = "https://www4.comp.polyu.edu.hk/~cstmatsumoto/COMP321PAY/"; // Payment processor
$comp321pay = curl_init($pay);
curl_setopt($comp321pay, CURLOPT_RETURNTRANSFER, true);
curl_setopt($comp321pay, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($comp321pay, CURLOPT_POST, true);

if (isset($_POST["Checkout"])) { // Start Checkout
    $setxc = array( // Requests should be created in an associative array
        'METHOD' => 'SetExpressCheckout', // The first method is always SetExpressCheckout
        'RETURNURL' =>  $store .'/checkoutdemo.php?result=ok', // Return here if successful
        'CANCELURL' => $store  . '/checkoutdemo.php?result=cancelled', // Return here if cancelled
        'USER' => $user,
        'PWD' => $pwd,
        'SIGNATURE' => $signature,
        'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale', // The payment action is always Sale
        'L_PAYMENTREQUEST_0_NAME0' => 'Item 1', // Item 1
        'L_PAYMENTREQUEST_0_NUMBER0'=> '00001',
        'L_PAYMENTREQUEST_0_DESC0'=> 'A description for item 1',
        'L_PAYMENTREQUEST_0_AMT0'=> '6.00',
        'L_PAYMENTREQUEST_0_QTY0' => '1',
        'L_PAYMENTREQUEST_0_NAME1' => 'Item 2', // Item 2
        'L_PAYMENTREQUEST_0_NUMBER1'=> '00002',
        'L_PAYMENTREQUEST_0_DESC1'=> 'Another description for item 2',
        'L_PAYMENTREQUEST_0_AMT1'=> '4.00',
        'L_PAYMENTREQUEST_0_QTY1' => '1',
        'PAYMENTREQUEST_0_AMT' => '12.00', // Total amount including shipping (money format without $)
        'PAYMENTREQUEST_0_SHIPPINGAMT' => '2.00'); // Shipping (money format without $)

	/* 
	   Note: for COMP321PAY you may have one PAYMENTREQUEST (PAYMENTREQUEST_0) with multiple line items from 0 to a maximum of 50.
	   
	   The line item fields are:
	   L_PAYMENTREQUEST_0_NAMEn = Item name
	   L_PAYMENTREQUEST_0_NUMBERn = Item ID
	   L_PAYMENTREQUEST_0_DESCn = Item description
	   L_PAYMENTREQUEST_0_AMTn = Item price (money format without $ e.g. "10.00")
	   L_PAYMENTREQUEST_0_QTYn = Quantity ordered (positive integer e.g. "2")
	   Note: You cannot use HTML in these fields

	   You should use a loop to build the array - e.g.:
	   for (int $i = 0; $i < count($cart_items_names); $i++) {
	       $setxc['L_PAYMENTREQUEST_0_NAME' . $i] = $cart_items_names[$i];
		   $setxc['L_PAYMENTREQUEST_0_NUMBER' . $i] = $cart_items_numbers[$i];
		   $setxc['L_PAYMENTREQUEST_0_DESC' . $i] = $cart_items_descs[$i];
		   $setxc['L_PAYMENTREQUEST_0_AMT' . $i] = $cart_items_amts[$i];
		   $setxc['L_PAYMENTREQUEST_0_QTY' . $i] = $cart_items_qtys[$i];
	   }
	   
	   You should also make sure PAYMENTREQUEST_0_AMT is the same as the total of your items + SHIPPINGAMT
	   Note: you cannot request negative payments (although line items may be negative price)
    */
    curl_setopt($comp321pay, CURLOPT_POSTFIELDS, http_build_query($setxc));
    parse_str(curl_exec($comp321pay), $response); // Store responses into array
	/* Check response from server */
    if ($response["ACK"] == "Success") { // ACK says whether the operation ended in Success or Failure
		//print_r($response);
        header('Location: '. $pay .'?cmd=_express-checkout&token='. $response["TOKEN"]); // Redirect to payment processor with the token received
        die();
    } else {
		echo_head();
		echo "COMP321PAY response:<br>";
		echo "<pre>";
        print_r($response); // For debugging
		echo "</pre>";
		echo "<br><b>Error!</b>";
		echo_tail();
    }
} else if (isset($_GET["result"])) { // Redirected back here from payment processor
	echo_head();
	if (!strcmp($_GET["result"], "ok")) { // User authorized payment
		$getxc = array( // Next use GetExpressCheckoutDetails to check if the user entered an alternate address
			'METHOD' => 'GetExpressCheckoutDetails',
			'USER' => $user,
			'PWD' => $pwd,
			'SIGNATURE' => $pwd,
			'TOKEN' => $_GET["token"]);

		curl_setopt($comp321pay, CURLOPT_POSTFIELDS, http_build_query($getxc));
		parse_str(curl_exec($comp321pay), $response);  // Store responses into array
		echo "COMP321PAY response:<br>";
		echo "<pre>";
		print_r($response); // For debugging
		echo "</pre>";
		/* Check response if an alternate address was set */
		if (isset($response["PAYMENTREQUEST_0_SHIPTONAME"])) {
			echo "<p>New name: " . $response["PAYMENTREQUEST_0_SHIPTONAME"] . "<br>";
		}
		if (isset($response["PAYMENTREQUEST_0_SHIPTOSTREET"])) {
			echo "New street: " . $response["PAYMENTREQUEST_0_SHIPTOSTREET"] . "<br>";
		}
		if (isset($response["PAYMENTREQUEST_0_SHIPTOCITY"])) {
			echo "New city: " . $response["PAYMENTREQUEST_0_SHIPTOCITY"] . "</p>";
		}
		if ($response["ACK"] == "Success") { // ACK says whether the operation ended in Success or Failure
			echo "<b>Success!</b>";
			echo "<br>Click to pay now<br>";
			echo "<form method=post action='checkoutdemo.php'>";
			echo "<input type=hidden name='TOKEN' value='" . $response["TOKEN"] . "'>"; // Save TOKEN (hidden)
			echo "<input type=hidden name='PAYERID' value='" . $response["PAYERID"] . "'>"; // Save PAYERID (hidden)
			echo "<input type=submit name='PayNow' value='Pay Now'>";
			echo "</form>";
		} else {
			echo "<br><b>Error!</b>";
		}
	} else { // User cancelled payment or it timed out
		echo "<b>Payment cancelled!</b>"; // Let the user try again
	}
	echo_tail();
} else if (isset($_POST["PayNow"])) {
	echo_head();
    $doxc = array(
        'METHOD' => 'DoExpressCheckout', // Finally use DoExpressCheckout to confirm payment
        'USER' => $user,
        'PWD' => $pwd,
        'SIGNATURE' => $pwd,
        'PAYERID' => $_POST["PAYERID"], // Remember to save both PAYERID
        'TOKEN' => $_POST["TOKEN"]);    // and TOKEN to confirm payment
    curl_setopt($comp321pay, CURLOPT_POSTFIELDS, http_build_query($doxc));
    parse_str(curl_exec($comp321pay), $response);  // Store responses into array

    echo "COMP321PAY response:<br>";
	echo "<pre>";
    print_r($response); // For debugging
	echo "</pre>";
    if ($response["ACK"] == "Success") { // ACK says whether the operation ended in Success or Failure
        echo "<br><b>Payment successful!</b>";
    } else {
        echo "<br><b>Payment failed!</b>";
    }
	echo_tail();
} else { // Demo store
	echo_head();
	echo "Welcome to my store!<br>";
    echo "Click to buy my Item 1 and Item 2.<br>";
    echo "<form method=post action='checkoutdemo.php'>";
    echo "<input type=submit name='Checkout' value='Checkout'>";
    echo "</form>";
	echo_tail();
}
curl_close($comp321pay);
?>