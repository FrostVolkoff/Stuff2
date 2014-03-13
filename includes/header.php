<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
 	<title>Forum</title>
	<link rel="stylesheet" href="includes/style.css" type="text/css">
</head>
<body>
<div class="main">
	<header>
	<h1>Forum</h1>
	<div class="menu">
		<a class="item" href="index.php">Home</a> -
		<a class="item" href="create_topic.php">Create a topic</a> -
		<a class="item" href="create_cat.php">Create a category</a>
		
		<div class="userbar">
		<?php
		if($_SESSION['signed_in'])
		{
			echo 'Hello <b>' . htmlentities($_SESSION['user_name']) . '</b>. Not you? <a class="item" href="signout.php">Sign out</a>';
		}
		else
		{
			echo '<b><a class="item" href="signin.php">Sign in</a></b> or <b><a class="item" href="signup.php">create an account</a></b>';
		}
		?>
		</div>
	</header>
</div>
		<div id="content">
		<br />