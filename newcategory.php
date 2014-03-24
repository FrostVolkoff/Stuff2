<?php
include 'db/connect.php';
include 'includes/header.php';

$catsql = "SELECT
			cat_id,
			cat_name,
			cat_description
			FROM
			categories
			WHERE
			cat_id = " . mysql_real_escape_string($_GET['id']);

$catresult = mysql_query($catsql);
?>

<div forum>
	<table class="tabletitle">
		<tr>
			<td class="tdAll">Topico</td>
			<td class="tdAll">Criado</td>
			<td class="tdAll">Por</td>
			<?php
				if(isset($_SESSION['signed_in']) && $_SESSION['user_level'] == 1){
					echo '<a class="item5" href="create_topic.php?cat_id=' . $_GET['id'] .' ">Criar Topico</a>';
					echo '<a class="item5" href="delete_topic.php">Remover</a> <br />';
				} else if(isset($_SESSION['signed_in'])){
					echo '<a class="item5" href="create_topic.php">Criar Topico</a>';
				}
			?>
		</tr>
	</table>
	
	<table class="tableNotices" border=0>
	<?php
	if(!$catresult){
		echo 'A categoria nao pode ser apresentada, contacte o Administrador ' . mysql_error();
	} else {
		if(mysql_num_rows($catresult) == 0){
			echo 'Esta categoria nao existe';
		} else {
			while($catrow = mysql_fetch_assoc($catresult)){
				$topicsql = "SELECT
								topic_id,
								topic_subject,
								topic_date,
								topic_cat,
								topic_by
							FROM
								topics
							WHERE
								topic_cat = " . mysql_real_escape_string($_GET['id']);

				$topicresult = mysql_query($topicsql);

				if(!$topicresult){
					echo 'Os topicos nao poderam ser apresentados, contacte o Administrador';
				} else {
					if(mysql_num_rows($topicresult) == 0){
						echo 'Nao existem topicos nesta categoria';
					} else {
						while($topicrow = mysql_fetch_assoc($topicresult)){ ?>
						<tr>
							<td>
								<a href="newtopic.php?id=<?= $topicrow['topic_id'] ?>">
									<?= $topicrow['topic_subject'] ?>
								</a>
							</td>
							
							<?php
							$postssql = "SELECT
											posts.post_date,
											posts.post_by,
											users.user_name
										FROM
											posts
										LEFT JOIN
											users
										ON
											posts.post_by = users.user_id";
							
							$postsresult = mysql_query($postssql);

							if(!$postsresult){
								echo 'O topico nao pode ser apresentado. Por favor contacte o Administrador. ERRO 2';
							} else {
								$postsrow = mysql_fetch_assoc($postsresult) ?>
								<td>
									<?= date('d-m-Y H:i', strtotime($postsrow['post_date'])) ?>
								</td>
								
								<td>
									<?= $postsrow['user_name'] ?>
								</td>
								<?php
								
							}
							?>
						</tr>
						<?php
						}
					}
				}
			}
		}
	}
	?>
	</table>
</div>