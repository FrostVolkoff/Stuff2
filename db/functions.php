<?php

 function showCat($tag = NULL){
	if (!isset($tag))
	{

	}
	else
	{
	$sql = "SELECT *
			FROM
				categories
			WHERE
				tag = " . $tag;
	}
	$result = mysql_query($sql);
 }


?>