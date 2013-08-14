mapleWebERP
===========

my Web ERP system



remark

未完成

07152013-
working
purchase request submit
purchase order submit
attrecord subgrid

試試中文的commit能否上傳
版本控制練習

07162013
attrecord 月份控制未完成

07172013
調整My_Controler的設定(重新開啟登入判斷)
attrecord的sub Grid仍無法運作，計劃分開處理

07192013
11:00 => attrecord休假記錄完成，月份功能處理中

07222013

追加需求purchase跟inventory的report功能
需要輸出相關表格，且需可選擇輸出欄位

07232013
月份選擇完成
統計功能製作中
PS：日期計數非整數
一天上班8小時，請假1小時，該日工作天數為0.875
days worked
holiday
annual
因為與google canlendar連動，統計條件不足
off
other
統計條件不明employee leave中無可參照之欄位

07242013
資料表結構修改 employeeAttendance
leaveType追加off(休假),other(其它)(僅修改欄位註解)
other更改欄位屬性 int => varchar(200) 用於補充當休假類別為other時的原因

attRecord.php(control)
修改細部程式
將OFF、other加入出缺勤判斷

attRecord.php(View)
更改leave type，追加off、other

attrecord基本完成

採購、倉儲的report center功能製作中
PS：attrecord,purchase request,purchase order應該需要追加輸出表格的功能

07252013
purchase inventory的report初步構想
purchaseReport、inventoryReport=>僅製作列表功能
reportCenter=>追加，依類別跟序號決定輸出內容
1.type=>輸出類別 1.purchase , 2.inventory
2.sn=>項目序號 ex 1.Current Price List , 2.Supplier List ...etc
3.頁面產生時需產生表格欄位!important(需定義各列表功能所可以選擇的欄位)
4.點選輸出後依所選擇之表格內容輸出列表，並產生excel，pdf的下載按扭

07292013
report center 各列表的部份請對方提供詳細規格


08012013
pdf輸出PO 、MR完成
gr、tm待處理

08022013
pdf輸出GR'TM完成
phpmail匯入完成
部份程式區部調掉(當專案刪除時造成的資料錯亂)
unisun.fusionmedia.com.tw中關閉Purchase Report Center,Inventory Report Centor(功能未完成，先刪除頁面連結)

08132013
資料表purchaseOrder新增欄位
payment
received
inspected
delivered
PO區部調整
project功能調整

08142013
圖紙系統檔案上傳、下載功能完成