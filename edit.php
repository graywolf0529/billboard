<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script src="jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script language="javascript">
		function Update_Billboard(sn){
			var title=document.getElementById('title').value;
			var article=document.getElementById('article').value;
			var user_name=document.getElementById('user_name').value;
			if(!title){
				alert('請輸入標題');
			}else if(!article){
				alert('請輸入內文');
			}else if(!user_name){
				alert('請輸入新增人員');
			}else{
				var formData = new FormData();
				formData.append('type','Update_Billboard');
				formData.append('sn',sn);
				formData.append('title',title);
				formData.append('article',article);
				formData.append('user_name',user_name);
				$.ajax({
					url:'api.php',
					type : 'POST',
					mimeType: 'multipart/form-data',
					data : formData,
					contentType: false,
					cache: false,
					processData: false,
					success : function(data)
					{
						var obj = JSON.parse(data); // 解析json字串為json物件形式
						if(obj.result == "更新佈告成功"){
							location.replace('index.php');
						}
					},error: function(data)
					{
						alert('資料傳輸異常');
					}
				})
			}
		}
		function Get_Billboard(sn){
			var formData = new FormData();
			formData.append('type','Get_Billboard');
			formData.append('sn',sn);
			$.ajax({
				url:'api.php',
				type : 'POST',
				data : formData,
				contentType: false,
				cache: false,
				processData: false,
				success : function(data)
				{
					var obj = JSON.parse(data);//解析json字串為json物件形式
					console.log(obj.result);
					if(obj.result == "查找指定佈告成功"){
						document.getElementById('title').value = obj.list[0].title;
						document.getElementById('article').value = obj.list[0].article;
						document.getElementById('user_name').value = obj.list[0].user_name;
					}
				},error: function(data)
				{
					alert('資料傳輸異常');
				}
			})
		}
	</script>
</head>
<body>
<?php
include("menu_table.php");
if($_POST["sn"]!=0 && is_numeric($_POST["sn"])){
	echo "<script language=\"javascript\">Get_Billboard(".$_POST["sn"].");</script>";
}else{
	echo "<script language=\"javascript\">location.replace('index.php');</script>";
}
?>

<table class='n_table' id='edit_table' style='width=100%'>
<thead><tr id='table_title'>
<td colspan=2><span style='font-size: 14px;color: #eeeeee;'>編輯佈告</span></td>
</tr></thead>
<tr align=center>
<td>標題</td>
<td><input type=text name='title' id='title' placeholder='標題'></td>
</tr>
<tr align=center>
<td>內文</td>
<td><input type=text name='article' id='article' placeholder='內文'></td>
</tr>
<tr align=center>
<td><input type=text name='user_name' id='user_name' placeholder='編輯人員'></td>
<td>
<?php
if($_POST["sn"]!=0 && is_numeric($_POST["sn"])){
	echo "<input id='add' type=button value='更新' class='n_l_bt' onclick=\"Update_Billboard('".$_POST["sn"]."')\"/>";
}
?>
</td>
</tr></table>

<div id='Respond'></div>
</body>
</html>