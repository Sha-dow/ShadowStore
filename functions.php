<?php

//--------------------------------------------------------
//Prints header
//Parameters: 
//	$page: 		current page
//Returns: -
//--------------------------------------------------------
function print_head($page) {
	echo "<!DOCTYPE html>" . PHP_EOL; 
	echo "<html><head>" . PHP_EOL;
	echo "<!-- Metadata -->" . PHP_EOL;
	echo "<meta charset='utf-8'>" . PHP_EOL;
	echo "<meta name='author' content='Hannu Ranta'/>" . PHP_EOL;
	echo "<meta name='robots' content='all'/>" . PHP_EOL;
	echo "<meta name='keywords' content='webstore, fishing'/>" . PHP_EOL;
	
	echo "<!-- Title and stylesheet definitions -->" . PHP_EOL;
	echo "<title>" . $page . "</title>" . PHP_EOL;
	echo "<link href='style.css' rel='stylesheet' type='text/css' media='screen'/>" . PHP_EOL;
	echo "<script type='text/javascript' src='scripts.js'></script>" . PHP_EOL;
		
	echo "</head>" . PHP_EOL;
	echo "<body>" . PHP_EOL;
	echo "<!-- Header part -->" . PHP_EOL;
	echo "<div id='header'><a href='index.php'><img style='border:0' src='img/header.png' alt='Shadowfishing'/></a></div>" . PHP_EOL;
}

//--------------------------------------------------------
//Prints navigation according to correct 
//privileges and active page
//Parameters: 
//	$privileges: 	user privileges ('U' or 'A') 
//	$active: 		active page
//Returns: -
//--------------------------------------------------------
function print_navigation($privileges, $active) {
	echo "<!-- Navigation menu -->" . PHP_EOL;
	echo "<div id='navigation'>" . PHP_EOL;
	echo "<ul>";

	//Check active page and show menus according to user privileges
	if ($active == 'index') {
		echo "<li><a href='#' id='current'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;

		if ($privileges == 'U' or $privileges == 'A') {	
			echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
			echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
		}

		if ($privileges == 'A') {
			echo "<li><a href='users.php'>Users</a></li>" . PHP_EOL;
			echo "<li><a href='reports.php'>Reports</a></li>" . PHP_EOL;
		}

		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;
	}

	else if ($active == 'catalog') {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='#' id='current'>Catalog</a></li>" . PHP_EOL;

		if ($privileges == 'U' or $privileges == 'A') {	
			echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
			echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
		}

		if ($privileges == 'A') {
			echo "<li><a href='users.php'>Users</a></li>" . PHP_EOL;
			echo "<li><a href='reports.php'>Reports</a></li>" . PHP_EOL;
		}

		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;
	}

	else if ($active == 'information' and ($privileges == 'U' or $privileges == 'A')) {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;
		echo "<li><a href='#' id='current'>User Information</a></li>" . PHP_EOL;
		echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;

		if ($privileges == 'A') {
			echo "<li><a href='users.php'>Users</a></li>" . PHP_EOL;
			echo "<li><a href='reports.php'>Reports</a></li>" . PHP_EOL;
		}

		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;
	}	

	else if ($active == 'history' and ($privileges == 'U' or $privileges == 'A')) {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;
		echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
		echo "<li><a href='#' id='current'>Order History</a></li>" . PHP_EOL;

		if ($privileges == 'A') {
			echo "<li><a href='users.php'>Users</a></li>" . PHP_EOL;
			echo "<li><a href='reports.php'>Reports</a></li>" . PHP_EOL;
		}

		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;

	}

	else if ($active == 'contact') {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;

		if ($privileges == 'U' or $privileges == 'A') {
			echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
			echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
		}

		if ($privileges == 'A') {
			echo "<li><a href='users.php'>Users</a></li>" . PHP_EOL;
			echo "<li><a href='reports.php'>Reports</a></li>" . PHP_EOL;
		}

		echo "<li><a href='#' id='current'>Contact</a></li>" . PHP_EOL;
	}				
	else if ($active =='users' and $privileges == 'A') {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;
		echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
		echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
		echo "<li><a href='#' id='current'>Users</a></li>" . PHP_EOL;
		echo "<li><a href='reports.php'>Reports</a></li>" . PHP_EOL;
		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;
	}
	else if ($active =='reports' and $privileges == 'A') {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;
		echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
		echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
		echo "<li><a href='users.php'>Users</a></li>" . PHP_EOL;
		echo "<li><a href='#' id='current'>Reports</a></li>" . PHP_EOL;
		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;
	}
	else {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;

		if ($privileges == 'U' or $privileges == 'A') {
			echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
			echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
		}

		if ($privileges == 'A') {
			echo "<li><a href='users.php'>Users</a></li>" . PHP_EOL;
			echo "<li><a href='reports.php'>Reports</a></li>" . PHP_EOL;
		}

		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;
	}

	echo "</ul><!-- Main navigation list ends -->" . PHP_EOL;

	if ($privileges == 'U' or $privileges == 'A') {	
		echo "<div id='logout'>" . PHP_EOL;
		echo "<ul>";
		echo "<li><a href='logout.php'>Logout</a></li>" . PHP_EOL;
		echo "</ul><!-- Logout navigation list ends -->" . PHP_EOL;	
		echo "</div><!-- Logout navigation div ends -->" . PHP_EOL;
	}

	echo "</div><!-- Main navigation div ends -->" . PHP_EOL;
}

