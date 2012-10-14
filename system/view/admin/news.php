<html>
<head>
<link rel=stylesheet href="styles/advanced/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$this->load_js('jquery');
$this->load_css('admin_style');
?>
<script>
function manage_news()
{
	var cate = $("#cate").val();
	window.location.href="<?=url(array('admin', 'news')).'&cid='?>"+cate+"";	
}
</script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(<?=IMG_PATH?>bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle"><?=$this->p_lang['content']?></p></td>
  </tr>
</table>
<br />
<form action="" method="get">
<table width="100%" border=0 cellpadding="0" cellspacing=1 style="background:#dfdfdf">
  <tr bgcolor=#ffffff>
    <td width="9%" height="30" align="center" ><?=$this->p_lang['class'].$this->p_lang['select']?></td>
    <td width="91%" align="left" >
      &nbsp;&nbsp;
     <?=$cate_str?>&nbsp;&nbsp;&nbsp;&nbsp;<input name="按钮" type="button" value="查询"  onClick="manage_news()"></td>
    </tr>
</table>
</form>
<br />


<?
$append = array(
	array('news_hot', $this->p_lang['hot'], 'nid'),
	array('news_recommend', $this->p_lang['recommend'], 'nid')
	);
$this->load_list($rs, 'news', array('nid','cid'), $append, 1);
echo '<br>';
echo page_bar($count, $this->p_num, '', 9, 'p')
?>
<br /><br />
<?
$this->load_php('admin/footer');
?>

</body>
</html>