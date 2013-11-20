<?php
	session_start();
	include 'functions.php';
	print_head("Register");

	//If logged in redirect to index
	if (isset($_SESSION['username'])) {
		header('Location: index.php');
	}

	print_navigation('','');
?>
	
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>Register</h1>
		<p>
			Please insert following information to register: <br/>
			(All fieds are required)

			<!-- Registeration form -->
			<form name='register' id='generalform' action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
				<fieldset>
					<label>First name: <br/><input type="text" name="firstname" maxlength="50" <?php if (isset($_POST['firstname'])) echo 'value="'. htmlentities($_POST['firstname']) . '"';?> /></label><br/>
					<label>Last name: <br/><input type="text" name="lastname" maxlength="50" <?php if (isset($_POST['lastname'])) echo 'value="'. htmlentities($_POST['lastname']) . '"';?> /></label></br>
					<label>Email: <br/><input type="email" name="email" maxlength="100" <?php if (isset($_POST['email'])) echo 'value="'. htmlentities($_POST['email']) . '"';?> /></label><br/>
					<label>Phone: <br/><input type="text" name="phone" <?php if (isset($_POST['phone'])) echo 'value="'.$_POST['phone'].'"';?> /></label><br/>
					<label>Address: <br/><textarea name="address" rows="5" cols="30" maxlength="400"><?php if (isset($_POST['address'])) echo htmlentities($_POST['address']);?></textarea></label>
				</fieldset>
	
				<fieldset>
					<label>Username: <br/><input type="text" name="username" maxlength="50"/></label><br/>
					<label>Password: <br/><input type="password" name="password"/></label><br/>
					<label>Re-enter password: <br/><input type="password" name="chkpassword"/></label>
				</fieldset>

				<fieldset>
					<input type="submit" id="submit_reg" value="Register" name='submit' onClick="return validate_input('register')"/><br/>
					<input type="button" id="reset" value="Reset" onClick="reset_fields()"/>
				</fieldset>
			</form> <!-- Registeration form ends -->
		</p>
	</div>

<?php 
	login_form(false);

	//Catch submit-action and act according to value 
	if (isset($_POST['submit'])) {
		//If 'register':
		if ($_POST['submit'] == 'Register') {
			
			//Read variables from form
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$address = $_POST['address'];
			$username = $_POST['username'];
			$password = $_POST['password'];

			//Encrypt password using sha256 and salt
			$hash = hash('sha256', $password);
			$salt = generate_salt();
			$hash = hash('sha256', $salt . $hash);

			//Connect to DB
			$conn = connect_db();

			//Set characterset before using mysqli_escape_string()
			if (!mysqli_set_charset($conn, 'utf8')) {
				echo "FAILURE: Unable to set the character set";
				die();
			}

			//Escape special characters to improve security
			$firstname = mysqli_escape_string($conn, $firstname);
			$lastname = mysqli_escape_string($conn, $lastname);
			$email = mysqli_escape_string($conn, $email);
			$phone = mysqli_escape_string($conn, $phone);
			$address = mysqli_escape_string($conn, $address);
			$username = mysqli_escape_string($conn, $username);

			//Search username from DB
			$query = "select uid from users where username = '" . $username ."';";
			$resultset = mysqli_query($conn, $query);

			//If query fails print error and die
			if (!$resultset) {
				echo "FAILURE: Cant retrieve data from database";
				die();
			}

			//If username exists show errormsg...
			if (mysqli_num_rows($resultset) > 0) {
				echo "<script type='text/javascript'>alert('Username is reserved. Please select another one');</script>";
			}

			//...otherwise add data to DB and redirect to success-page
			else
			{
				//SQL-query for adding user information to DB
				$query = "insert into users ( firstname, lastname, email, phone, address, username, password, salt, role ) 
					values ('" . $firstname . "', '" . $lastname. "', '" . $email . "', '" . $phone . "', '" . $address . "', '" . $username . "', '" . $hash . "', '" . $salt . "', 'U');";

				//If query fails print error and die
				if (!mysqli_query($conn, $query)) {
					echo "FAILURE: SQL-operation failed";
					die();
				}

				//Close DB connection and move to registered.php
				mysqli_close($conn);
				header('Location: registered.php');
			}
			mysqli_free_result($resultset);
			mysqli_close($conn);
		} 
	}
	print_footer();
?>