# billboard

## 執行專案
1. 安裝Apache  
2. 安裝PHP(8.1.12)  
3. 安裝Mysql  
	1. Mysql的相關設定位於 __api.php__ 內  
	2. 建立資料庫(預設名稱：test)和資料表(預設名稱：billboard)  
	3. 資料表內欄位如下  
	
|欄位名稱|欄位類型|設定|
|------:|:----------:|:------------:|
|sn|INT|primary key,unique index,not null,auto incremental|
|title|varchar(50)||
|title|varchar(500)||
|title|varchar(20)||
|update_time|datetime||
|create_time|datetime||

4. 將所有檔案放到Apache的htdocs中  

## 服務架構
1. 首頁 __index.php__
	1. 選擇回到首頁會再次刷新首頁
	2. 功能包含  
		1. 佈告列表  
			列出目前所有佈告，列表中附上編輯與刪除按鈕  
		2. 新增  
			選擇後跳轉至新增頁面(__add.php__)  
		3. 搜尋  
			輸入關鍵字後會產生搜尋結果表格，表格中會列出所有符合的佈告  
		4. 編輯  
			於列表中選擇要編輯的佈告後跳轉至編輯頁面(__edit.php__)  
		5. 刪除  
			於列表中選擇要刪除的佈告進行刪除，之後會自動重新列出目前所有佈告列表  
2. 新增佈告
	1. 選擇回到首頁會跳轉至首頁(__index.php__)
	2. 再次點選新增佈告會重製所有欄位
	3. 選擇新增，若新增成功會自動跳轉回首頁(__index.php__)
3. 編輯佈告
	1. 選擇回到首頁會跳轉至首頁(__index.php__)
	2. 點選新增佈告會跳轉至新增頁面(__add.php__)
	3. 選擇更新，若更新成功會自動跳轉回首頁(__index.php__)

## Api
1. 新增佈告
	1. url：api.php
	2. Api呼叫方式：POST
	3. 參數 
	
|__Body參數__|__格式__|__必填__|__說明__|
|------:|:----------:|:------------:|:------------:|
|type|string|Required|選擇api類型(Add_Billboard)|
|title|string|Required|標題|
|article|string|Required|內文|
|user_name|string|Required|新增人員名稱|

	4. Response：  
		{  
			"result":"新增佈告成功" // 第1種：新增佈告成功;第2種：新增失敗，缺少必要參數;第3種：新增佈告失敗，原因：(附上mysql錯誤原因)  
		}
2. 獲取目前所有佈告
	1. url：api.php
	2. Api呼叫方式：POST
	3. 參數 
	
|__Body參數__|__格式__|__必填__|__說明__|
|------:|:----------:|:------------:|:------------:|
|type|string|Required|選擇api類型(List_Billboard)|

	4. Response：  
		{  
			"result": "取得佈告成功", // 第1種：取得佈告成功;第2種：目前沒有佈告;第3種：取得佈告失敗，原因：(附上mysql錯誤原因)  
			"list": [  
			{  
				"sn": "20",  
				"title": "777",  
				"article": "777",  
				"user_name": "777777",  
				"update_time": "2022-11-05 11:58:19",  
				"create_time": "2022-11-05 11:58:07"  
			},  
			{  
				"sn": "16",  
				"title": "ASD",  
				"article": "ASD",  
				"user_name": "ASD",  
				"update_time": "2022-11-05 11:37:20",  
				"create_time": "2022-11-05 11:37:20"  
			},  
			{  
				"sn": "12",  
				"title": "Try",  
				"article": "Try",  
				"user_name": "Try",  
				"update_time": "2022-11-05 11:33:52",  
				"create_time": "2022-11-05 11:33:52"  
			},  
			{  
				"sn": "10",  
				"title": "Hello",  
				"article": "這是測試佈告",  
				"user_name": "Albert",  
				"update_time": "2022-11-05 11:16:11",  
				"create_time": "2022-11-05 11:16:11"  
			}  
			]  
		}
3. 獲取指定SN資料
	1. url：api.php
	2. Api呼叫方式：POST
	3. 參數 
	
|__Body參數__|__格式__|__必填__|__說明__|
|------:|:----------:|:------------:|:------------:|
|type|string|Required|選擇api類型(Get_Billboard)|
|sn|int|Required|編號|

	4. Response：  
		{  
			"result": "查找指定佈告成功", // 第1種：查找指定佈告成功;第2種：沒有指定SN的佈告;第3種：取得佈告失敗，缺少必要參數;第4種：查找指定佈告失敗，原因：(附上mysql錯誤原因)  
			"list": [  
			{  
				"sn": "18",  
				"title": "WASD",  
				"article": "WASD",  
				"user_name": "WASD",  
				"update_time": "2022-11-05 11:37:34",  
				"create_time": "2022-11-05 11:37:34"  
			}  
		]  
		}
4. 關鍵字搜尋佈告
	1. url：api.php  
	2. Api呼叫方式：POST  
	3. 參數  
	
|__Body參數__|__格式__|__必填__|__說明__|
|------:|:----------:|:------------:|:------------:|
|type|string|Required|選擇api類型(Search_Billboard)|
|keyword|string|Required|關鍵字|

	4. Response：  
		{  
			"result": "關鍵字搜尋佈告成功",// 第1種：關鍵字搜尋佈告成功;第2種：沒有關鍵字相關的佈告;第3種：關鍵字搜尋佈告失敗，缺少必要參數;第4種：關鍵字搜尋佈告失敗，原因：(附上mysql錯誤原因)  
			"list": [  
			{  
				"sn": "18",  
				"title": "WASD",  
				"article": "WASD",  
				"user_name": "WASD",  
				"update_time": "2022-11-05 11:37:34",  
				"create_time": "2022-11-05 11:37:34"  
			},  
			{  
				"sn": "16",  
				"title": "ASD",  
				"article": "ASD",  
				"user_name": "ASD",  
				"update_time": "2022-11-05 11:37:20",  
				"create_time": "2022-11-05 11:37:20"  
			},  
			{  
				"sn": "10",  
				"title": "Hello",  
				"article": "這是測試佈告",  
				"user_name": "Albert",  
				"update_time": "2022-11-05 11:16:11",  
				"create_time": "2022-11-05 11:16:11"  
			}  
		]  
		}
5. 更新佈告
	1. url：api.php
	2. Api呼叫方式：POST
	3. 參數  
	
|__Body參數__|__格式__|__必填__|__說明__|
|------:|:----------:|:------------:|:------------:|
|type|string|Required|選擇api類型(Update_Billboard)|
|sn|int|Required|編號|
|title|string|Required|標題|
|article|string|Required|內文|
|user_name|string|Required|新增人員名稱|

	4. Response：  
		{  
			"result": "更新佈告成功" // 第1種：更新佈告成功;第2種：更新佈告失敗，缺少必要參數;第3種：更新佈告失敗，原因：(附上mysql錯誤原因)  
		}
6. 刪除佈告
	1. url：api.php  
	2. Api呼叫方式：POST  
	3. 參數  
	
|__Body參數__|__格式__|__必填__|__說明__|
|------:|:----------:|:------------:|:------------:|
|type|string|Required|選擇api類型(Delete_Billboard)|
|sn|int|Required|編號|

	4. Response：  
		{  
			"result": "刪除佈告成功" // 第1種：刪除佈告成功;第2種：刪除佈告失敗，缺少必要參數;第3種：刪除佈告失敗，原因：(附上mysql錯誤原因)  
		}