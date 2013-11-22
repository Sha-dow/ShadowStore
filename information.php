<?php
	session_start();
	include 'functions.php';
	print_head("User Information");
	$role = '';

	if (isset($_SESSION['username'])) {

		$username = $_SESSION['username'];
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		$email = $_SESSION['email'];
		$phone = $_SESSION['phone'];
		$address = $_SESSION['address'];
		$role = $_SESSION['role'];	
	}
	else {
		header('Location: index.php');
	}

	unset($_SESSION['sort']);
	$_SESSION['filter'] = 'all';

	print_navigation($role, 'information');
?>
	
<!-- Main container includes two minor containers -->
<div id="main-container">
	<div id="container">
		<h1>User Information</h1>
		<p>
			View and update your personal information: </br>
			(For security reasons it is required to change password every time you update your information) 
			<!-- Information form -->
			<form name='information' id='generalform' action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
				<fieldset>
					<label>First name: <br/><input type="text" name="firstname" maxlength="50" value="<?php echo htmlentities($firstname);?>"/></label><br/>
					<label>Last name: <br/><input type="text" name="lastname" maxlength="50" value="<?php echo htmlentities($lastname);?>"/></label></br>
					<label>Email: <br/><input type="email" name="email" maxlength="100" value="<?php echo htmlentities($email);?>"/></label><br/>
					<label>Phone: <br/><input type="text" name="phone" value="<?php echo htmlentities($phone);?>"/></label><br/>
					<label>Address: <br/><textarea name="address" rows="5" cols="30" maxlength="400"><?php echo htmlentities($address);?></textarea></label>
				</fieldset>
	
				<fieldset>
					<label>Username: <?php echo $username . "<br/><br/>"; ?></label>
					<label>New password: <br/><input type="password" name="password"/></label><br/>
					<label>Re-enter new password: <br/><input type="password" name="chkpassword"/></label><br/>
					<label>Old password: <br/><input type="password" name="oldpassword"/></label>
				</fieldset>

				<fieldset>
					<input type="submit" id="save" value="Save Changes" name='submit' onClick="return validate_input('information')"/><br/>
					<input type="button" id="reset" value="Reset" onClick="location.reload()"/>
				</fieldset>
			</form> <!-- Information form ends -->
		</p>
	</div>
	
<?php 
	shopping_cart($firstname, $lastname);

	//Catch submit-action 
	if (isset($_POST['submit'])) {
	
		//Read variables from form
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = trim(preg_replace('/\s\s+/', ' ', $_POST['address']));
		$password = $_POST['password'];
		$oldpassword = $_POST['oldpassword'];

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
		
		//Search password and salt for username from DB
    	$query = "select password, salt from users where username = '" . $username . "';";
    	$resultset = mysqli_query($conn, $query);

		//If query fails print error and die
		if (!$resultset) {
			echo "FAILURE: Cant retrieve data from database";
			die();
		}

		//If username was found from DB compare password hashes
		if (mysqli_num_rows($resultset) > 0) {

			$data = mysqli_fetch_array($resultset, MYSQLI_ASSOC);
			mysqli_free_result($resultset);
			$hash = hash('sha256', $data['salt'] . hash('sha256', $oldpassword));

			if ($hash == $data['password']) {

				//Encrypt new password using sha256 and salt
				$hash = hash('sha256', $password);
				$salt = generate_salt();
				$hash = hash('sha256', $salt . $hash);

				//Update information to DB
				$query = "update users set firstname='" . $firstname . "', lastname='" . $lastname . "', email='" . $email . 
					"', phone='" . $phone . "', address='" . $address . "', password='" . $hash . "', salt='" . $salt . 
					"' where username='" . $username . "';";

				//If query fails print error and die
				if (!mysqli_query($conn, $query)) {
					echo "FAILURE: SQL-operation failed";
					die();
				}

				//Update session variables according to new data
				$_SESSION['firstname'] = $firstname;
				$_SESSION['lastname'] = $lastname;
				$_SESSION['email'] = $email;
				$_SESSION['phone'] = $phone;
				$_SESSION['address'] = $address;

				//Close DB connection and redirect to updated.php
				mysqli_close($conn);
				header('Location: message.php?header=User information updated successfully.&message=Your information has been updated.</br>Please continue shopping.');
			}

			else {
				//If password is incorrect print error
				echo "<script type='text/javascript'>alert('Updating failed. Incorrect password');</script>";
			}
		}

		else {
			//If for some reason username is not found print error [THIS SHOULD NEVER OCCUR]
			echo "<script type='text/javascript'>alert('Updating failed. Username not found');</script>";
		}

		//Close DB connection
		mysqli_close($conn);
	}

	print_footer();
?>