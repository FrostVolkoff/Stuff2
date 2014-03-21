<?php
include 'db/connect.php';
include 'includes/header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	echo 'Ocorreu um erro. Por favor contacte o Administrador.';
}
else
{
	if(!$_SESSION['signed_in'])
	{
		echo 'Precisa de ter <a href="signin.php>inciar sessao</a> para responder ao topico."';
	}
	else
	{
		$sql = "INSERT INTO 
					posts(post_content,
						  post_date,
						  post_topic,
						  post_by) 
				VALUES ('" . $_POST['reply-content'] . "',
						NOW(),
						" . mysql_real_escape_string($_GET['id']) . ",
						" . $_SESSION['user_id'] . ")";
						
		$result = mysql_query($sql);
						
		if(!$result)
		{
			echo 'Ocorreu um erro. Por favor contacte o Administrador.';
		}
		else
		{
			echo 'Resposta adicionada! <a href="topic.php?id=' . htmlentities($_GET['id']) . '">Topico</a>.';
		}
	}
}

include 'includes/footer.php';
?>