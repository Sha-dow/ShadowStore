<?php
	session_start();
	include 'functions.php';
	print_head("Contact");
	$role = '';

	if (isset($_SESSION['username'])) {
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}

	unset($_SESSION['sort']);
	$_SESSION['filter'] = 'all';

	print_navigation($role, 'contact');
?>
		
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Contact information</h1>
		
		<h2>Address: </h2>
		<p>
			Shadowfishing Oy <br/>
			Kalastajankatu 1 A2 <br/>
			33720 TAMPERE <br/> 
			FINLAND
		</p>

		<h2>Opening hours:</h2>
		<p>
			8-16 <br/>
			10-12 <br/>
			Closed on Sundays and public holidays
		</p>
		
		<h2>Phone:</h2>
		<p>+358 40 112 223</p>

		<h2>Email:</h2>
		<p>sales@shadowfishing.fi</p>
	</div>
	
<?php 
	
	if (isset($_SESSION['username'])) {
		shopping_cart($firstname, $lastname);
	}
	else {
		login_form(true);
	}
	
	print_footer();
?>