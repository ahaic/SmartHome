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
  <p><h2><?=$this->p_lang['news'].$this->p_lang['manage']?></h2></p>
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
        <p><h2><?=$this->p_lang['user'].$this->p_lang['info']?></h2></p><table class="table table-bordered"><thead>
<tr>
<th>ID</th>
<th><?=$this->p_lang['name']?></th>
<th><?=$this->p_lang['classify']?></th>
<th><?=$this->p_lang['time']?></th>
<th><?=$this->p_lang['handle']?></th>
<th><?=$this->p_lang['sort']?></th>
</tr>
</thead>
<tbody>
<?
foreach($rs as $k => $v){
	?>
    <tr>
    <td><?=$v['nid']?></td>
    <td><?=$v['ntitle']?></td>
    <td><?=$cate[$v['cid']]['cname']?>&nbsp;&nbsp;<em><?=empty($v['outlink']) ? '<font color="#999999">'.$this->p_lang['outside'].'</font>' : '<font color="#46a546">'.$this->p_lang['outside'].'</font>'?>&nbsp;<?=($v['type'] == 2) ? '<font color="#b94a48">'.$this->p_lang['hot'].'</font>' : '<font color="#999999">'.$this->p_lang['hot'].'</font>'?>&nbsp;<?=($v['type'] == 1) ? '<font color="#3a87ad">'.$this->p_lang['recommend'].'</font>' : '<font color="#999999">'.$this->p_lang['recommend'].'</font>'?></em></td>
    <td><?=$v['ntime']?></td>
    <td><div class="btn-group">
  <a class="btn btn-primary" href="#"><i class="icon-th-list icon-white"></i> <?=$this->p_lang['handle']?></a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
  <ul class="dropdown-menu">
	<li><a href="<?=url(array('user', 'news_edit', $v['nid'], $v['cid']))?>"><i class="icon-pencil"></i> <?=$this->p_lang['edit']?></a></li>
	<li><a href="<?=url(array('user', 'news_del', $v['nid'], $v['cid']))?>"><i class="icon-trash"></i> <?=$this->p_lang['delete']?></a></li>
  </ul>
</div></td>
    <td><?=$v['nsort']?></td>
    </tr>
    <?
}
?>
<tr><td colspan="6"><?=$page?></td></tr>
</tbody></table>
  </div>

</div>
<?
$this->load_php('user/footer');
?></div>
</body>
</html>