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
function install(name){
	$.post('<?=url(array('admin', 'plus', 'install'))?>', {'module' : name}, function(data){
		if(data == '1'){
			alert('安装成功');
			document.location.reload();
		}else if(data == '0'){
			alert('安装失败');	
		}else{
			alert('没有配置文件');	
		}
	})
}

function uninstall(name){
	$.post('<?=url(array('admin', 'plus', 'uninstall'))?>', {'module' : name}, function(data){
		if(data == '1'){
			alert('卸载成功');
			document.location.reload();
		}else{
			alert('卸载失败');	
		}
	})
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
        <p><h2><?=$this->p_lang['plugin'].$this->p_lang['manage']?>&nbsp;&nbsp;<a href="<?=url(array('admin', 'ext_add', $type))?>"><?=$this->p_lang['add']?></a>
</ul>
</h2></p>
        <table class="table table-bordered">
        <thead><tr>
        <th class="span2">ID</th>
        <th class="span4"><?=$this->p_lang['title']?></th>
        <th class="span2"><?=$this->p_lang['status']?></th>
        <th class="span2"><?=$this->p_lang['handle']?></th>
        </tr></thead>
        <tbody>
        <?
		$i = 0;
        foreach($this->plusArr as $k => $v){
			$i++;
		?>
        <tr>
        <td><?=$i?></td>
        <td><?=$k?></td>
        <td><?=empty($v) ? $this->p_lang['not'].$this->p_lang['install'] : $this->p_lang['already'].$this->p_lang['install']?></td>
        <td><div class="btn-group">
  <a class="btn btn-primary" href="#" <?=empty($v) ? 'onClick="install(\''.$k.'\')"' : 'onClick="uninstall(\''.$k.'\')"'?>><i class="icon-th-list icon-white"></i> <?=empty($v) ? $this->p_lang['install'] : $this->p_lang['uninstall']?></a>
  
</div></td>
        </tr>
        <?
		}
		?>
        </tbody>
        </table>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>