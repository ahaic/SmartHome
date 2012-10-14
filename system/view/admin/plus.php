<html>
<head>
<link rel=stylesheet href="styles/advanced/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$this->load_js(array('jquery', 'xheditor-zh-cn.min'));
$this->load_css('admin_style');
?>
<script>
function install(name){
	$.post('<?=url(array('admin', 'plus', 'install'))?>', {'module' : name}, function(data){
		if(data == '1'){
			alert('安装成功');
			document.location.reload();
		}else if(data == '0'){
			alert('安装失败');	
		}else{
			alert('没有配置文件');	
		}
	})
}

function uninstall(name){
	$.post('<?=url(array('admin', 'plus', 'uninstall'))?>', {'module' : name}, function(data){
		if(data == '1'){
			alert('卸载成功');
			document.location.reload();
		}else{
			alert('卸载失败');	
		}
	})
}
</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(<?=IMG_PATH?>bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle"><?=$this->p_lang['basic']?>：<?=date('Y-m-d H:i:s')?></p></td>
  </tr>
</table>
<br />
<table class="table" width="100%" border="0" cellspacing="0">
<?
foreach($module as $k => $v){
	?>
<tr bgcolor="#F9F9F9"><td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"><?=$k?></td><td style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;">
<?
switch($v){
	case '1':
	echo '<a onClick="uninstall(\''.$k.'\')">卸载</a>';
	break;
	default:
	echo '<a onClick="install(\''.$k.'\')">安装</a>';break;	
}
?>
</td></tr>
<?
}
?>
</table>
<br />
<?
$this->load_php('admin/footer');
?>

</body>
</html>