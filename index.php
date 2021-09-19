<!DOCTYPE HTML>
<?php
	require_once("config.php");
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
		<title>鳥類小百科</title>
	</head>
	<body>
		<div class="container-fluid" id="load" style="display:table">
			<div style="display:table-cell" class="w-100 h-100 text-center align-middle">
				<img src="img/flower.svg" alt="" width="100px" height="100px"><br>
				載入中...
			</div>
		</div>
		<div class="container" id="content">
			<h1 class='display-3 text-center font-weight-bold mt-5'>鳥類一覽表</h1>
			<br>
			<table class='table table-hover table-rwd table-bird text-center' id="tablebird">
				<thead class='thead-dark'>
					<tr class="tr-only-hide">
						<th>鳥名</th>
						<th>影片</th>
						<th>百科網頁</th>
						<th>資料來源</th>
						<th>動作</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$result = mysqli_query($link, "select * from `".$mysql_table."`");
					$num = mysqli_num_rows($result);
					if(!empty($num))
					{
						while ($row = mysqli_fetch_array($result))
						{
							?>
								<tr>
									<td data-th="鳥名" class="text-center"><?=$row['name']?></td>
									<td data-th="影片" class="text-center"><a href='https://www.youtube.com/watch?v=<?=$row['youtube']?>'>Youtube</a></td>
									<td data-th="百科網頁" class="text-center"><a href='./bird.php?id=<?=$row['id']?>'>前往</a></td>
									<td data-th="資料來源" class="text-center"><a href='<?=$row['source']?>'><?=$row['srcname']?></a></td>
									<td data-th="動作" class="text-center">
										<a href='./edit.php?id=<?=$row["id"]?>'><i class="fas fa-pen"></i></a>
										&emsp;
										<a href='' class="del" data-id="<?=$row["id"]?>"><i class="fas fa-times"></i></a>
									</td>
								</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>
			<div class="col-12 text-center">
				<a class="btn btn-success" href="./edit.php">新增資料</a>
			</div>
		</div>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/datatables.min.js"></script>
		<script src="js/custom.js"></script>
		<script>
			$(document).ready(function(){
				$("#tablebird").DataTable({
					language: {
						url: 'other/datatables-chinese-traditional.json'
					},
					"columnDefs": [ 
						{
					      "targets": 1,
					      "searchable": true,
						  "orderable": false
					    }, 
						{
					      "targets": 2,
					      "searchable": false,
						  "orderable": false
					    }, 
						{
					      "targets": 4,
					      "searchable": false,
						  "orderable": false
					    },
					],
				});

				$(".del").click(function(e){
					e.preventDefault();
					let d = confirm("確定刪除?");
					if(d) window.location = "./api.php?do=del&id="+$(this).attr("data-id");
				})
			});
		</script>
	</body>
</html>