//--------------------------------------------------------
//Prints footer
//Parameters: -
//Returns: -
//--------------------------------------------------------
function print_footer() {
	echo "<!-- Footer -->" . PHP_EOL;
	echo "<div id='footer'>" . PHP_EOL;
	echo "<p>Shadowfishing Oy | Tel: +358 40 112 223 | sales@shadowfishing.fi</p>" . PHP_EOL;
	echo "</div></body></html>";
}

//--------------------------------------------------------
//Prints login form and handles login data
//Parameters: 
//	$register:		Is register-button printed
//Returns: -
//--------------------------------------------------------
function login_form($register) {
	echo "<div id='side-container'>" . PHP_EOL;
	echo "<form name='login' id='loginform' action='" . $_SERVER['PHP_SELF'] . "' method='post'>" . PHP_EOL;
	echo "<label>Username: <br/><input type='text' name='username'/></label><br/>" . PHP_EOL;
	echo "<label>Password: <br/><input type='password' name='password'/></label><br/>" . PHP_EOL;
	echo "<input type='submit' id='submit' value='Login' name='submit'/><br/>" . PHP_EOL;

	if($register === true) {
		echo "<input type='button' name='register' id='register' value='Register' onClick=\"location.href = 'register.php'\"/>" . PHP_EOL;
	}	
	
	echo "</form>" . PHP_EOL;
	echo "</div></div>";

	if (isset($_POST['submit'])) {
		if($_POST['submit'] == 'Login') {
  			
  			//Read username and password from form
  			$username = $_POST['username'];
			$password = $_POST['password'];
    		
    		//Connect to DB
    		$conn = connect_db();

    		//Set characterset before using mysqli_escape_string()
			if (!mysqli_set_charset($conn, 'utf8')) {
				echo "FAILURE: Unable to set the character set";
				die();
			}

    		//Escape special characters to improve security
    		$username = mysqli_escape_string($conn, $username);
    		
    		//Search username from DB
    		$query = "select uid, firstname, lastname, email, phone, address, password, salt, role from users where username = '" . $username . "';";
    		$resultset = mysqli_query($conn, $query);

			//If query fails print error and die
			if (!$resultset) {
				echo "FAILURE: Cant retrieve data from database";
				die();
			}

			//If username was found from DB compare password hashes and create session if match
			if (mysqli_num_rows($resultset) > 0) {

				$data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
				$hash = hash('sha256', $data['salt'] . hash('sha256', $password));

				if ($hash == $data['password']) {

					$_SESSION['username'] = $username;
					$_SESSION['firstname'] = $data['firstname'];
					$_SESSION['lastname'] = $data['lastname'];
					$_SESSION['email'] = $data['email'];
					$_SESSION['phone'] = $data['phone'];
					$_SESSION['address'] = $data['address'];
					$_SESSION['role'] = $data['role'];
					$_SESSION['uid'] = $data['uid'];

					//Find if user has saved shopping cart
					$query = "select cid from cart where uid='" . $_SESSION['uid'] . "' and status='saved';";
					$resultset = mysqli_query($conn, $query);

					//If query fails print error and die
					if (!$resultset) {
						echo "FAILURE: Cant retrieve data from database";
						die();
					}

					//If results are returned save cid to session data and change cart state to current
					if (mysqli_num_rows($resultset) > 0) {
						$data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
						$_SESSION['cid'] = $data['cid'];

						$query = "update cart set status='current' where cid='" . $_SESSION['cid'] . "';";

						//If query fails print error and die
						if (!mysqli_query($conn, $query)) {
							echo "FAILURE: SQL-operation failed";
							die();
						}
					}

					mysqli_free_result($resultset);

					//If user has carts with current status for some reason delete those (This is just in case since there should not be any...)
					$query = "delete from cart where uid='" . $_SESSION['uid'] . "' and status='current';";

					//If query fails print error and die
					if (!mysqli_query($conn, $query)) {
						echo "FAILURE: SQL-operation failed";
						die();
					}

					//Close DB connection
					mysqli_close($conn);

					//Redirect to index
					header('Location: index.php');
					die();
				}

				else {
					//If password is incorrect print error
					echo "<script type='text/javascript'>alert('Login failed. Incorrect password');</script>";
				}
			}

			else {
				//If username is not found print error
				echo "<script type='text/javascript'>alert('Login failed. Username not found');</script>";
			}
  		}
  	}
}

