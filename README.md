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
