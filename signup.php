<?php
include 'db/connect.php';
include 'includes/header.php';

echo '<h3>Sign up</h3><br />';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo '<form method="post" action="">
 	 	Nome de Utilizador: <input type="text" name="user_name" /><br />
 		Password: <input type="password" name="user_pass"><br />
		Password again: <input type="password" name="user_pass_check"><br />
		E-mail: <input type="email" name="user_email"><br />
 		<input type="submit" value="Register" />
 	 </form>';
}
else
{
	$errors = array();
	
	if(isset($_POST['user_name']))
	{
		if(!ctype_alnum($_POST['user_name']))
		{
			$errors[] = 'O nome de utilizador apenas pode conter letras ou numeros.';
		}
		if(strlen($_POST['user_name']) > 30)
		{
			$errors[] = 'O nome de utilizador nao pode ter mais de 30 caracteres.';
		}
	}
	else
	{
		$errors[] = 'O nome de utilizador nao pode ficar em branco.';
	}
	
	
	if(isset($_POST['user_pass']))
	{
		if($_POST['user_pass'] != $_POST['user_pass_check'])
		{
			$errors[] = 'As password nao sao iguais.';
		}
	}
	else
	{
		$errors[] = 'A password nao pode ficar em branco.';
	}
	
	if(!empty($errors))
	{
		echo 'Os campos nao foram preenchidos de forma correta.<br /><br />';
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
			echo 'Ocorreu um erro. Por favor contacte o Administrador.';
			//echo mysql_error();
		}
		else
		{
			echo 'Registado. Pode agora <a href="signin.php">iniciar sessao</a> e comecar a postar';
		}
	}
}

include 'includes/footer.php';
?>
