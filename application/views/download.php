<?php
//require_once("config.inc.php");
$fileName = $_REQUEST["filename"];
//echo $fileName,"<br>";
//echo $filePath.$fileName;
/*
$frontName = basename($fileName);//檔名
$backName = strtolower(substr(strrchr($fileName,"."),1));  //附檔名
 switch( $backName ) {
     case "pdf": $ctype="application/pdf"; break;
     case "exe": $ctype="application/octet-stream"; break;
     case "zip": $ctype="application/zip"; break;
     case "doc": $ctype="application/msword"; break;
     case "xls": $ctype="application/vnd.ms-excel"; break;
     case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
     case "gif": $ctype="image/gif"; break;
     case "png": $ctype="image/png"; break;
     case "jpeg":
     case "jpg": $ctype="image/jpg"; break;
     case "mp3": $ctype="audio/mpeg"; break;
     case "wav": $ctype="audio/x-wav"; break;
     case "mpeg":
     case "mpg":
     case "mpe": $ctype="video/mpeg"; break;
     case "mov": $ctype="video/quicktime"; break;
     case "avi": $ctype="video/x-msvideo"; break;
     //禁止下面幾種類型的檔案被下載
     //case "php":
     //case "htm":
     //case "html":
     //case "txt": die("Cannot be used for ". $file_extension ." files!"); break;
     default: $ctype="application/force-download";
   }
//使用利用 switch判別的檔案類型
header("Content-Type: $ctype");
*/	

$url = "upload/";  //路徑位置
//$url = $host."upload/file/";  //路徑位置
//echo $url;exit();
//$url = "D:/xampp/htdocs/sinpu/upload/file/";
//echo $url.$fileName; exit();
//ob_start();
	header("Content-type: text/html; charset=utf-8");
	header("Content-type:application");

	header("Content-Disposition: attachment; filename=".$fileName);
	//readfile($filePath.$fileName);
	readfile($url.$fileName);
	//ob_end_flush();
	exit(0);
?>