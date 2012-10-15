<html>
<head>
<link rel=stylesheet href="styles/advanced/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$this->load_js(array('jquery', 'xheditor-zh-cn.min'));
$this->load_css('admin_style');
?>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(<?=IMG_PATH?>bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle"><?=$this->p_lang['data'].$this->p_lang['manage']?> [ <a href="<?=url(array('admin', 'data', 'backup'))?>"><u><?=$this->p_lang['backup']?></u></a> ]</p></td>
  </tr>
</table>
<br />
<table class="table" width="100%" border="0" cellspacing="0">
<?
$i = 0;
foreach($dir_arr as $key => $val){
	$i += 1;
?>
		<tr bgcolor="#ffffff"><td style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"><?=$i?></td><td style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"><?=$val?></td><td style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"><a href="<?=url(array('admin', 'data', 'backin', $val))?>"><u><?=$this->p_lang['import']?></u></a></td></tr>
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