//--------------------------------------------------------
//Generates random salt
//Parameters: -
//Returns: 
//	substr($salt, 0, 3): 	3-char random string
//--------------------------------------------------------
function generate_salt()
{
    $salt = md5(uniqid(rand(), true));
    return substr($salt, 0, 3);
}

//--------------------------------------------------------
//Connects to database
//Parameters: -
//Returns: 
//	$conn:		connection or FALSE if connection failed
//-------------------------------------------------------- 
function connect_db()
{
	include 'config.php';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	//Check that connection was successfull
	if (mysqli_connect_errno($conn)) {
		echo "FAILURE: Unable to connect to database";
		return false;
	}
	
	return $conn;
}

//--------------------------------------------------------
//Shows users shopping cart info briefly
//Parameters: 
//	$firstname:		users firstname
//	$lastname:		users lastname
//	$count:			number of items
//	$value:			total value
//Returns: -
//--------------------------------------------------------
function shopping_cart($firstname, $lastname) {

    //If shopping cart is created...
    if (isset($_SESSION['cid'])) {

    	//Connect to DB
    	$conn = connect_db();

    	//...count products in cart
    	$query = "select amount, price*amount as price from cart_items where cid='" . $_SESSION['cid'] . "';";
    	$resultset = mysqli_query($conn, $query);

		//If query fails print error and die
		if (!$resultset) {
			echo "FAILURE: Cant retrieve data from database";
			die();
		}

		$count = 0;
		$value = 0; 

		while ($data = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
			$count = $count + $data['amount'];
			$value = $value + $data['price'];
		}

		mysqli_free_result($resultset);

		//Close DB connection
		mysqli_close($conn);
    }
    //If cart is not created yet set values to 0
    else
    {
    	$count = 0;
    	$value = 0;
    }

	echo "<div id='side-container'>" . PHP_EOL;
	echo "<div id='cart'>" . PHP_EOL;
	echo "<h2>" . $firstname . " " . $lastname . "</h2><br/>" . PHP_EOL;
	echo "Items in cart: " . $count . "<br/>" . PHP_EOL;
	echo "Total value: " . number_format($value, 2, '.', '') . " &euro;<br/><br/>" . PHP_EOL;
	echo "<input type='button' name='view_cart' id='view_cart' value='View cart' onClick=\"location.href = 'cart.php'\"/>" . PHP_EOL;
	echo "</div></div></div>";
} 	

