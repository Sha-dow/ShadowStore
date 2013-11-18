<?php
	session_start();
	include 'functions.php';
	print_head("Catalog");
	$role = '';

	if (isset($_SESSION['username'])) {
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$role = $_SESSION['role'];	
	}

	print_navigation($role, 'catalog');
?>
		
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Products catalog</h1>

		<div id='filter'>
			<ul>
				<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?filter=all">All</a></li>
				<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?filter=rod">Rods</a></li>
				<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?filter=reel">Reels</a></li>
				<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?filter=line">Lines</a></li>
			

			<li><form name='search' id='search' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
				<input type='text' name='search'/>
				<input type='submit' name='submit' id='submit_src' value='Search'/>
			</form></li> 
			</ul>
		</div>
		
		<?php

		echo "<form name='catalogform' id='catalogform' action='addtocart.php' method='post'>" . PHP_EOL;
		echo "<input type='hidden' id='pid' name='pid'/>";
		echo "<table id='catalog' class='catalog'>";

		echo "<tr><th>Image</th>
			<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=name'>Name</a></th>
			<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=description'>Description</a></th>
			<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=price'>Price</a></th>
			<th><a href='" . $_SERVER['PHP_SELF'] . "?sort=category'>Category</a></th>";

			if (isset($_SESSION['username'])) {
				echo "<th></th>";
			}

			echo "</tr>" . PHP_EOL;

			if (isset($_GET['sort'])) {
				$_SESSION['sort'] = htmlentities($_GET['sort']);
			}

			if (isset($_POST['search'])) {
				$_SESSION['filter'] = htmlentities($_POST['search']);
				print_items();
			} 

			else if (isset($_GET['filter'])) {
				$_SESSION['filter'] = htmlentities($_GET['filter']);
				print_items();
			}

			else {
				print_items();
			} 
		?>

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