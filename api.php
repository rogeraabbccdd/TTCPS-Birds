<?php
	require_once("config.php");

	function EscapeFormData(&$post)
	{
		global $link;
		foreach($post as $p){
			$p = mysqli_real_escape_string($link, $p);
		}
	}
	
	switch($_GET["do"])
	{
		case "del":
			$query = mysqli_query($link, "delete from ".$mysql_table." where id = '".$_GET["id"]."'");
			header("location:./index.php");
			break;
		case "edit":
			EscapeFormData($_POST);
			if($_POST["id"] != -1){
				$query = mysqli_query($link, "update ".$mysql_table." set
					name = '".$_POST["name"]."',
					youtube = '".$_POST["ytid"]."',
					description = '".$_POST["description"]."',
					source = '".$_POST["source"]."',
					srcname = '".$_POST["srcname"]."'
					where id = '".$_POST["id"]."'
				");
				if($query)	$return = array("ok");
				else {
					$return = array("x", mysqli_error($link));
				}
			}
			else{
				$query = mysqli_query($link, "
				insert into ".$mysql_table." values(null, 
				'".$_POST["name"]."', '".$_POST["ytid"]."', '".$_POST["description"]."', '".$_POST["source"]."', '".$_POST["srcname"]."'
				)");
				if($query){
					$return = array("ok", mysqli_insert_id($link));
				}
				else {
					$return = array("x", mysqli_error($link));
				}
			}
			echo json_encode($return);
			break;
	}
?>