//--------------------------------------------------------
//Shows products table
//Parameters: -
//Returns: -
//--------------------------------------------------------
function print_items() {

	//Connect to DB
    $conn = connect_db();

    $filter = $_SESSION['filter'];

    //Set characterset before using mysqli_escape_string()
	if (!mysqli_set_charset($conn, 'utf8')) {
		echo "FAILURE: Unable to set the character set";
		die();
	}

    $filter = mysqli_escape_string($conn, $filter);

    //Show all items
    if ($filter == "all")
    {
    	//Sort items according to GET-parameter
	    if (isset($_SESSION['sort'])) {

	    	if ($_SESSION['sort'] == 'name' or $_SESSION['sort'] == 'description' or $_SESSION['sort'] == 'price' or $_SESSION['sort'] == 'category') {

	    		//SQL-query for sorting
	    		$query = "select * from products order by " . $_SESSION['sort'] . ";";	
	    	}
	    	else {

	    		//SQL-query form invalid option
	    		$query = "select * from products;";	
	    	}
	    }

	    else {

	    	//If parameter is not passed
	    	$query = "select * from products;";	
	    }
    }

    //Show items by category
    else if ($filter == "line" or $filter == "rod" or $filter == "reel")
    {

    	if (isset($_SESSION['sort'])) {

	    	if ($_SESSION['sort'] == 'name' or $_SESSION['sort'] == 'description' or $_SESSION['sort'] == 'price' or $_SESSION['sort'] == 'category') {

	    		//SQL-query for sorting
	    		$query = "select * from products where category = '" . $filter . "' order by " . $_SESSION['sort'] . ";";
	    	}
	    	else {

	    		//SQL-query form invalid option	
	    		$query = "select * from products where category = '" . $filter . "';";
	    	}
	    }

	    else {

	    	//If parameter is not passed
	    	$query = "select * from products where category = '" . $filter . "';";	
	    }	
    }

    //Show items by keyword
    else
    {
    	if (isset($_SESSION['sort'])) {

	    	if ($_SESSION['sort'] == 'name' or $_SESSION['sort'] == 'description' or $_SESSION['sort'] == 'price' or $_SESSION['sort'] == 'category') {

	    		//SQL-query for sorting
	    		$query = "select * from products where category like '%" . $filter . 
	    		"%' or name like '%" . $filter . "%' or description like '%" . $filter . "%' order by " . $_SESSION['sort'] . ";";
	    	}
	    	else {

	    		//SQL-query form invalid option	
	    		$query = "select * from products where category like '%" . $filter . 
    			"%' or name like '%" . $filter . "%' or description like '%" . $filter . "%';";
	    	}
	    }

	    else {

	    	//If parameter is not passed
	    	$query = "select * from products where category like '%" . $filter . 
    		"%' or name like '%" . $filter . "%' or description like '%" . $filter . "%';";	
	    }	

    	$query = "select * from products where category like '%" . $filter . 
    		"%' or name like '%" . $filter . "%' or description like '%" . $filter . "%';";
    }

    $resultset = mysqli_query($conn, $query);

	//If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}

	$even = false;

	//Get through fecthed data and print products table
	while ($data = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {

		if ($even) {
			echo "<tr class='even'>" . PHP_EOL;
			$even = false;	
		}
		else {
			echo "<tr>";
			$even = true;	
		}
		
		echo "<td><img src='img/" . $data['image'] . "' width='100'></td>" . PHP_EOL;
		echo "<td>" . $data['name'] . "</td>" . PHP_EOL;
		echo "<td>" . $data['description'] . "</td>" . PHP_EOL;
		echo "<td>" . $data['price'] . "&euro;</td>" . PHP_EOL;
		echo "<td>" . $data['category'] . "</td>" . PHP_EOL;

		//Only logged-in user can move products to shopping cart
		if (isset($_SESSION['username'])) {
			echo "<td><input type='submit' value='Add to Cart' onclick='addItem(" . $data['pid'] . ");'/></td>" . PHP_EOL;
		}

		echo "</tr>";
	}
	echo "</table></form>" . PHP_EOL;

	mysqli_free_result($resultset);

	//Close DB connection
	mysqli_close($conn);
}

//--------------------------------------------------------
//Prints shopping cart items
//Parameters: 
//Returns: -
//--------------------------------------------------------
function print_cart() {

	$total = 0;
	$shipping = 10;

	//Connect to DB and select items from users cart
    $conn = connect_db();
    $query = "select * from cart_items where cid='" . $_SESSION['cid'] . "';";
    $resultset = mysqli_query($conn, $query);

	//If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}

	//If cart is not empty print contents...
	if (mysqli_num_rows($resultset) > 0) {
		echo "<form name='cartform' id='cartform' action='modifycart.php' method='post'>" . PHP_EOL;
		echo "<input type='hidden' id='iid' name='iid'/>" . PHP_EOL;
		echo "<table id='carttable' class='carttable'><tr>" . PHP_EOL;
		echo "<th>Name</th><th>Description</th><th>Unit price</th><th>Amount</th><th></th>" . PHP_EOL;
		
		$even = false;

		//Get through fecthed data and collect to array
		while ($data = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
			$items[] = $data;
			$total = $total + ($data['amount'] * $data['price']);
		}

		for ($i = 0; $i < count($items); $i++) {
			$query = "select name, description from products where pid='" . $items[$i]['pid'] . "';";
			$resultset = mysqli_query($conn, $query);

			//If query fails print error and die
			if (!$resultset) {
				echo "FAILURE: Cant retrieve data from database";
				die();
			}

			while ($productdata = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
				if ($even) {
					echo "<tr class='even'>";
					$even = false;	
				}
				else {
					echo "<tr>";
					$even = true;	
				}
				
				echo "<td>" . $productdata['name'] . "</td>" . PHP_EOL;
				echo "<td>" . $productdata['description'] . "</td>" . PHP_EOL;
				echo "<td>" . $items[$i]['price'] . "&euro;</td>" . PHP_EOL;
				echo "<td><input type='text' name='amount" . $items[$i]['iid'] . "' size='3' value='" . $items[$i]['amount'] . "'/></td>" . PHP_EOL;
				echo "<td><input type='submit' value='Remove from cart' onclick='deleteItem(" . $items[$i]['iid'] . ");'/></td>";
				echo "</tr>";
			}
		}

		$total = $total + $shipping;
		echo "<tr><td colspan='2'><b>Shipping</b></td><td>10.00&euro;</td><td colspan='2'></td></tr>" . PHP_EOL;
		echo "<tr><td colspan='2' class='total'>Total</td><td class='total'>" . number_format($total, 2, '.', '') . "&euro;</td><td colspan='2' class='total'></td></tr>" . PHP_EOL;
		echo "</table>" . PHP_EOL;
		echo "<input type='submit' id='submit' name='submit' value='Update cart'/>" . PHP_EOL;
		echo "<input type='submit' id='submit' name='submit' value='Clear cart'/>" . PHP_EOL;
		echo "<input type='submit' id='submit' name='submit' value='Save cart'/>" . PHP_EOL;
		echo "<input type='submit' id='submit' name='submit' value='Checkout'/>" . PHP_EOL;
		echo "</form>";
	}
	//...if empty, print information msg
	else {
		echo "<p>No items in shopping cart.</p>" . PHP_EOL;		
	}
	mysqli_free_result($resultset);
	mysqli_close($conn);

}

function print_ordercontent($cid) {

	$total = 0;
	$shipping = 10;

	//Connect to DB and select items from cart according to cid
    $conn = connect_db();
    $query = "select * from cart_items where cid='" . $cid . "';";
    $resultset = mysqli_query($conn, $query);

    //If query fails print error and die
	if (!$resultset) {
		echo "FAILURE: Cant retrieve data from database";
		die();
	}



	//If cart is not empty print contents...
	if (mysqli_num_rows($resultset) > 0) {
		
		echo "<table id='ordertable' class='ordertable'><tr>" . PHP_EOL;
		echo "<th>Name</th><th>Description</th><th>Unit price</th><th>Amount</th>" . PHP_EOL;
		
		$even = false;

		//Get through fecthed data and collect to array
		while ($data = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
			$items[] = $data;
			$total = $total + ($data['amount'] * $data['price']);
		}

		for ($i = 0; $i < count($items); $i++) {
			$query = "select name, description from products where pid='" . $items[$i]['pid'] . "';";
			$resultset = mysqli_query($conn, $query);

			//If query fails print error and die
			if (!$resultset) {
				echo "FAILURE: Cant retrieve data from database";
				die();
			}

			while ($productdata = mysqli_fetch_array($resultset, MYSQLI_ASSOC)) {
				if ($even) {
					echo "<tr class='even'>" . PHP_EOL;
					$even = false;	
				}
				else {
					echo "<tr>";
					$even = true;	
				}
				
				echo "<td>" . $productdata['name'] . "</td>" . PHP_EOL;
				echo "<td>" . $productdata['description'] . "</td>" . PHP_EOL;
				echo "<td>" . $items[$i]['price'] . "&euro;</td>" . PHP_EOL;
				echo "<td>" . $items[$i]['amount'] . "</td>" . PHP_EOL;
				echo "</tr>";
			}
		}

		$total = $total + $shipping;
		echo "<tr><td colspan='2'><b>Shipping</b></td><td>10.00&euro;</td><td colspan='2'></td></tr>" . PHP_EOL;
		echo "<tr><td colspan='2' class='total'>Total</td><td class='total'>" . number_format($total, 2, '.', '') . "&euro;</td><td colspan='2' class='total'></td></tr>" . PHP_EOL;
		echo "</table>" . PHP_EOL;
	}
	mysqli_free_result($resultset);
	mysqli_close($conn);
}

?>