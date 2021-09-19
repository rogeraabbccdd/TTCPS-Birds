<?php
	$mysql_ip = "";
	$mysql_user = "";
	$mysql_pass = "";
	$mysql_db = "";
	$mysql_table = "bird";

	$link = mysqli_connect($mysql_ip, $mysql_user, $mysql_pass, $mysql_db);
	mysqli_set_charset($link, "utf8");
	mysqli_query($link, "set names utf8");
?>