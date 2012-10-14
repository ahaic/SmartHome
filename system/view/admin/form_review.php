<html>
<head>
<link rel=stylesheet href="styles/advanced/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$this->load_js('jquery');
$this->load_css('admin_style');
$style = 'style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"';
?>

</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(<?=IMG_PATH?>bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle"><?=$this->p_lang['content']?></p></td>
  </tr>
</table>
<br />
<table class="table" width="100%" border="0" cellspacing="0">
  <tr bgcolor=#ffffff><td <?=$style?>>ID</td>
    <?
    foreach($str as $key => $val){
		echo '<td '.$style.'>'.$val['field_info'].'</td>';
	}	
	?>
    </tr>
    <?
	if(!empty($review_rs)){
    foreach($review_rs as $key => $val){
		echo '<tr><td '.$style.'>'.$val['id'].'</td>';	
		$field = @unserialize($val['field']);
		foreach($field as $k => $v){
			echo '<td '.$style.'>'.$v.'</td>';	
		}
		echo '</tr>';
	}}
	?>
</table>
<table class="table" width="100%" border="0" cellspacing="0">
  <tr>
    <td align="center" <?=$style?>><?=$page?></td>
  </tr>
</table>


<br /><br />
<?
$this->load_php('admin/footer');
?>

</body>
</html>