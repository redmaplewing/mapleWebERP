<?php

	require_once("../config.inc.php");
	
	$table="project";
	$tableID=$table.'ID';		
	
	//$mydb->debug=true;
	
	$page = 1;
	$limit=25;
	$sidx='cDate';
	$sord = "desc";
	if(isset($_REQUEST['page']) && $_REQUEST['page'] !='')
		$page = $_REQUEST['page']; // REQUEST the requested page
	if(isset($_REQUEST['rows']) && $_REQUEST['rows'] !='')
		$limit = $_REQUEST['rows']; // REQUEST how many rows we want to have into the grid
	
	if(isset($_REQUEST['sord']) && $_REQUEST['sord'] !='')
		$sord = $_REQUEST['sord']; // REQUEST the direction
	
	

	$start = $limit*$page - $limit;
/*
	if(isset($_REQUEST['queryMethod']))
		$_SESSION['queryMethod']=$_REQUEST['queryMethod'];
	if(isset($_REQUEST['searchName']))
		$_SESSION['searchName']=$_REQUEST['searchName'];
	if(isset($_REQUEST['searchNo']))
		$_SESSION['searchName']=$_REQUEST['searchNo'];
	if(isset($_REQUEST['searchManagerID']))
		$_SESSION['searchManagerID']=$_REQUEST['searchManagerID'];
	if(isset($_REQUEST['searchNo']))
		$_SESSION['searchNo']=$_REQUEST['searchNo'];
		
	if(isset($_REQUEST['forewordTypeID'])){	
		$_SESSION['forewordTypeID']=$_REQUEST['forewordTypeID'];
	}elseif(isset($_POST['forewordTypeID']))	{
		$_SESSION['forewordTypeID']=$_POST['forewordTypeID'];
	}
	if(!isset($_SESSION['forewordTypeID']))
		$_SESSION['forewordTypeID']=0;
		
	foreach($projStat as $pk => $pv)
		if(isset($_REQUEST['sType'.$pv['idx']]))
			$_SESSION['sType'.$pv['idx']] = $_REQUEST['sType'.$pv['idx']];
		

	$subSearchQuery=" and tmp=0 and lang='".$_SESSION['lang']."'";
	*/
	$subSearchQuery=" and tmp=0 ";
	//if(isset($_REQUEST['filter'])){
	//	$filter = json_decode($_REQUEST['filter']);
	//	foreach($filter['rules'] as $k => $v){
			
	//	}
	//}
	/*		
	if(!empty($_SESSION['searchName'])){
		//$subSearchQuery.=" and (`$name` like '%".$_SESSION['searchName']."%' or projectNo like '%".$_SESSION['searchName']."%')";
		$subSearchQuery.=" and (`$name` like '%".$_SESSION['searchName']."%'";
		$subSearchQuery.=" or customerID in(select forewordID from foreword where menuID in(476,482) and name like '%".$_SESSION['searchName']."%'))";
		
	}
	if(!empty($_SESSION['searchNo'])){
		$subSearchQuery.=" and `projectNo` like '%".$_SESSION['searchNo']."%'";
	}
	
	if($_SESSION['forewordTypeID'])
		$subSearchQuery.=" and forewordTypeID=".$_SESSION['forewordTypeID'];	
	*/
	$tmpStat1 = array();
	$tmpStat2 = array();
	$statCnt = 0;
	
	//print_r($_SESSION);

	foreach($projStat as $pk => $pv){
		//echo $pv['idx']."<br />";
		if(isset($_SESSION['sType'.$pv['idx']]) && $_SESSION['sType'.$pv['idx']]==1){
			$tmpStat1[]="projStat" . $pv['idx'] . "=" . $_SESSION['sType'.$pv['idx']];
			$statCnt++;
		}else 
			$tmpStat2[]="projStat" . $pv['idx'] . "=0";
	}
	
	if($statCnt>0){
		if(count($tmpStat1)==1)
			//if(count($tmpStat1>0)) $subSearchQuery .= " and  (".implode(" ".$_SESSION['queryMethod']." ",$tmpStat1).")";
			$subSearchQuery .= " and " . $tmpStat1[0];
		else { 
			if(count($tmpStat1>0)) $subSearchQuery .= " and  (".implode(" ".$_SESSION['queryMethod']." ",$tmpStat1).")";
			if(count($tmpStat2>0)) $subSearchQuery .= " and ".implode(" and ",$tmpStat2);
		}
	}
	/*
	if(!isset($_SESSION['doSearch']) && $statCnt==0)
		$subSearchQuery .= " and projStat4=0 and projStat5=0";
	//echo $_SESSION['sType5']."<br />";
	if(isset($_SESSION['sType5']) && $_SESSION['sType5'] == 0 && $_SESSION['searchNo'] == ""){
		$subSearchQuery .= " and projStat5=0";
	}
	
	if($_SESSION['sSDate']!='')
		$subSearchQuery .= " and sDate>='".$_SESSION['sSDate']."'";
	if($_SESSION['sEDate']!='')
		$subSearchQuery .= " and sDate<='".$_SESSION['sEDate']."'";
	if($_SESSION['eSDate']!='')
		$subSearchQuery .= " and eDate>='".$_SESSION['eSDate']."'";
	if($_SESSION['eEDate']!='')
		$subSearchQuery .= " and eDate<='".$_SESSION['eEDate']."'";
	if($_SESSION['preSDate']!='')
		$subSearchQuery .= " and preEDate>='".$_SESSION['preSDate']."'";
	if($_SESSION['preEDate']!='')
		$subSearchQuery .= " and preEDate<='".$_SESSION['preEDate']."'";	
	*/
	
	//只有最高管理者可看到此單元全部資料
	//$mydb->debug=true;
	//$searchProjectID = array();
