<?php
include 'db/connect.php';
include 'includes/header.php';

$sql = "SELECT
			topic_id,
			topic_subject
		FROM
			topics
		WHERE
			topic_id =" . mysql_real_escape_string($_GET['id']);
			
$result = mysql_query($sql);
?>
<div forum>
<?php
if(!$result)
{
	echo 'O topico nao pode ser apresentado. Por favor contacte o Administrador. ERRO 1';
}
else
{
	if(mysql_num_rows($result) == 0)
	{
		echo 'O topico nao existe';
	}
	else
	{
		while($row = mysql_fetch_assoc($result))
		{
?>
			<table class="tablepost" border=2>
			<?php
			$posts_sql = "SELECT
							posts.post_topic,
							posts.post_content,
							posts.post_date,
							posts.post_by,
							users.user_id,
							users.user_name,
							users.user_level
						FROM
							posts
						LEFT JOIN
							users
						ON
							posts.post_by = users.user_id
						WHERE
							posts.post_topic = " . mysql_real_escape_string($_GET['id']);
			$posts_result = mysql_query($posts_sql);
		
			if(!$posts_result)
			{
				echo 'O topico nao pode ser apresentado. Por favor contacte o Administrador. ERRO 2';
			}
			else
			{
				while($posts_row = mysql_fetch_assoc($posts_result))
				{
		
			?>
					<tr>
					<td rowspan=2 id="tdUser"><?= 'Imagem do Utilizador <p> Ainda nao disponivel!' ?></td>
					<td id="tdData"><?= 'Postado em: ' . date('d-m-Y H:i', strtotime($posts_row['post_date'])) ?></td>
					</tr>
					<tr>
						<td rowspan=2 id="tdBody"><?= htmlentities(stripslashes($posts_row['post_content'])) ?></td>
					</tr>
					<tr>
						<td id="tdUserInf"><?= $posts_row['user_name'] . '' . $posts_row['user_level']?></td>
					</tr>
			</table>
<?php
				}
			}
		}
	}
}
?>

<?php
if(isset($_SESSION['signed_in']))
{
?>
<br />
<table id="tableAnwser">
	<tr>
		<td>
		<form method="post" action="reply.php?id=<?= $row['topic_id'] ?>">
			<textarea name="reply-content"></textarea>
			<br />
			<input type="submit" id="buttonanwser" value="Responder" />
		</form>
		</td>
	</tr>

<?php
}

include 'includes/footer.php';
?>	
