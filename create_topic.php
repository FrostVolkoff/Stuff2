<?php
include 'db/connect.php';
include 'includes/header.php';

if(isset($_GET['cat_id']))
{
	$topic_cat = $_GET['cat_id'];
}

echo '<h2>Criar Topico</h2>';
if($_SESSION['signed_in'] == false)
{
	echo 'Tem que estar com a <a href="/forum/signin.php">Sessao iniciada</a> para criar um topico.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		$sql = "SELECT
					cat_id,
					cat_name,
					cat_description
				FROM
					categories";
		
		$result = mysql_query($sql);
		
		if(!$result)
		{
			echo 'Erro. Por favor contacte o Administrador.';
		}
		else
		{
			if(mysql_num_rows($result) == 0)
			{
				if($_SESSION['user_level'] == 1)
				{
					echo 'Sem categorias criadas.';
				}
				else
				{
					echo 'Antes de adicionar topico, o administrador tem que criar categorias.';
				}
			}
			else
			{
		
				echo '<form method="post" action="">
					Assunto: <input type="text" name="topic_subject" /><br />
					Categoria:'; 
				
				/* echo '<select name="topic_cat">';
					while($row = mysql_fetch_assoc($result))
					{
						echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
					}
				echo '</select><br />';	 */
					
				echo 'Mensagem: <br /><textarea name="post_content" /></textarea><br /><br />
					<input type="submit" value="Criar topico" />
				 </form>';
			}
		}
	}
	else
	{
		$query  = "BEGIN WORK;";
		$result = mysql_query($query);
		
		if(!$result)
		{
			echo 'Ocorreu um erro. Por favor contacte o Administrador.';
		}
		else
		{
			global $cat;
			$sql = "INSERT INTO 
						topics (topic_subject,
							   topic_date,
							   topic_cat,
							   topic_by)
				   VALUES('" . mysql_real_escape_string($_POST['topic_subject']) . "',
							   NOW(),
							   " . mysql_real_escape_string($topic_cat) . ",
							   " . $_SESSION['user_id'] . "
							   )";
			//echo $sql . '<br />' . $cat;
			$result = mysql_query($sql);
			if(!$result)
			{
				echo 'Ocorreu um erro. Por favor contacte o Administrador.<br /><br />' . mysql_error();
				$sql = "ROLLBACK;";
				$result = mysql_query($sql);
			}
			else
			{
				$topicid = mysql_insert_id();
				
				$sql = "INSERT INTO
							posts(post_content,
								  post_date,
								  post_topic,
								  post_by)
						VALUES
							('" . mysql_real_escape_string($_POST['post_content']) . "',
								  NOW(),
								  " . $topicid . ",
								  " . $_SESSION['user_id'] . "
							)";
				$result = mysql_query($sql);
				
				if(!$result)
				{
					echo 'Ocorreu um erro. Por favor contacte o Administrador.<br /><br />' . mysql_error();
					$sql = "ROLLBACK;";
					$result = mysql_query($sql);
				}
				else
				{
					$sql = "COMMIT;";
					$result = mysql_query($sql);
					
					echo 'Topico Criado. <a href="topic.php?id='. $topicid . '">your new topic</a>.';
				}
			}
		}
	}
}

include 'includes/footer.php';
?>
