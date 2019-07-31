<?php
	//create connection to sql Database
	$con = mysqli_connect('localhost', 'root', 'Barbados12','realworld');//url, username, password //name of database
	//$con = mysqli_connect('localhost', 'id9950826_admin', 'Barbados12','id9950826_realworld');//url, username, password //name of database
	// check connection
	if(mysqli_connect_errno())// any errors?
	{
		//if has errors
		echo "1: connection failed";//connection failed
		exit();	
	}
	// get what posted
	$username = mysqli_real_escape_string($con,$_POST["name"]);// $_POST constant always exist
	//strip anything not looking for
	$usernameClean = filter_var($username,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	if($username != $usernameClean)
	{
		echo "error ";
		exit();
	}
	$password = $_POST["password"];
	
	//check if name exist
	$nameCheckQuery = "SELECT username, salt, hash, score From players WHERE username='" . $usernameClean . "';";//SELECT any row from this name column, From table players, Rows that match the username, cacanate .
	
	
	//make query itself
	$nameCheck = mysqli_query($con, $nameCheckQuery) or die("2: name check query failed"); //pass in the connection, and this query if query didnt work die 
														//error code #2 - name check query failed
	//check if they is none or more then 1 user
	if(mysqli_num_rows($nameCheck) != 1)
	{
		echo "5: Either no user with name, or more then one";//error code #5 - numbe of names matching != 1
		exit();
	}
	
	//get loging info from query
	$existingInfo = mysqli_fetch_assoc($nameCheck);
	$salt = $existingInfo["salt"];
	$hash = $existingInfo["hash"];
	
	$logInHash = crypt($password,$salt);
	if($hash !=	 $logInHash)
	{
		echo "6 Incorrect password"; // error code #6 - password does not hash to match table
		exit();
		
	}
	
	//did log in successfully
	echo "0\t" . $existingInfo["score"];
?>