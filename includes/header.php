<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
 	<title>Stuff</title>
	<link rel="stylesheet" href="includes/style.css" type="text/css">
</head>
<body>
<div class="main">
	<header>
	<h1>Stuff</h1> <!-- tornar isto numa imagem !! -->
	<div class="mainMenu">
		<a class="item1" href="portal.php">Portal</a>
		<a class="item2" href="newindex.php">Forum</a>
		<a class="item3" href="#">Procurar</a>
		<a class="item4" href="#">Membros</a>
		<!-- <a class="item" href="create_topic.php">Create a topic</a> -
		<a class="item" href="create_cat.php">Create a category</a> -->
		
		<div class="userbar">
		<?php
		if(isset($_SESSION['signed_in']))
		{
			echo 'Bem-Vindo <b>' . htmlentities($_SESSION['user_name']) . '</b>.<a class="item" href="signout.php"> Sair</a>';
		}
		else
		{
			echo '<b><a class="item" href="signin.php">Entrar</a></b> or <b><a class="item" href="signup.php">Registar</a></b>';
		}
		?>
		</div>
	</header>
</div>
		<div id="content">
		<br />