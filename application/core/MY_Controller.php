<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    //宣告一個公開陣列，供所有繼承此類別者均能使用
	/**
     * __construct
     *
     * @return void
     **/
    public function __construct()
    {	
        parent::__construct();//繼承父類別的涵數
		$this->_load();
    }

	public $groupPermission = array();
	
	public function checkPermission($type='1',$target = "",$key='0'){
		/*
			type 數值說明
			1=>左側選單的顯示與否
			2=>功能內部的操作
		*/
		$menuList = array(
			"mainMenu" => array("internalMemo","procedures")
			,"itData" => array("logSheetData","createBackFile","adjustData")
			,"taskManagement" => "taskManagement"
			,"humanMain" => array("organizationalChart","addressbook","companyCalendar")
			,"recruProcess" => array("recruitmentDatabase","shortlistApplicants")
			,"employee" => "employeeList"
			,"attRecord" => "attandanceRecord"
			,"pruInfoRegistry" => "purInformationRegistry"
			,"purchaseRequest" => "purPurchaseRequest"
			,"purchaseOrder" => array("purPurchaseOrderLocal","purPurchaseOrderOverseas")
			,"purReport" => "purReportCenter"
			,"invInfoRegistry" => "invInformationRegistry"
			,"materialRR" => "invMaterialRequestReturn"
			,"teManager" => "invToolEqupmentManagement" 
			,"invReport" => "invReportCenter" 
			,"drawManagement" => array("drawList","drawDistribution")
			,"proj" => "projectList"
		);
		
		$result = true;
		$tar = "";
		$menu = "";
		if(isset($menuList[$target])){
			//echo $type;
			$menu = $menuList[$target];
			if(!is_array($menuList[$target])){
				$tar = $menuList[$target];
			}elseif($key != '0'){
				$tar = in_array($key,$menuList[$target])?$key:"";
			}
			//echo $tar."<br>";
			//echo $tar."=".intval($this->groupPermission[$tar])."<br />"; 
			$check = 0;
			switch($type){
				case '3'://功能操作(新增、編輯、刪除)
					if(isset($this->groupPermission[$tar])){
						//echo intval($this->groupPermission[$tar])."<br>";
						$check = intval($this->groupPermission[$tar]) > 1?1:0;
					}
				break;
				case '2'://內頁標籤
					if(isset($this->groupPermission[$tar])){
						$check = intval($this->groupPermission[$tar]) > 0?1:0;
					}
				break;
				case '1'://左側連結				
					if(is_array($menu)){						
						foreach($menu as $val){
							if($check == 0){
								$check = intval($this->groupPermission[$val]) > 0?1:0;
							}
							$result = $check == 1?true:false;
						}
					}else{
						$check = intval($this->groupPermission[$menu]) > 0?1:0;						
					}
				default:
				break;
			}
			$result = $check == 1?true:false;
		}
		
		return $result;
	}
	
    /*
     *  load css or javascript
     */
    private function _load()
    {
        // load controller css
        //echo "can do check here";
		$lang = $this->session->userdata('lang') == ""?"en_US":$this->session->userdata('lang');
		$this->lang->load('main',$lang);//戴入語言套件
		//echo $lang;
		
		//登入驗證
		//07052013會有判斷失準的問題，先移除
		/*
		if(!$this->session->userdata('logined')){
			echo "<script>alert('".$this->lang->line('log_error')."');</script>";
			echo "<script>location.href = '".base_url()."';</script>";
		}
		*/
		//設定語言參數
		$langType = array(
			"en_US" => $this->lang->line('lang_enUS'),
			//"zh_CN" => $this->lang->line('lang_zhCN'),			
			//"km_KH" => $this->lang->line('lang_kmKH'),
			"zh_TW" => $this->lang->line('lang_zhTW')
		);
		
		$languageType = array(
			"languageType" => $langType
		);
		
		$this->session->set_userdata($languageType);
		//var_dump($this->session->userdata('languageType'));
		
		//取得群組資料並建立群組陣列
		$sqlString = "SELECT * FROM groupPermission WHERE groupPermissionID='%s' AND enable='1'";
		$query = $this->db->query(sprintf($sqlString,$this->session->userdata('groupID')));
		$this->groupPermission = $query->row_array();
		//var_dump($group);
		
		//選單分類
		$lang = $this->session->userdata('lang') == ""?"en_US":$this->session->userdata('lang');
		//取得所有英文名稱的選單類別
		$sqlString = "SELECT * FROM menuType WHERE lang='en_US' and enable=1 order by ord asc";
		$engMenu = $this->db->query($sqlString)->result();
		//var_dump($engMenu);
		//取得指定語言的表單，若有指定語言的選單類別名稱，則將名稱置入陣列，若無則置入英文名稱
		$menuType = array();
		foreach($engMenu as $key => $val){
			//從資料庫取得選單類別列表
			$sqlString = "SELECT * FROM menuType WHERE lang='".$lang."' and linkID='".$val->menuTypeID."'";
			$langMenuTypeName = $this->db->query($sqlString);
			//依選單類別從資料庫取出選單列表
			$sqlString = "SELECT * FROM menu WHERE parentID=".$val->menuTypeID." and enable=1 order by ord asc";
			//echo $sqlString."<br />";
			$menu = $this->db->query($sqlString);
			//建立選單陣列
			$menuList = array();
			//var_dump($menuList);
			//var_dump($menu->result());
			foreach($menu->result() as $row){
				//權限判斷
				if($this->checkPermission('1',$row->link)){
					$sqlString = "SELECT * FROM nameLang WHERE lang='".$lang."' and linkID='".$row->menuID."' and menuID=2 limit 0,1";
					//echo $sqlString;
					$langMenuName = $this->db->query($sqlString);
					if($langMenuName->num_rows() != 0){
						$name = $langMenuName->row();
						$menuList[] = array(
							"name" => $name->name
							,"link" => $row->link
							,"id" => $row->menuID
						);
					}else{
						$menuList[] = array(
							"name" => $row->name
							,"link" => $row->link
							,"id" => $row->menuID
						);
					};
				}
			}
			
			//判定語言，將選單列表及選單類別列表寫入session供其它功能取用
			if($langMenuTypeName->num_rows() != 0){
				$langName = $langMenuTypeName->row();
				//array_push($menuType,$langName->name);
				$menuType[]=array(
					"name" => $langName->name
					,"id" => $val->menuTypeID
					,"menulist" => $menuList
				);
			}else{
				//array_push($menuType,$val->name);
				$menuType[]=array(
					"name" => $val->name
					,"id" => $val->menuTypeID
					,"menulist" => $menuList
				);
			}
		}
		foreach($menuType as $key => $val){
			if(empty($val['menulist'])){
				unset($menuType[$key]);
			}
		}
		//將表單類別名稱寫入session
		$mainMenuType = array(
			"menuType" => $menuType
		);
		
		$engMenuType = array();
		$engMenuType['0'] = $this->lang->line('isEng');
		foreach($engMenu as $key => $val){
			$engMenuType[$val->menuTypeID] = $val->name;
		};
		
		$_sesEngMenuType = array(
			"engMenuType" => $engMenuType
		);
		$this->session->set_userdata($mainMenuType);
		$this->session->set_userdata($_sesEngMenuType);

		//var_dump($this->session->all_userdata());
    }
}