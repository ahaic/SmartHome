<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<?
$this->load_css(array('bootstrap.min', 'bootstrap-responsive.min'));
$this->load_js(array('jquery', 'bootstrap-dropdown'));
?>
<script>
$('.dropdown-toggle').dropdown()
function add()
{
	var len = $("#tab tr").length;
	$("#tab").append("<tr id="+(len+1)+"><td><?=$this->p_lang['explanation']?></td><td><input name='field_info["+len+"]' type='text' id='field_info["+len+"]' value='' class='span2'/> <font color='#ff0000'>*</font> </td><td><?=$this->p_lang['name']?></td><td><input name='field_name["+len+"]' type='text' value=''  class='span2'/> <font color='#ff0000'>*</font></td><td><?=$this->p_lang['type']?></td><td><select name='field_type["+len+"]' class='span2'><option value='1'><?=$this->p_lang['input']?></option><option value='2'>html</option><option value='3'><?=$this->p_lang['radio']?></option><option value='4'><?=$this->p_lang['checkbox']?></option><option value='5'><?=$this->p_lang['pic'].$this->p_lang['upload']?></option><option value='6'><?=$this->p_lang['multi'],$this->p_lang['pic'].$this->p_lang['upload']?></option></select></td><td><?=$this->p_lang['parameters']?></td><td><input class='span2' name='field_parameter["+len+"]' type='text' value=''/> </td><td><input name=''  type='button' value='<?=$this->p_lang['delete']?>' onClick='del("+(len+1)+")' class='btn btn-small'></td></tr>");　　　
}
function del(i)
{
	var $table=$("#tab tr");
	var len=$table.length;
	$("tr[id='"+i+"']").remove();　
}
</script>
</head>
<body>
<?
  $this->load_php('admin/top');
?>
<div class="container-fluid">
<div class="row-fluid">
  <div class="span2">
  <?
  $this->load_php('admin/menu');
  ?>
  </div>
  <div class="span10">
        <p><h2><?=$this->p_lang['model'].$this->p_lang['edit']?>&nbsp;&nbsp;<a onClick="add()"><?=$this->p_lang['field'].$this->p_lang['add']?></a></h2></p>
        <form action="" method="post">
          <table class="table">
  <tr>
    <td class="span2"><?=$this->p_lang['model'].$this->p_lang['name']?></td>
    <td class="span10"><input name="name" type="text" id="name" value="<?=$rs[0]['name']?>" readonly="readonly">
<?
 if($type == 1){
?>&nbsp;&nbsp;
<?=$this->p_lang['login'].$this->p_lang['type']?>:
  <select name="login" id="login">
    <option value="0"><?=$this->p_lang['no']?></option>
    <option value="1"><?=$this->p_lang['yes']?></option>
  </select>
  <?
 }
  ?>
    </td>
  </tr>
  </table>
  
  <table class="table table-bordered" id="tab">
  <?
$field = empty($rs[0]['field']) ? array() : @unserialize($rs[0]['field']);
$i = 0;
foreach($field as $key => $val){
	?>
    <tr id="<?=$i?>"><td><?=$this->p_lang['explanation']?></td><td><input name='field_info[<?=$i?>]' type='text' id='field_info[<?=$i?>]' class="span2" value='<?=$val['field_info']?>' /> <font color='#ff0000'>*</font> </td><td><?=$this->p_lang['name']?></td><td><input name='field_name[<?=$i?>]' class="span2" type='text' value='<?=$val['field_name']?>' /> <font color='#ff0000'>*</font></td><td><?=$this->p_lang['type']?></td><td>
    
    <select name='field_type[<?=$i?>]' class="span2">
    <option value='1' <?=($val['field_type'] == 1) ? 'selected' : ''?>><?=$this->p_lang['input']?></option>
    <option value='2' <?=($val['field_type'] == 2) ? 'selected' : ''?>>html</option>
    <option value='3' <?=($val['field_type'] == 3) ? 'selected' : ''?>><?=$this->p_lang['radio']?></option>
    <option value='4' <?=($val['field_type'] == 4) ? 'selected' : ''?>><?=$this->p_lang['checkbox']?></option>
    <option value='5' <?=($val['field_type'] == 5) ? 'selected' : ''?>><?=$this->p_lang['pic'].$this->p_lang['upload']?></option>
    <option value='6' <?=($val['field_type'] == 6) ? 'selected' : ''?>><?=$this->p_lang['multi'],$this->p_lang['pic'].$this->p_lang['upload']?></option>
    </select>
    
    </td><td><?=$this->p_lang['parameters']?></td><td><input name='field_parameter[<?=$i?>]' type='text' value='<?=$val['field_parameter']?>' class="span2"/> </td><td <?=$td_style?>><input name='' type='button' value='<?=$this->p_lang['delete']?>' onClick='del(<?=$i?>)' class='btn btn-small'></td></tr>
    <?
	$i++;
}
?>
  </table><table>
  <tr><td colspan="4" align="center">
  <button type="submit" class="btn btn-primary btn-large" ><?=$this->p_lang['save']?></button>&nbsp;&nbsp;
            <button class="btn btn-large" type="reset"><?=$this->p_lang['cancel']?></button>
  </td></tr>
</table>
</form>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>