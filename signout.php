<?php
include 'db/connect.php';
include 'includes/header.php';

echo '<h2>Sign out</h2>';

if($_SESSION['signed_in'] == true)
{
	$_SESSION['signed_in'] = NULL;
	$_SESSION['user_name'] = NULL;
	$_SESSION['user_id']   = NULL;

	echo 'Sessao Terminada, obrigado pela visita.';
}
else
{
	echo 'Nao tem sessão iniciada. Deseja <a href="signin.php">iniciar sessão</a>?';
}

include 'includes/footer.php';
?>