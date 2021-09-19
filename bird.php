<!DOCTYPE HTML>
<?php
	require_once("config.php");
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
					window.history.back();
				</script>
			<?php
		}
	}
	else
	{
		?>
			<script>
				alert('找不到這隻鳥');
				window.history.back();
			</script>
		<?php
	}
?>
<html lang="zh-tw">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<link rel="shortcut icon" href="img/icon.ico"/>
		<link rel="bookmark" href="img/icon.ico"/>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/fontawesome-all.min.css">
		<link rel="stylesheet" href="css/datatables.min.css">
		<link rel="stylesheet" href="css/custom.css">
		<title>鳥類小百科 | <?=$name?></title>
	</head>
	<body>
		<div class="container-fluid" id="load" style="display:table">
			<div style="display:table-cell" class="w-100 h-100 text-center align-middle">
				<img src="img/flower.svg" alt="" width="100px" height="100px"><br>
				載入中...
			</div>
		</div>
		<div class="container text-center" id="content">
			<h1 class='display-3 font-weight-bold mt-5'><?=$name?></h1>
			<br>
			<?php
				if(!empty($youtube))
				{
					?>
						<div id='player' class="d-block mx-auto"></div>
					<?php
				}
			?>
			<br>
			<br>
			<p><?=$description?></p>
			<br>
			<br>
			資料來源：<a href='<?=$source?>'><?=$srcname?></a>
		</div>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/datatables.min.js"></script>
		<script src="js/custom.js"></script>
		<script>
			var tag = document.createElement('script');
			tag.src = 'https://www.youtube.com/iframe_api';
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			var player;
			function onYouTubeIframeAPIReady() 
			{
				player = new YT.Player('player', {
					height: '315',
					width: '560',
					videoId: '<?=$youtube?>',
					playerVars: { 
						'autoplay': 1,
						'rel': 0,
					},
					events: {
						'onReady': onPlayerReady
					}
				});
			}

			function onPlayerReady(event) 
			{
				event.target.playVideo();
				event.target.setPlaybackQuality('hd720');
				event.target.setVolume(100);
			}
		</script>
	</body>
</html>