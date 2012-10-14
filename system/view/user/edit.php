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
$this->load_php('user/header');
?>
<div class="container" style="max-width:1080px">
<div class="row-fluid">
  <div class="span2">
  <p><h2>用户中心</h2></p>
  <ul class="nav nav-pills nav-stacked">

        <li class="active"><a href="<?=url(array('user', 'index'))?>"><?=$this->p_lang['welcome']?>：<?=$_COOKIE['user']['username']?></a></li>
      <li><a href="<?=url(array('user', 'edit'))?>"><?=$this->p_lang['data'].$this->p_lang['manage']?></a></li>
      <li><a href="<?=url(array('user', 'password'))?>"><?=$this->p_lang['password'].$this->p_lang['manage']?></a></li>
	  <?
		$level = array(1,2);
		if(in_array($_COOKIE['user']['level'], $level))
		{		
	  ?>
	  <li><a href="<?=url(array('user', 'news'))?>"><?=$this->p_lang['content'].$this->p_lang['manage']?></a></li>
	  <li><a href="<?=url(array('user', 'news_add'))?>"><?=$this->p_lang['content'].$this->p_lang['add']?></a></li>
	  <?
	  }
	  ?>
      <!--<li><a href="<?=url(array('user', 'order'))?>"><?=$this->p_lang['business'].$this->p_lang['manage']?></a></li>
      <li><a href="<?=url(array('user', 'money'))?>"><?=$this->p_lang['finance'].$this->p_lang['manage']?></a></li>
      <li><a href="#">Discuz! X1.5 用户接口</a></li>
      <li><a href="#">PHPwind API 用户接口</a></li>
      <li><a href="#">新浪微博API用户接口</a></li>
      <li>QQ微博API用户接口</li>-->
      <li><a href="<?=url(array('home', 'logout'))?>"><?=$this->p_lang['logout']?></a></li>
      </ul>
  </div>
  <div class="span10" style="min-height:450px">
        <p><h2><?=$this->p_lang['user'].$this->p_lang['info']?></h2></p><form action="" method="post">
          <table class="table">
  <tr>
    <td class="span2"><?=$this->p_lang['user'].$this->p_lang['name']?></td>
    <td class="span10"><?=$rs[0]['username']?></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['sex']?></td>
    <td><select name="sex">
             <option value="0" <?=empty($rs[0]['sex']) ? 'selected="selected"' : ''?>><?=$this->p_lang['boy']?></option>
             <option value="1" <?=empty($rs[0]['sex']) ? '' : 'selected="selected"'?>><?=$this->p_lang['girl']?></option>
           </select> </td>
  </tr>
  <tr>
    <td><?=$this->p_lang['email']?></td>
    <td><input name="email" type="text" id="email" value="<?=$rs[0]['email']?>" /></td>
  </tr>
  <tr>
    <td>Q　Q</td>
    <td><input name="qq" type="text" id="qq" value="<?=$rs[0]['qq']?>" /></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['tel']?></td>
    <td><input name="tel" type="text" value="<?=$rs[0]['tel']?>" /></td>
  </tr>
  <tr>
    <td><?=$this->p_lang['address']?></td>
    <td><input name="address" type="text" value="<?=$rs[0]['address']?>" /></td>    
  </tr>  
  <tr><td colspan="2" align="center">
  <button type="submit" class="btn btn-primary btn-large" ><?=$this->p_lang['save']?></button>&nbsp;&nbsp;
  <button class="btn btn-large" type="reset"><?=$this->p_lang['cancel']?></button>
  </td></tr>
</table>
</form>
  </div>

</div>
<?
$this->load_php('user/footer');
?></div>
</body>
</html>