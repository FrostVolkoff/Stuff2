<?php
include 'db/connect.php';
include 'includes/header.php';

echo '<h2>Criar Categoria</h2>';
if($_SESSION['signed_in'] == false | $_SESSION['user_level'] != 1 )
{
	echo 'Nao tem permissao suficiente para criar categorias. Se acha que isto é um erro, por favor contacte o Administrador.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		echo '<form method="post" action="">
			Nome da Categoria: <input type="text" name="cat_name" /><br />
			Descricao da Categoria:<br /> <textarea name="cat_description" /></textarea><br /><br />
			<input type="submit" value="Adicionar Categoria" />
		 </form>';
		 //Tag da Categoria: <input type="text" name="cat_tag" /><br />
	}
	else
	{
		$sql = "INSERT INTO categories(cat_name, cat_description)
		   VALUES('" . mysql_real_escape_string($_POST['cat_name']) . "',
				 '" . mysql_real_escape_string($_POST['cat_description']) . "')";
		$result = mysql_query($sql);
		if(!$result)
		{
			echo 'Erro' . mysql_error();
		}
		else
		{
			echo 'Categoria criada. <a href="create_cat.php">Criar uma nova?</a>';
		}
	}
}

//include 'includes/footer.php';
?>
