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
$this->load_js(array('jquery', 'bootstrap-dropdown', 'ajaxupload'));
?>
<script>
$('.dropdown-toggle').dropdown()
$(function(){
	var button = $('#upload_input'), interval;		
	new AjaxUpload(button, {
		action: '<?=SITEPATH?>index.php?q=admin/ajax_upload.html', 
		name: 'filedata',
		onSubmit : function(file, ext){
			this.disable();			
		},			
		onComplete: function(file, response){	
			var json_str = eval("(" + response + ")");
			if(json_str['err'] != "")
			{
				this.enable();
				alert(json_str['err']);return;
			}
			window.clearInterval(interval);
			this.enable();				
			$('#logo').val(json_str['msg']);		
		}
	});
})
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
        <p><h2><?=$this->p_lang['basic'].$this->p_lang['settings']?></h2></p><form action="" method="post">
          <table class="table">
  <tr>
    <td class="span2"><?=$this->p_lang['webname']?></td>
    <td class="span4"><input name="webname" type="text" id="webname" value="<?=$rs['webname']?>"></td>
    <td class="span2"><?=$this->p_lang['keyword']?></td>
    <td class="span4"><input name="keyword" type="text" id="keyword" value="<?=$rs['keyword']?>"></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['email']?></td>
    <td><input name="email" type="text" id="email" value="<?=$rs['email']?>"></td>
    <td><?=$this->p_lang['icp']?></td>
    <td><input name="icp" type="text" id="icp" value="<?=$rs['icp']?>"></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['cache'].$this->p_lang['time']?></td>
    <td><input name="cache_time" type="text" id="cache_time" value="<?=$rs['cache_time']?>"></td>
    <td><?=$this->p_lang['veri']?></td>
    <td><input name="code" type="text" id="code" value="<?=$rs['code']?>"></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['template'].$this->p_lang['path']?></td>
    <td><input name="tempdir" type="text" id="tempdir" value="<?=$rs['tempdir']?>"></td>
    <td><?=$this->p_lang['introduction'].$this->p_lang['length']?></td>
    <td><input name="infolen" type="text" id="infolen" value="<?=$rs['infolen']?>"></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['timezone']?></td>
    <td><input name="time_zone" type="text" id="time_zone" value="<?=$rs['time_zone']?>"></td>
    <td><?=$this->p_lang['connection'].$this->p_lang['code']?></td>
    <td><input name="connect" type="text" id="connect" value="<?=$rs['connect']?>"></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['message'].$this->p_lang['veri']?></td>
    <td><select name="veri">
	<option value="0" <?=empty($rs['veri']) ? 'selected' : ''?>><?=$this->p_lang['close']?></option>		
	<option value="1" <?=!empty($rs['veri']) ? 'selected' : ''?>><?=$this->p_lang['open']?></option>
      
    </select></td>
    <td><?=$this->p_lang['language']?></td>
    <td><select name="language">
    <?
    foreach($langArr as $k => $v){
		$select = ($rs['language'] == $v) ? 'selected' : '';
		echo '<option value="'.$v.'" '.$select.'>'.$v.'</option>';
	}
	?>      
    </select></td>    
  </tr>  
  <tr>
    <td><?=$this->p_lang['web'].$this->p_lang['mode']?></td>
    <td><select name="mode" id="mode">
      <option value="0" <?=empty($rs['mode']) ? 'selected' : ''?>><?=$this->p_lang['dynamic'].$this->p_lang['mode']?></option>
      <option value="1" <?=!empty($rs['mode']) ? 'selected' : ''?>><?=$this->p_lang['static'].$this->p_lang['mode']?></option>
    </select></td>
    <td>LOGO</td>
    <td><input name="logo" type="text" id="logo" value="<?=$rs['logo']?>"><input name="" id="upload_input" value="<?=$this->p_lang['upload']?>" class="btn-small btn-inverse" type="button"><input type="file" name="file_input" id="file_input" style="display:none"></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['web'].$this->p_lang['info']?></td>
    <td colspan="3"><textarea name="info" rows="4" class="span6" id="info"><?=stripslashes($rs['info'])?></textarea></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['count'].$this->p_lang['code']?></td>
    <td colspan="3"><textarea name="count" rows="2" class="span6" id="count"><?=stripslashes($rs['count'])?></textarea></td>
  </tr>
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