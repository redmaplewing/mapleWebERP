<html>
<head>
<title>hello manager</title>
</head>
<body>
<?= $this->table->set_heading("成員名稱","成員編號","成員群組編號");?>
<?= $this->table->add_row(array("colspan"=>3),"hello manager");?>
<?= $this->table->generate($query);?>

<?= $this->pagination->create_links();?>
<br />
<?= anchor( site_url("manager/host/"),"虛擬主機","style='color:red;'");?>
</body>
</html>