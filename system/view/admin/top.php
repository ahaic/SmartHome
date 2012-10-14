<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$this->load_css('admin_top');
?>
</head>
<body>
<span>


Hi ：<?=$_COOKIE['user']['username']?> 
<a href="<?=SITEPATH?>" target="_blank"><?=$this->p_lang['home']?></a> <a href="<?=url(array('home', 'logout'))?>" class="normal" target="_parent" onClick="return confirm('<?=$this->p_lang['home'].$this->p_lang['logout']?>?');"><?=$this->p_lang['logout']?>
</a>
</span>

<div class="left">
<p>PHPLite Vip
</p>
</div>

</body>
</html>
