<?php
include 'db/connect.php';
include 'includes/header.php';

$sql = "SELECT
			topic_id,
			topic_subject
		FROM
			topics
		WHERE
			topics.topic_id = " . mysql_real_escape_string($_GET['id']);
			
$result = mysql_query($sql);

if(!$result)
{
	echo 'O topico nao pode ser apresentado. Por favor contacte o Administrador.';
}
else
{
	if(mysql_num_rows($result) == 0)
	{
		echo 'O topico nao existe.';
	}
	else
	{
		while($row = mysql_fetch_assoc($result))
		{
			echo '<table class="topic" border="1">
					<tr>
						<th colspan="2">' . $row['topic_subject'] . '</th>
					</tr>';
			$posts_sql = "SELECT
						posts.post_topic,
						posts.post_content,
						posts.post_date,
						posts.post_by,
						users.user_id,
						users.user_name
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
				echo '<tr><td>Os topicos nao poderam ser apresentados. Por favor contacte o Administrador.</tr></td></table>';
			}
			else
			{
			
				while($posts_row = mysql_fetch_assoc($posts_result))
				{
					echo '<tr class="topic-post">
							<td class="user-post">' . $posts_row['user_name'] . '<br/>' . date('d-m-Y H:i', strtotime($posts_row['post_date'])) . '</td>
							<td class="post-content">' . htmlentities(stripslashes($posts_row['post_content'])) . '</td>
						  </tr>';
				}
			}
			
			if(!$_SESSION['signed_in'])
			{
				echo '<tr><td colspan=2>Precisa de ter a <a href="signin.php">sessao iniciada</a> para responder.';
			}
			else
			{
				echo '<tr><td colspan="2"><h2>Resposta:</h2><br />
					<form method="post" action="reply.php?id=' . $row['topic_id'] . '">
						<textarea name="reply-content"></textarea><br /><br />
						<input type="submit" value="Responder" />
					</form></td></tr>';
			}
			
			echo '</table>';
		}
	}
}

include 'includes/footer.php';
?>