<?php
$servername = "localhost:3603";
$username = "root";
$password = ".a^]jMEbRdj0D)h,V7LNepq8%FwpNn";
$dbname="test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}else{
	$Time=date("Y-m-d_H:i:s");
}
// Set Chinese
$conn->query("set names utf8");

$respond_arr = array();
switch ($_POST["type"]) {
	case "Add_Billboard": // 新增佈告
		if(isset($_POST["title"])&&isset($_POST["article"])&&isset($_POST["user_name"])){
			$sql = "INSERT billboard (title,article,user_name,update_time,create_time) values ('".$_POST["title"]."','".$_POST["article"]."','".$_POST["user_name"]."',now(),now())";
			if ($conn->query($sql) === TRUE) {
				$respond_arr["result"] = "新增佈告成功";
			} else {
				$respond_arr["result"] = "新增佈告失敗，原因：". $conn->error;
			}
		}else{
			$respond_arr["result"] = "新增失敗，缺少必要參數";
		}
		break;
	case "List_Billboard": // 獲取目前所有佈告
		$sql = "SELECT * FROM billboard ORDER BY update_time DESC";
		$sql_result = $conn->query($sql);
		if (mysqli_num_rows($sql_result)!=0) {
			$List_array = array();
			while($row = $sql_result->fetch_assoc()) {
				array_push($List_array,$row);
			}
			$respond_arr["result"] = "取得佈告成功";
			$respond_arr["list"] = $List_array;
		} elseif(mysqli_num_rows($sql_result)==0){
			$respond_arr["result"] = "目前沒有佈告";
		} else {
			$respond_arr["result"] = "取得佈告失敗，原因：". $conn->error;
		}
		break;
	case "Get_Billboard": // 編輯佈告時獲取舊資料
		if(isset($_POST["sn"])){
			$sql = "SELECT * FROM billboard WHERE sn=".$_POST["sn"];
			$sql_result = $conn->query($sql);
			if (mysqli_num_rows($sql_result)!=0) {
				$List_array = array();
				while($row = $sql_result->fetch_assoc()) {
					array_push($List_array,$row);
				}
				$respond_arr["result"] = "查找指定佈告成功";
				$respond_arr["list"] = $List_array;
			} elseif(mysqli_num_rows($sql_result)==0){
				$respond_arr["result"] = "沒有指定SN的佈告";
			} else {
				$respond_arr["result"] = "查找指定佈告失敗，原因：". $conn->error;
			}
		}else{
			$respond_arr["result"] = "取得佈告失敗，缺少必要參數";
		}
		break;
	case "Search_Billboard": // 關鍵字搜尋佈告
		if(isset($_POST["keyword"])){
			$sql = "SELECT * FROM billboard WHERE sn LIKE '%".$_POST["keyword"]."%' OR title LIKE '%".$_POST["keyword"]."%' OR article LIKE '%".$_POST["keyword"]."%' OR user_name LIKE '%".$_POST["keyword"]."%' OR update_time LIKE '%".$_POST["keyword"]."%' OR create_time LIKE '%".$_POST["keyword"]."%' ORDER BY update_time DESC";
			$sql_result = $conn->query($sql);
			if (mysqli_num_rows($sql_result)!=0) {
				$List_array = array();
				while($row = $sql_result->fetch_assoc()) {
					array_push($List_array,$row);
				}
				$respond_arr["result"] = "關鍵字搜尋佈告成功";
				$respond_arr["list"] = $List_array;
			} elseif(mysqli_num_rows($sql_result)==0){
				$respond_arr["result"] = "沒有關鍵字相關的佈告";
			} else {
				$respond_arr["result"] = "關鍵字搜尋佈告失敗，原因：". $conn->error;
			}
		}else{
			$respond_arr["result"] = "關鍵字搜尋佈告失敗，缺少必要參數";
		}
		break;
	case "Update_Billboard": // 更新佈告
		if(isset($_POST["sn"])&&isset($_POST["title"])&&isset($_POST["article"])&&isset($_POST["user_name"])){
			$sql = "UPDATE billboard SET title='".$_POST["title"]."',article='".$_POST["article"]."',user_name='".$_POST["user_name"]."',update_time=now() WHERE sn=".$_POST["sn"];
			if ($conn->query($sql) === TRUE) {
				$respond_arr["result"] = "更新佈告成功";
			} else {
				$respond_arr["result"] = "更新佈告失敗，原因：". $conn->error;
			}
		}else{
			$respond_arr["result"] = "更新佈告失敗，缺少必要參數";
		}
		break;
	case "Delete_Billboard": // 刪除佈告
		if(isset($_POST["sn"])){
			$sql = "DELETE from billboard WHERE sn=".$_POST["sn"];
			if ($conn->query($sql) === TRUE) {
				$respond_arr["result"] = "刪除佈告成功";
			} else {
				$respond_arr["result"] = "刪除佈告失敗，原因：". $conn->error;
			}
		}else{
			$respond_arr["result"] = "刪除佈告失敗，缺少必要參數";
		}
		break;
	default:
		$respond_arr["result"] = "請輸入正確類型";
		break;
}
echo json_encode($respond_arr,JSON_UNESCAPED_UNICODE); // 將結果轉為json編碼
?>