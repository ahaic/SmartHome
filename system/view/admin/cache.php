<html>
<head>
<link rel=stylesheet href="/styles/advanced/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$this->load_js(array('jquery', 'xheditor-zh-cn.min'));
$this->load_css('admin_style');
?>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(<?=IMG_PATH?>bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle"><?=$this->p_lang['cache']?></p></td>
  </tr>
</table>
<br />
<table class="table" id="not_out_link" width="100%" border="0" cellspacing="0">
<tr bgcolor="#f9f9f9"><td width="110" style='font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;'><?=$this->p_lang['cache'].$this->p_lang['update']?></td></tr></table>

<br />
<?
$this->load_php('admin/footer');
?>

</body>
</html>