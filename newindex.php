<?php
include 'db/connect.php';
//include 'db/functions.php';
include 'includes/header.php';

$sql = "SELECT
			categories.cat_id,
			categories.cat_name,
			categories.cat_description,
			COUNT(topics.topic_id) AS topics
		FROM
			categories
		LEFT JOIN
			topics
		ON
			topics.topic_id = categories.cat_id
		GROUP BY
			categories.cat_name, categories.cat_description, categories.cat_id";
			
$result = mysql_query($sql);
?>
<div forum>
	<table class="tabletitle">
		<tr>
			<td>1.Categoria</td>
			<td>2.Ultimo Topico</td>
			<td>3.Descrição</td>
			<?php
			//make this work ASAP!!! DONEEEEEEEEEEEEEEE
			if(isset($_SESSION['signed_in']) && $_SESSION['user_level'] == 1)
			{
				echo '<a class="item5" href="create_cat.php">Criar Categoria</a>';
				echo '<a class="item5" href="delete_cat.php">Apagar</a> <p>';
			}
			?>
		</tr>
	</table>
	<table class="tableNotices" border=0>
	<?php
		if(!$result)
		{
			echo 'As categorias nao poderam ser apresentadas, contacte o administrador';
		}
		else
		{
			if(mysql_num_rows($result) == 0)
			{
				echo 'Nao existem categorias definidas!';
			}
			else
			{
				while($row = mysql_fetch_assoc($result))
				{
	?>
		<tr>
			<td><?= '<a href="newcategory.php?id=' . $row['cat_id']. '">' . $row['cat_name'] . '</a>'; ?></td>
			<td><?php $topicsql = "SELECT
								topic_id,
								topic_subject,
								topic_date,
								topic_cat
							FROM
								topics
							WHERE
								topic_cat = " . $row['cat_id'] . "
							ORDER BY
								topic_date
							DESC
							LIMIT
								1";
								
				$topicsresult = mysql_query($topicsql);
				
				if(!$topicsresult)
				{
					echo 'O ultimo topico nao pode ser apresentado, contacte o Administrador';
				}
				else
				{
					if(mysql_num_rows($topicsresult) == 0)
					{
						echo 'Nao existem topicos nesta categoria';
					}
					else
					{
						while($topicrow = mysql_fetch_assoc($topicsresult))
						echo '<a href="newtopic.php?id=' . $topicrow['topic_id'] . '">' . $topicrow['topic_subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['topic_date']));
					}
				}
				?>
				</td>
				<td><?= $row['cat_description']; ?></td>
		</tr>
	<?php
				}
			}
		}
	?>
	</table>
</div>