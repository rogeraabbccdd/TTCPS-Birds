<!DOCTYPE HTML>
<?php
	require_once("config.php");

	$bird = -1;
	$name = "";
	$youtube = "";
	$description = "";
	$source = "";
	$srcname = "";

	if(!empty($_GET['id']))
	{
		$bird = $_GET['id'];	
		$result = mysqli_query($link, "select * from `".$mysql_table."` where `id` = '".$bird."'");
		$num = mysqli_num_rows($result);
			
		if (!empty($num)) 
		{ 
			$row = mysqli_fetch_array($result);
			$name = $row['name'];
			$youtube = $row['youtube'];
			$description = $row['description'];
			$source = $row['source'];
			$srcname = $row['srcname'];
		}
		else
		{
			?>
				<script>
					alert('找不到這隻鳥');
					window.location = "./edit.php";
				</script>
			<?php
		}
	}
?>
<html lang="zh-tw">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link rel="shortcut icon" href="img/icon.ico" />
	<link rel="bookmark" href="img/icon.ico" />
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/fontawesome-all.min.css">
	<link rel="stylesheet" href="css/datatables.min.css">
	<link rel="stylesheet" href="css/custom.css">
	<title>鳥類小百科 | <?=($bird == -1)?"新增":"編輯".$name?>
	</title>
</head>

<body>
	<div class="container-fluid" id="load" style="display:table">
		<div style="display:table-cell" class="w-100 h-100 text-center align-middle">
			<img src="img/flower.svg" alt="" width="100px" height="100px"><br>
			載入中...
		</div>
	</div>
	<div class="container" id="content">
		<h1 class='display-3 text-center font-weight-bold mt-5'>
			<?=($bird == -1)?"新增資料":$name?>
		</h1>
		<br>
		<form id="form">
			<input type="hidden" id="id" name="id" value="<?=$bird?>">
			<div class="form-group">
				<label for="name">鳥類名稱</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="請輸入鳥類名稱" value="<?=$name?>" required>
			</div>
			<div class="form-group">
				<label for="description">鳥類簡介</label>
				<textarea class="form-control" name="description" id="description" rows="3"><?=$description?></textarea>
			</div>
			<div class="form-group">
				<label for="youtube">影片連結</label>
				<input type="url" class="form-control" id="youtube" name="youtube" placeholder="請輸入Youtube影片網址" value="http://www.youtube.com/watch?v=<?=$youtube?>" required>
			</div>
			<div class="form-group">
				<label for="source">資料來源網址</label>
				<input type="url" class="form-control" id="source" name="source" placeholder="請輸入資料來源網址" value="<?=$source?>" required>
			</div>
			<div class="form-group">
				<label for="srcname">資料來源</label>
				<input type="text" class="form-control" id="srcname" name="srcname" placeholder="請輸入資料來源網站名稱" value="<?=$srcname?>" required>
			</div>
			<button type="submit" class="btn btn-primary">送出</button>
		</form>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/datatables.min.js"></script>
	<script src="js/custom.js"></script>
	<script>
		$(document).ready(function(){
			$("#form").on("submit", function(e){
				e.preventDefault();
				let ytid = GetYTIdByLink($("#youtube").val());
				if(ytid === false) {
					alert("影片網址錯誤");
				}
				else{
					let fd = new FormData(this);
					fd.append("ytid", ytid);
					$.ajax({
						url: "api.php?do=edit",
						data: fd,
						type: "post",
						processData: false,
						contentType: false,
						cache: false,
						dataType:"json",
						success: function(response){
							if(response[0] == "ok"){
								if($("#id").val() == -1){
									window.location = "./edit.php?id="+response[1];
								}
								else {
									alert("保存成功");
									location.reload();
								}
							}
							else  alert(response[1]);
						},
						error: function(xhr, textStatus, errorThrown){
							alert(errorThrown);
						},
					})
				}
			})
		})
		function GetYTIdByLink(url){
			var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
			var match = url.match(regExp);
			return (match&&match[7].length==11)? match[7] : false;
		}
	</script>
</body>

</html>