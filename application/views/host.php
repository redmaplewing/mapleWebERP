<html>
<head>
<title>hello manager</title>
</head>
<body>
<table>
<tr>
<td>主機名稱</td>
<td>作業系統</td>
<td>租用空間</td>
</tr>
<?php foreach($query->result() as $row):?>
<tr>
<td><?=$row->hostTypeName;?></td>
<td><?=$row->hostSys;?></td>
<td><?=$row->hostDisk;?></td>
</tr>
<?php endforeach;?>
</table>
<?= anchor(site_url("manager/"),"成員管理","style='color:red;'");?>
</body>
</html>