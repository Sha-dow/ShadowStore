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
	echo "<div id='header'><img style='border:0' src='img/header.png' alt='Shadowfishing'/></div>" . PHP_EOL;
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

	if ($active == 'index') {
		echo "<li><a href='#' id='current'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;

		if ($privileges == 'U' or $privileges == 'A') {	
			echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
			echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
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

		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;
	}

	else if ($active == 'information' and ($privileges == 'U' or $privileges == 'A')) {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;
		echo "<li><a href='#' id='current'>User Information</a></li>" . PHP_EOL;
		echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;
	}	

	else if ($active == 'history' and ($privileges == 'U' or $privileges == 'A')) {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;
		echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
		echo "<li><a href='#' id='current'>Order History</a></li>" . PHP_EOL;
		echo "<li><a href='contact.php'>Contact</a></li>" . PHP_EOL;
	}

	else if ($active == 'contact') {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;

		if ($privileges == 'U' or $privileges == 'A') {
			echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
			echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
		}

		echo "<li><a href='#' id='current'>Contact</a></li>" . PHP_EOL;
	}				

	else {
		echo "<li><a href='index.php'>Index</a></li>" . PHP_EOL;
		echo "<li><a href='catalog.php'>Catalog</a></li>" . PHP_EOL;

		if ($privileges == 'U' or $privileges == 'A') {
			echo "<li><a href='information.php'>User Information</a></li>" . PHP_EOL;
			echo "<li><a href='history.php'>Order History</a></li>" . PHP_EOL;
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
    		$query = "select firstname, lastname, email, phone, address, password, salt, role from users where username = '" . $username . "';";
    		$resultset = mysqli_query($conn, $query);

			//If query fails print error and die
			if (!$resultset) {
				echo "FAILURE: Cant retrieve data from database";
				die();
			}

			//Close DB connection
			mysqli_close($conn);

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

					//Redirect to index
					header('Location: index.php');
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
//Shows users shopping cart
//Parameters: 
//	$firstname:		users firstname
//	$lastname:		users lastname
//	$count:			number of items
//	$value:			total value
//Returns: -
//--------------------------------------------------------
function shopping_cart($firstname, $lastname, $count, $value) {
	echo "<div id='side-container'>" . PHP_EOL;
	echo "<div id='cart'>" . PHP_EOL;
	echo "<h2>" . $firstname . " " . $lastname . "</h2><br/>" . PHP_EOL;
	echo "Items in cart: " . $count . "<br/>" . PHP_EOL;
	echo "Total value: " . $value . " &euro;<br/><br/>" . PHP_EOL;
	echo "<input type='button' name='view_cart' id='view_cart' value='View cart' onClick=\"location.href = 'cart.php'\"/>" . PHP_EOL;
	echo "</div></div></div>";
} 	

?>