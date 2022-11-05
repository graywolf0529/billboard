<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script src="jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script language="javascript">
		function Refresh_List(){
			$("#Billboard_List tbody").remove();
			$("#Search_List thead,#Search_List tbody").remove();
			var formData = new FormData();
			formData.append('type','List_Billboard');
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
					var table_html = '<tbody><tr>';
					console.log(obj.result);
					
					if(obj.result == "取得佈告成功"){
						for (var i = 0; i < obj.list.length; i++ ) {
							table_html += '<td>' + obj.list[i].sn + '</td><td>' + obj.list[i].title + '</td><td>' + obj.list[i].user_name + '</td><td>' + obj.list[i].update_time + '</td><td><form method="post" action="edit.php"><input type=submit value="編輯" class="n_bt"><input type="hidden" id="sn" name="sn" value="' + obj.list[i].sn + '" /></form></td><td><input type="button" class="del_bt" value="刪除" onclick="Delete_Billboard(\'' + obj.list[i].sn + '\')"/></td></tr><tr>';
						}
					}else if(obj.result == "目前沒有佈告"){
						table_html += '<td colspan=6>目前沒有佈告</td>';
					}else {
						table_html += '<td colspan=6>取得佈告失敗</td>';
					}
					table_html += '</tr></tbody>';
					$("#Billboard_List").append(table_html);
				},error: function(data)
				{
					alert('表格獲取異常');
				}
			})
		}
		function Search_Billboard(){
			$("#Search_List thead,#Search_List tbody").remove();
			var keyword=document.getElementById('keyword').value;
			var formData = new FormData();
			formData.append('type','Search_Billboard');
			formData.append('keyword',keyword);
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
					var table_html = '<thead><tr id="table_title"><td colspan=6><span style="font-size: 14px;color: #eeeeee;">搜尋結果</span></td></tr><tr><th>編號</th><th>標題</th><th>最後操作人員</th><th>最後更新時間</th><th>編輯</th><th>刪除</th></tr></thead><tbody><tr>';
					console.log(obj.result);
					
					if(obj.result == "關鍵字搜尋佈告成功"){
						for (var i = 0; i < obj.list.length; i++ ) {
							table_html += '<td>' + obj.list[i].sn + '</td><td>' + obj.list[i].title + '</td><td>' + obj.list[i].user_name + '</td><td>' + obj.list[i].update_time + '</td><td><form method="post" action="edit.php"><input type=submit value="編輯" class="n_bt"><input type="hidden" id="sn" name="sn" value="' + obj.list[i].sn + '" /></form></td><td><input type="button" class="del_bt" value="刪除" onclick="Delete_Billboard(\'' + obj.list[i].sn + '\')"/></td></tr><tr>';
						}
					}else if(obj.result == "沒有關鍵字相關的佈告"){
						table_html += '<td colspan=6>沒有關鍵字相關的佈告</td>';
					}else {
						table_html += '<td colspan=6>取得佈告失敗</td>';
					}
					table_html += '</tr></tbody>';
					$("#Search_List").append(table_html);
				},error: function(data)
				{
					alert('資料傳輸異常');
				}
			})
		}
		function Delete_Billboard(sn){
			var formData = new FormData();
			formData.append('type','Delete_Billboard');
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
					if(obj.result == "刪除佈告成功"){
						Refresh_List();
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
?>

<table border=0 align=center width=100% bgcolor=#cdd2d4><tr align=center width=40%><td>
<table border=0 align=center cellpadding=6 bordercolor=#bbbbbb width=100%>
<tr align=center>
<td width=10%><font color=#5f6c72><b>搜尋：</b></font></td><td width=70%><input type=text name='keyword' id='keyword' placeholder='請輸入關鍵字'></td>
</tr></table>
</td><td width=140px>
<table border=0 align=center cellpadding=6 bordercolor=#bbbbbb width=100%>
<tr align=center>
<td width=10%><input type='button' class='n_l_bt' id='search' value='進行搜尋' onclick='Search_Billboard()'/></td>
</tr></table>
</td></tr></table>

<table class='n_table' id='Search_List'>
</table>

<table class='n_table' id='Billboard_List'>
<thead><tr id="table_title"><td colspan=6><span style="font-size: 14px;color: #eeeeee;">佈告列表</span></td></tr>
<tr><th>編號</th><th>標題</th><th>最後操作人員</th><th>最後更新時間</th><th>編輯</th><th>刪除</th></tr>
</thead>
</table>

<div id='Respond'></div>
<script language="javascript">
Refresh_List();
</script>
</body>
</html>