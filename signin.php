<?php
include 'db/connect.php';
include 'includes/header.php';

echo '<h3>Sign in</h3><br />';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	echo 'Ja está com a sessao iniciada, pode <a href="signout.php">Terminar sessão</a> caso não seja o seu utilizador.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		echo '<form method="post" action="">
			Nome de Utilizador: <input type="text" name="user_name" /><br />
			Password: <input type="password" name="user_pass"><br />
			<input type="submit" value="Sign in" />
		 </form>';
	}
	else
	{
		$errors = array();
		
		if(!isset($_POST['user_name']))
		{
			$errors[] = 'O nome de utilizador nao pode ficar em branco.';
		}
		
		if(!isset($_POST['user_pass']))
		{
			$errors[] = 'A password nao pode ficar em branco.';
		}
		
		if(!empty($errors))
		{
			echo 'Os campos nao foram preenchidos corretamente.<br /><br />';
			echo '<ul>';
			foreach($errors as $key => $value)
			{
				echo '<li>' . $value . '</li>'; 
			}
			echo '</ul>';
		}
		else
		{
			$sql = "SELECT 
						user_id,
						user_name,
						user_level
					FROM
						users
					WHERE
						user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
					AND
						user_pass = '" . sha1($_POST['user_pass']) . "'";
						
			$result = mysql_query($sql);
			if(!$result)
			{
				echo 'Ocorreu um erro. Por favor contacte o Administrador.';
				//echo mysql_error();
			}
			else
			{
				if(mysql_num_rows($result) == 0)
				{
					echo 'Nome de Utilizador ou password errados.';
				}
				else
				{
					$_SESSION['signed_in'] = true;
					
					while($row = mysql_fetch_assoc($result))
					{
						$_SESSION['user_id'] 	= $row['user_id'];
						$_SESSION['user_name'] 	= $row['user_name'];
						$_SESSION['user_level'] = $row['user_level'];
					}
					
					echo 'Bem vindo, ' . $_SESSION['user_name'] . '. <br /><a href="newindex.php">Proceder para o forum</a>.';
				}
			}
		}
	}
}

include 'includes/footer.php';
?>