<?php
//create connection to sql Database
	$con = mysqli_connect('localhost', 'root', 'Barbados12','realworld');//url, username, password //name of database
	
	// check connection
	if(mysqli_connect_errno())// any errors?
	{
		//if has errors
		echo "1: connection failed";//connection failed
		exit();	
	}
	
	$username = $_POST["name"];
	$newScore = $_POST["score"];
	
	//name check query
	$nameCheckQuery = "SELECT username From players WHERE username='" . $username . "';";//SELECT any row from this name column, From table players, Rows that match the username, cacanate .
	
	$nameCheck = mysqli_query($con,$nameCheckQuery)or die("2: name check query failed"); //pass in the connection, and this query if query didnt work die 
	
	//check if they is none or more then 1 user
	if(mysqli_num_rows($nameCheck) != 1)
	{
		echo "5: Either no user with name, or more then one";//error code #5 - numbe of names matching != 1
		exit();
	}
	
	//Update player Database Query
	$updateQuery = "UPDATE players SET score='$newScore' WHERE username='$username'";
	mysqli_query($con,$updateQuery) or die("7: save query failed"); //error code #7 Update query failed
	
	echo "0";
?>
