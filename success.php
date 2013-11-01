<?php
	session_start();
	include 'functions.php';
	print_head("Success");

	//If logged in redirect to index
	if(isset($_SESSION['username'])) {
		header('Location: index.php');	
	}

	print_navigation('', '');
?>
	
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Registration completed successfully</h1>
		<p>
			Please login to start shopping.
		</p>
	</div>
	
<?php 

	login_form(false);
	print_footer();
?>