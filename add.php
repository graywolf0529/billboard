<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script src="jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script language="javascript">
		function Add_Billboard(){
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
				formData.append('type','Add_Billboard');
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
						if(obj.result == "新增佈告成功"){
							location.replace('index.php');
						}
					},error: function(data)
					{
						alert('資料傳輸異常');
					}
				})
			}
		}
	</script>
</head>
<body>
<?php
include("menu_table.php");
?>

<table class='n_table' id='add_table' style='width=100%'>
<thead><tr id='table_title'>
<td colspan=2><span style='font-size: 14px;color: #eeeeee;'>新增佈告</span></td>
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
<td><input type=text name='user_name' id='user_name' placeholder='新增人員名稱'></td>
<td><input id='add' type=submit value="新增" class='n_l_bt' onclick='Add_Billboard()'></td>
</tr></table>

<div id='Respond'></div>
</body>
</html>