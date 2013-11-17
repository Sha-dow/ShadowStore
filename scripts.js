/////////////////////////////////////////////////
///-------------------------------------------///
///		Javascripts for Assignment 2		  ///
///		Hannu Ranta 2013					  ///
///		All rights reserved					  ///
///-------------------------------------------///
/////////////////////////////////////////////////

//Resets all input fields used in registerform
function reset_fields () {
	
	//Reset all fields
	register.firstname.value="";
	register.lastname.value="";
	register.email.value="";
	register.phone.value="";
	register.address.value="";
	register.username.value="";
	register.password.value="";
	register.chkpassword.value="";
}

//Validates data in registerform 
//and informationform
function validate_input(form) {

	//Variables
	var err_msg = "";

	if (form == 'register')
	{
		var firstname = register.firstname.value;
		var lastname = register.lastname.value;
		var email = register.email.value;
		var phone = register.phone.value
		var address = register.address.value;
		var username = register.username.value;
		var password = register.password.value;
		var chkpassword = register.chkpassword.value;	
	}
	else if (form == 'information')
	{
		var firstname = information.firstname.value;
		var lastname = information.lastname.value;
		var email = information.email.value;
		var phone = information.phone.value
		var address = information.address.value;
		var password = information.password.value;
		var chkpassword = information.chkpassword.value;
	}
	else 
	{
		//This should never be reached...
		alert("Something strange happened...");
	}

	//Regular expressions
	var REemail = /^[\w]+(\.[\w]+)*@([\w\-]+\.)+[a-zA-Z]{2,7}$/;
	var REphone = /^[\d\s\(\)\+\-]{4,20}$/;
	var REpassword = /^[\w\d]{6,20}$/;

	//Validation
	if (firstname == "")
	{
		err_msg += "Please enter your first name";
		err_msg += "\n";
	}
	else if (firstname.length > 50)
	{
		err_msg += "First name you entered is too long";
		err_msg += "\n";
	};

	if (lastname == "")
	{
		err_msg += "Please enter your last name";
		err_msg += "\n";
	}
	else if (lastname.length > 50)
	{
		err_msg += "Last name you entered is too long";
		err_msg += "\n";
	};

	if (email == "")
	{
		err_msg += "Please enter your email";
		err_msg += "\n";
	}
	else if (email != "" && !(REemail.test(email)))
	{
		err_msg += "Please enter valid email";
		err_msg += "\n";
	}
	else if (email.length > 100)
	{
		err_msg += "Your email is too long";
		err_msg += "\n";
	};

	if (!REphone.test(phone)) 
	{
		err_msg += "Please enter valid phone number";
		err_msg += "\n";
	};

	if (address == "")
	{
		err_msg += "Please enter your residential address";
		err_msg += "\n";
	}
	else if (address.length > 400)
	{
		err_msg += "Address you entered is too long";
		err_msg += "\n";
	};

	if (form == 'register')
	{
		if (username == "") 
		{
			err_msg += "Please enter username";
			err_msg += "\n";
		}
		else if (username.length > 50)
		{
			err_msg += "Your username is too long";
			err_msg += "\n";
		}	
	}
	

	if (!REpassword.test(password))
	{
		err_msg += "Please enter valid password (6-20 characters. Only letters, numbers and underscore are accepted)";
		err_msg += "\n"
	}
	else if (password != chkpassword)
	{
		err_msg += "Password-fields do not match. Please check your input carefully"
		err_msg += "\n";
	};

	//Check if there is errors and return false
	if (err_msg != "")
	{
		alert(err_msg);
		return false;
	};

	//If anything is allright return true 
	return true;
}

function addItem(id) {
		document.getElementById("pid").value = id;
	}