//	$adminFlag = $_SESSION['adminFlag'];
	/*
	$managerSQL = "";
	if(!$_SESSION['adminFlag'] && isset($_SESSION['searchManagerID']) && !empty($_SESSION['searchManagerID'])){
		$managerSQL = "select projectID from workMember where forewordTypeID in(126, 332) and managerID=".$_SESSION['searchManagerID']." group by projectID";	
	} elseif(!$_SESSION['adminFlag'] && !isset($_SESSION['searchManagerID'])) {
		$managerSQL = "select projectID from workMember where forewordTypeID in(126, 332) and managerID=".$_SESSION['managerID']." group by projectID";	
	}  elseif($_SESSION['adminFlag'] && isset($_SESSION['searchManagerID']) && !empty($_SESSION['searchManagerID'])){
		$managerSQL = "select projectID from workMember where forewordTypeID in(126, 332) and managerID=".$_SESSION['searchManagerID']." group by projectID";	
	}
	if($managerSQL!=""){
		$tmpManager = $mydb->Execute($managerSQL);
		while(!$tmpManager->EOF){
			$searchProjectID[] = $tmpManager->fields['projectID'];
			$tmpManager->MoveNext();
		}	
	}
	*/
	
	//if(count($searchProjectID)>0)
	//	$subSearchQuery.=" and `$tableID` in (".implode(",", $searchProjectID).")";
	
	//兩周內有更動之資料
	$today = mktime(date("H"), date("i"), date("s"), date("m")  , date("d"), date("Y"));
	$lastdate = date("Y-m-d H:i:s", $today-14 * 24 * 3600);
	$subSearchQuery.=" and menuID=485 and uDate between '".$lastdate."' and '".date("Y-m-d H:i:s",$today)."'"; 
	
	
	$sqlString = "select * from `$table` where $tableID>0 and projStat3=0 and projStat5=0 and projStat4=0 $subSearchQuery ";
	//echo $sqlString;exit();
	$rsCnt = $mydb->Execute($sqlString . " order by projectID desc");
	$count = $rsCnt->RecordCount();
	//$sqlString.="  ORDER BY cDate,$sidx $sord LIMIT $start , $limit";
	$sqlString.="  ORDER BY uDate desc LIMIT $start , $limit";
	//echo $sqlString; exit;
	$rs = $mydb->Execute($sqlString);
	
	//echo $sqlString; exit;
	//echo $count; exit;
	
	$data = "";
	$tmpArr = array();
	foreach($rs as $idx => $value){
		//$mydb->debug=true;
		$sqlString = "select * from manager where managerID=" . $value['managerID'];
		$rsManager = $mydb->Execute($sqlString);
		//專案負責人
		$sqlString = "select c.name,c.managerID from workMember as b 
							join manager as c
							join forewordType as d
							on b.managerID = c.managerID
							and b.forewordTypeID = d.forewordTypeID
							where b.linkID=0 and d.name='專案'
							and (c.leaveDate='0000-00-00' or c.leaveDate>'".date("Y-m-d")."')
							and b.projectID=" . $value['projectID'];
		$projName = $mydb->Execute($sqlString);
		$prjName = array();
		//$prjEdit = false;
		while(!$projName->EOF){
				$prjName[] = $projName->fields['name'];
				//if($projName->fields['managerID'] == $_SESSION['managerID']) $prjEdit=true;
				$projName->MoveNext();
		}
		
		$managerName = (count($prjName)>0) ? implode("<br/>", $prjName) : '';
		
		//$fType = $mydb->Execute("select name from forewordType where menuID=486 and forewordTypeID=" . $value['forewordTypeID']);
		$pStat = array();
		//$executeStat = false;
		foreach($projStat as $pk => $pv){									
			
			//echo $pv['name'], " ",$pv['idx'],"!!<br>";
			
			$tmpField = "projStat" . $pv['idx'];
			//echo $tmpField,"<br>";
			$tmpCheck = ($value[$tmpField]==1) ? 'checked' : '';
			
			if($value[$tmpField]==1 &&($pv['idx']!=7 && $pv['idx']!=8))				
				$pStat[]= '<input readonly disabled  type="checkbox" name="projStat'.$pv['idx'].'" id="projStat'.$pv['idx'].'" value="1" '.$tmpCheck.'> '.$pv['name'];
			
			//if($value['projStat3']==1)
				//$executeStat = true;
		//var_dump($pStat); 
		}
		
		$totalHour = "";
		//總時數 (執行中才顯示 為0的不顯示)
		//if($executeStat){
			$timeSql = "select sum(hours) as total from workMember where projectID =  ".$value['projectID'];
			$timeRs = $mydb->Execute($timeSql);
			$totalHour = ($timeRs->fields['total']==0)?"":$timeRs->fields['total'];
		//}
		/*
		$btn = "";
		//ADD OR EDIT 申請單
		$contractSql = "select * from contract where projectID=".$value[$tableID];
		$contractRs = $mydb->Execute($contractSql);
		$action = ($contractRs->RecordCount()>0)?"編輯":"新增";
		$color = ($contractRs->RecordCount()>0)?"color:darkred":"";
		
		if($_SESSION['adminFlag'] || $_SESSION['managerID'] == $value['managerID'] ||$prjEdit==true)
		$btn ="<input onclick=\"location.href='edit.php?act=view&pn=2&ps=10&pf=1&$tableID=".$value[$tableID]."&secureChk=".$value['secureChk']."'\" type=\"button\"  value=\"編輯\">&nbsp;"
				 ."<input onclick=\"delete_check('".$value[$tableID]."','".$value['secureChk']."')\" type=\"button\"  value=\"刪除\">&nbsp;"
				 ."<input onclick=\"location.href='form.php?act=view&pn=2&ps=10&pf=1&$tableID=".$value[$tableID]."&secureChk=".$value['secureChk']."'\" type=\"button\" style=\"".$color."\" value=\"".$action."申請單\">";
		
		$projLink='';
		
		if(($value['forewordTypeID'] == 141 || $value['forewordTypeID']== 148) && $value["projStat8"] == "0"){
			$projLink = $value["projectNo"] == ""?$value["projectNo"]:"<a href=\"projTableFus.php?targetID=".$value['projectID']."\" target=\"_blank\">".$value["projectNo"]."</a>";
		}elseif(($value['forewordTypeID'] == 136 || $value['forewordTypeID']==145) && $value["projStat8"] == "0"){
			$projLink = $value["projectNo"] == ""?$value["projectNo"]:"<a href=\"projTableWeb.php?targetID=".$value['projectID']."\" target=\"_blank\">".$value["projectNo"]."</a>";
		}else{
			if($value["projStat8"] == "0")
				$projLink = $value["projectNo"] == ""?$value["projectNo"]:"<a href=\"projTableUni.php?targetID=".$value['projectID']."\" target=\"_blank\">".$value["projectNo"]."</a>";
			else
				$projLink = "&nbsp;";	
		}
		if($projLink != "" && $value["projStat7"] == "0"){
			$projLink .= "&nbsp;&nbsp;";
			$projLink .= "<a href=\"Outsourcing.php?targetID=".$value['projectID']."\" target=\"_blank\">外包單</a>";
		}*/
		$data = array(
			//$value['projectID']
			//,$fType->fields['name']
			//,$value['projectNo']
			//,$projLink
			$value['name']
			,(($value['sDate'] != '' && $value['sDate'] !='0000-00-00') ? $value['sDate'] : '')
			,(($value['uDate'] != '' && $value['uDate'] !='0000-00-00') ? $value['uDate'] : '')
			//,(($value['preEDate'] != '' && $value['preEDate'] !='0000-00-00') ? $value['preEDate'] : '')
			//,(($value['eDate'] != '' && $value['eDate'] !='0000-00-00') ? $value['eDate'] : '')
			,((count($pStat)>0)? implode(" ", $pStat) : "")
			,$managerName
			//,$btn
			,$totalHour
		);
		
		$tmpArr[] = array(
			'id'=>$value['uDate']
			,'cell'=>$data
		);
		
	}

	$result = array(
		'page'=>$page
		,'records'=>$count
		,'total' =>ceil($count/$limit)
		,'rows'=>$tmpArr
	);
	
	//var_dump($result);
	echo json_encode($result);
?>
