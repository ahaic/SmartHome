<html>
<head>
<link rel=stylesheet href="styles/advanced/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$this->load_js(array('jquery', 'xheditor-zh-cn.min', 'ajaxupload'));
$this->load_css('admin_style');
$td_style = "style='font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;'";
$input_style = 'style="width:200px;" class="kuang" onBlur="this.className=\'kuang\'" onFocus="this.className=\'kuang1\'"';
?>
<script>
function add()
{
	var len = $("#tab tr").length;
	$("#tab").append("<tr id="+(len+1)+"><td <?=$td_style?>><?=$this->p_lang['explanation']?></td><td <?=$td_style?>><input name='field_info["+len+"]' type='text' id='field_info["+len+"]' value='' class='kuangy' /> <font color='#ff0000'>*</font> </td><td <?=$td_style?>><?=$this->p_lang['name']?></td><td <?=$td_style?>><input name='field_name["+len+"]' type='text' value='' class='kuangy' /> <font color='#ff0000'>*</font></td><td <?=$td_style?>><?=$this->p_lang['type']?></td><td <?=$td_style?>><select name='field_type["+len+"]'><option value='1'><?=$this->p_lang['input']?></option><option value='2'>html</option><option value='3'><?=$this->p_lang['radio']?></option><option value='4'><?=$this->p_lang['checkbox']?></option><option value='5'><?=$this->p_lang['pic'].$this->p_lang['upload']?></option><option value='6'><?=$this->p_lang['more'],$this->p_lang['pic'].$this->p_lang['upload']?></option></select></td><td <?=$td_style?>><?=$this->p_lang['parameter']?></td><td <?=$td_style?>><input name='field_parameter["+len+"]' type='text' value='' class='kuangy' /> </td><td <?=$td_style?>><input name='' type='button' value='<?=$this->p_lang['delete']?>' onClick='del("+(len+1)+")' style='border:1px #000000 solid;vertical-align:middle;height:25px'></td></tr>");　　　
}
function del(i)
{
	var $table=$("#tab tr");
	var len=$table.length;
	$("tr[id='"+i+"']").remove();　
}
	
function on_link()
{

	if($('#clinkture').attr('checked') == true) 
	{
		$('#out_link').show();	
		$('#not_out_link').hide();
	}
	else
	{
		$('#out_link').hide();	
		$('#not_out_link').show();
	}
}	
</script>
</head>
<body>
<form action="" method="post">
<table width="100%" border="0"  cellpadding="0" cellspacing="0" style="background-image:url(<?=IMG_PATH?>bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle"><?=$title?><input name="" type="button" value="<?=$this->p_lang['field'].$this->p_lang['add']?>" onClick="add()" style="border:1px #000000 solid;vertical-align:middle;height:25px"></p> </td>
  </tr>
</table>
<br />

<table class="table" width="100%" border="0" cellspacing="0">
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['model'].$this->p_lang['name']?></td><td  <?=$td_style?>><input type="text" name="name" id="name" <?=$input_style?>>
 <?
 if($type == 1){
 ?>&nbsp;&nbsp;
<?=$this->p_lang['login'].$this->p_lang['type']?>:
  <select name="login" id="login">
    <option value="0">否</option>
    <option value="1">是</option>
  </select>
  <?
 }
  ?></td></tr></table>
<table class="table2" width="100%" border="0" cellspacing="0" id="tab"></table>
<table class="table2" width="100%" border="0" cellspacing="0">
<tr bgcolor="#f9f9f9">
  <td colspan="5" <?=$td_style?> align="center"><input type="submit" value="<?=$this->p_lang['submit']?>" style="border:1px #000000 solid;vertical-align:middle;height:25px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="button2" id="button2" value="<?=$this->p_lang['reset']?>" style="border:1px #000000 solid;vertical-align:middle;height:25px"/></td></tr>
</table></form>
<br />
<?
$this->load_php('admin/footer');
?>

</body>
</html>