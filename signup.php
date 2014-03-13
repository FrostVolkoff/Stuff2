<?php
include 'db/connect.php';
include 'includes/header.php';

echo '<h3>Sign up</h3><br />';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo '<form method="post" action="">
 	 	Username: <input type="text" name="user_name" /><br />
 		Password: <input type="password" name="user_pass"><br />
		Password again: <input type="password" name="user_pass_check"><br />
		E-mail: <input type="email" name="user_email"><br />
 		<input type="submit" value="Add category" />
 	 </form>';
}
else
{
	$errors = array();
	
	if(isset($_POST['user_name']))
	{
		if(!ctype_alnum($_POST['user_name']))
		{
			$errors[] = 'The username can only contain letters and numbers.';
		}
		if(strlen($_POST['user_name']) > 30)
		{
			$errors[] = 'The username cannot be longer than 30 characters.';
		}
	}
	else
	{
		$errors[] = 'The username field must not be empty.';
	}
	
	
	if(isset($_POST['user_pass']))
	{
		if($_POST['user_pass'] != $_POST['user_pass_check'])
		{
			$errors[] = 'The two passwords did not match.';
		}
	}
	else
	{
		$errors[] = 'The password field cannot be empty.';
	}
	
	if(!empty($errors))
	{
		echo 'Uh-oh.. a couple of fields are not filled in correctly..<br /><br />';
		echo '<ul>';
		foreach($errors as $key => $value)
		{
			echo '<li>' . $value . '</li>';
		}
		echo '</ul>';
	}
	else
	{
		$sql = "INSERT INTO
					users(user_name, user_pass, user_email ,user_date, user_level)
				VALUES('" . mysql_real_escape_string($_POST['user_name']) . "',
					   '" . sha1($_POST['user_pass']) . "',
					   '" . mysql_real_escape_string($_POST['user_email']) . "',
						NOW(),
						0)";
						
		$result = mysql_query($sql);
		if(!$result)
		{
			echo 'Something went wrong while registering. Please try again later.';
			//echo mysql_error();
		}
		else
		{
			echo 'Succesfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
		}
	}
}

include 'includes/footer.php';
?>
