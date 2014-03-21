<?php
include 'db/connect.php';
include 'includes/header.php';

//protectPage(); hummm ... conheco isto de algum lado ... meh, anyways ... 

if(isset($_POST['submit']))
{
mysql_query("DELETE FROM categories where cat_id = '".$_POST['hid_catid']."'");
}

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
			//make this work ASAP!!!
			if(isset($_SESSION['signed_in']) && $_SESSION['user_level'] == 1)
			{
				echo '<a class="item5" href="create_cat.php">Criar Categoria</a>';
				//echo '<a class="item5" href="delete_cat.php">Delete</a> <p>';
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
			<td><?= '<a href="category.php?id=' . $row['cat_id']. '">' . $row['cat_name'] . '</a>'; ?></td>
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
					echo 'O ultimo topico nao pode ser visualizado.';
				}
				else
				{
					if(mysql_num_rows($topicsresult) == 0)
					{
						echo 'no topics';
					}
					else
					{
						while($topicrow = mysql_fetch_assoc($topicsresult))
						echo '<a href="topic.php?id=' . $topicrow['topic_id'] . '">' . $topicrow['topic_subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['topic_date']));
						
					}
				}
				?>
				</td>
				<td><?= $row['cat_description']; ?></td>
				
				<?php
					if(isset($_SESSION['signed_in']) && $_SESSION['user_level'] == 1)
					{
				?>
					<td>
						<form method="post">
							<input type="hidden" name="hid_catid" id="hid_catid" value="<?= $row['cat_id'] ?>">
							<input type="submit" name="submit" value="Remover" />
						</form>
					</td>
				<?php
				}
				?>
					
		</tr>
	<?php
				}//fecha o while
			}//fecha o else
		}// fecha o else
	?>
	</table>
</div>
