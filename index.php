<?php
	session_start();
	include 'functions.php';
	print_head("Index");
	$role = '';

	if (isset($_SESSION['username'])) {
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}

	unset($_SESSION['sort']);
	$_SESSION['filter'] = 'all';

	print_navigation($role, 'index');
?>
	
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Welcome to ShadowFishing</h1>
		<p>
			ShadowFishing is your most trusted Loop reseller.<br/>
			We are selling wide variety of flyfishing gears including<br/>
			reels, rods and lines.<br/><br/>
			From our store you will find best prices, newest models and <br/>
			most experianced staff.<br/><br/>
			Check our catalog and start your ultimate flyfishing journey. <br/><br/>		
	
<?php
	//Load and show random advertisement photo
	echo "<img style='border:0' src='img/index_ad" . rand(1, 6) . ".jpg' alt='Flyfishing'/>";
	echo "</p></div>";
	
	if (isset($_SESSION['username'])) {
		shopping_cart($firstname, $lastname);
	}
	else {
		login_form(true);
	}
	
	print_footer();
?>