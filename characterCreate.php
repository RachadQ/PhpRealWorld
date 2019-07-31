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
	// get what posted
	$playername = $_POST["user"]; // $_POST constant always exist
	
	//check if name exist
	$nameCheckQuery = "SELECT name From characterinfo WHERE name='" . $playername . "';"; //SELECT any row from this name coloum, From table players , Row that match the email  concatenate
	
	
	//make query itself
	$nameCheck = mysqli_query($con, $nameCheckQuery) or die("2: name check query failed:'" . mysqli_error($con) ."'" ); //pass in the connection, and this query if query didnt work die 
														//error code #2 - name check query failed
	
	//what did it return
	if(mysqli_num_rows($nameCheck) > 0 )
	{
		//if username exist
		echo "3: name already exists"; //error code #3 name exist can't register
		exit();
		
	}
	
	// put information into database query
	$insertuserquery = "INSERT INTO characterinfo(name) VALUES ('" . $playername . "');";//INSERT INTO character,VALUES

	//excute query
	mysqli_query($con,$insertuserquery) or die("4: insert player query failed"); // error code #4 insert query failed 
	echo(0);// program ran properly

?>