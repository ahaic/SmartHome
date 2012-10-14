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
$(function(){
	$('#submitBtn').click(function(){
		$.post('<?=url(array('admin', 'user_add'))?>', {'username' : $('#username').val(),'password' : $('#password').val(),'sex' : $('#sex').val(),'email' : $('#email').val(),'qq' : $('#qq').val(),'tel' : $('#tel').val(),'address' : $('#address').val(),'money' : $('#money').val(),'add_time' : $('#add_time').val(),		'level' : $('#level').val()}, function(data){
			if(data == '1'){
				alert('成功');
			}else{
				alert('失败');
			}	
		})	
	})
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
        <p><h2><?=$this->p_lang['add'].$this->p_lang['user']?></h2></p>
         <table class="table"><tr>
         <td class="span2"><?=$this->p_lang['account']?></td><td class="span4"><input name="username" type="text" id="username"></td>
         <td class="span2"><?=$this->p_lang['password']?></td><td class="span4"><input name="password" type="password" id="password"></td>
         </tr>
         <tr>
         <td class="span2"><?=$this->p_lang['sex']?></td><td class="span4">
         <select name="sex" id="sex">
           <option value="0"><?=$this->p_lang['man']?></option>
           <option value="1"><?=$this->p_lang['woman']?></option>
         </select></td><td class="span2"><?=$this->p_lang['email']?></td><td class="span4"><input name="email" type="text" id="email"></td>
         </tr>
         <tr>
         <td class="span2">QQ</td><td class="span4"><input name="qq" type="text" id="qq"></td>
         <td class="span2"><?=$this->p_lang['tel']?></td><td class="span4"><input name="tel" type="text" id="tel"></td>
         </tr><tr>
         <td class="span2"><?=$this->p_lang['address']?></td><td class="span4"><input name="address" type="text" id="address"></td>
         <td class="span2"><?=$this->p_lang['money']?></td><td class="span4"><input name="money" type="text" id="money"></td>
         </tr><tr>
         <td class="span2"><?=$this->p_lang['time']?></td><td class="span4"><input name="add_time" type="text" value="<?=date('Y-m-d H:i:s')?>" id="add_time"></td>
         <td class="span2"><?=$this->p_lang['level']?></td><td class="span4"><select name="level" id="level">
           <option value="0"><?=$this->p_lang['general']?></option>
           <option value="1"><?=$this->p_lang['administrator']?></option>
           <option value="2"><?=$this->p_lang['editor']?></option>
         </select></td>
         </tr>
         <tr><td colspan="4"><button type="button" id="submitBtn" class="btn btn-primary btn-large" ><?=$this->p_lang['submit']?></button>&nbsp;&nbsp;
            <button class="btn btn-large" type="reset"><?=$this->p_lang['cancel']?></button></td></tr>
         </table>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>