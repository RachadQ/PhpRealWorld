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
	
	$user = $_POST["name"]; // $_POST constant always exist
	$password = $_POST["password"];
	$email = $_POST["email"];
	$code;
	
	if(!empty($user) || !empty($password) || !empty($email))
	{
	// check if email verifed
	if(!filter_var($email,FILTER_VALIDATE_EMAIL))
		{	
			echo "invalid email ";
			exit();
		}
		else
		{
			//generate random code
			$code= substr(md5(mt_rand()),0,15);
			
			
			//check if email exist 
			$emailCheckQuery= "SELECT email From players WHERE email='" . $email . "';"; //SELECT any row from this name coloum, From table players , Row that match the email  concatenate
			//check if verfication exist 
			$verified_code_CheckQuery= "SELECT verified_code From players WHERE verified_code='" . $code . "';"; //SELECT any row from this name coloum, From table players , Row that match the verified_code concatenate
		
		
		
			
		
		
			//send verfication code
			$message="Your Activation Code is " . $code ."";
			$subject="Activation code for Real World";
			//send verfication code to
			$to=$email;
			$from="rachadquintyne@gmail.com";
			$body="Your username is ".$user."Activation code is ". $code ." Your wasting time make shit with me pettiness don't suit you";
			$header="From:". $from. "";
		
			mail($to,$subject,$body,$header);
			//echo "Activation code sent";
		}
		
		
		
	
	
	//check if name 
	$nameCheckQuery = "SELECT username From players WHERE username='" . $user . "';";//SELECT any row from this name column, From table players, Rows that match the username, concatenate.

	//make query itself
	$nameCheck = mysqli_query($con, $nameCheckQuery) or die("2: name check query failed"); //pass in the connection, and this query if query didnt work die 
														//error code #2 - name check query failed
	
	//what did it return
	if(mysqli_num_rows($nameCheck) > 1 )
	{
		
		//if username exist
		echo "3: name already exists"; //error code #3 name exist can't register
		exit();
		
	}
	

	
	//add user to table
	//Create salt
	$salt = "\$5\$rounds==5000\$" . "Secrect" . $user . "\$";//S.H.A 256 enctyption \$5
	$hash = crypt($password, $salt);
	
	// put information into database query
	
	$insertuserquery = "INSERT INTO players(username,hash,salt,email,verified_code) VALUES ('" . $user . "', '" . $hash . "', '" . $salt . "', '" . $email . "' , '" . $code . "');";//INSERT INTO players,VALUES
	
	mysqli_query($con,$insertuserquery);
	$last_id = mysqli_insert_id($con);
	error_log($last_id,0);
	//excute player query
	//mysqli_query($con,$insertuserquery) or die("4: insert player query failed ". $error .""); // error code #4 insert query failed 
		
	
	
	//insert id into character 
	//$characterCheckQuery = "SELECT playerId FROM characterinfo WHERE playerId='" . $user_id . "';";
		
	//excute CharacterQuery query
	//$insertCharacterQuery = "INSERT INTO characterinfo(playerId) VALUES ('" .$user_id. "');";
	//mysqli_query($con,$insertCharacterQuery	) or die("5: insert character query failed"); // error code #5 insert query failed 
	
	}
	else
	{
		echo "is empty";
		exit();
	}
	echo(0);// program ran properly
?>