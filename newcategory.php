<?php
include 'db/connect.php';
include 'includes/header.php';

$sql = "SELECT
			cat_id,
			cat_name,
			cat_description
		FROM
			categories
		WHERE
			cat_id = " . mysql_real_escape_string($_GET['id']);

$result = mysql_query($sql);
?>
<div forum>
	<table class="tabletitle">
		<tr>
			<td class="tdAll">Topico</td>
			<td class="tdAll">Criado</td>
			<td class="tdAll">Por</td>
			<?php
			if(isset($_SESSION['signed_in']) && $_SESSION['user_level'] == 1)
			{
				echo '<a class="item5" href="create_topic.php?cat_id=' . $_GET['id'] .' ">Criar Topico</a>';
				echo '<a class="item5" href="delete_topic.php">Remover</a> <br />';
			}
			else if(isset($_SESSION['signed_in']))
			{
				echo '<a class="item5" href="create_topic.php">Criar Topico</a>';
			}
			?>
		</tr>
		<table class="tableNotices" border=0>
		<?php
			if(!$result)
			{
				echo 'A categoria nao pode ser apresentada, contacte o Administrador ' . mysql_error();
			}
			else
			{
				if(mysql_num_rows($result) == 0)
				{
					echo 'Esta categoria nao existe';
				}
				else
				{
					while($row = mysql_fetch_assoc($result))
					{
		?>
			<tr>
				<td class="tdAll">
				<?php $sql = "SELECT
								topic_id,
								topic_subject,
								topic_date,
								topic_cat,
								topic_by
							FROM
								topics
							WHERE
								topic_cat = " . mysql_real_escape_string($_GET['id']);
									
					$result = mysql_query($sql);
						
					if(!$result)
					{
						echo 'Os topicos nao poderam ser apresentados, contacte o Administrador';
					}
					else
					{
						if(mysql_num_rows($result) == 0)
						{
							echo 'Nao existem topicos nesta categoria';
						}
						else
						{
							while($row = mysql_fetch_assoc($result))
							{
								echo '<a href="newtopic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a>';
							}
						}
					}
					?>
				</td>
				<td class="tdAll">
					<?php
						$posts_sql = "SELECT
										posts.post_date,
										posts.post_by,
										users.user_name
									FROM
										posts
									LEFT JOIN
										users
									ON
										posts.post_by = users.user_id";
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
					<?= date('d-m-Y H:i', strtotime($posts_row['post_date'])); ?>
						
				</td>
				<td class="tdAll">
					<?= $posts_row['user_name']; ?>
				</td>
			</tr>
		<?php
							}
						}
					}
				}
			}
		?>
		</table>
</div>
			
			
			
			
			
			
			