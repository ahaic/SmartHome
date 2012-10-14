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
function del(i){
	$.post('<?=url(array('admin', 'callback', 'links', 'index'))?>', {'id' : i, 'act' : 'del'}, function(data){
		if(data == '1'){
			window.location.reload();	
		}else{
			alert('删除失败');
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
        <p><h2><a href="<?=url(array('admin', 'ext', 3))?>"><?=$this->p_module?><?=$this->p_lang['manage']?></a></h2></p>
        <table class="table table-bordered">
        <thead><tr>
        <th class="span2">ID</th>
        <th class="span6"><?=$this->p_lang['title']?></th>
        <th class="span2"><?=$this->p_lang['handle']?></th>
        </tr></thead>
        <tbody>
        <?
        foreach($linksArr as $k => $v){
		?>
        <form name="form_edit_<?=$k?>" action="" method="post">
        <tr>
        <td><input type="text" name="name" id="name" value="<?=$v[0]?>" />
        	<input name="act" type="hidden" id="act" value="edit" />
    		<input type="hidden" name="id" id="id" value="<?=$k?>" />
    	</td>
        <td><input type="text" name="link" id="link" value="<?=$v[1]?>" /></td>
        <td><div class="btn-group">
  <a class="btn btn-primary" href="#"><i class="icon-th-list icon-white"></i> <?=$this->p_lang['handle']?></a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
  <ul class="dropdown-menu">
	<li><a onclick="form_edit_<?=$k?>.submit()" href="#"><i class="icon-pencil"></i> <?=$this->p_lang['edit']?></a></li>
	<li><a onclick="del(<?=$k?>)" href="#"><i class="icon-trash"></i> <?=$this->p_lang['delete']?></a></li>
  </ul>
</div></td>
        </tr>
        </form>
        <?
		}
		?>
         <form name="form_add" action="" method="post">
        <tr>        
        <td>
        <input type="text" name="name" id="name" />
    	<input name="act" type="hidden" id="act" value="add" />
        </td>
        <td>
        <input type="text" name="link" id="link" />
        </td><td><a onclick="form_add.submit()" class="btn btn-primary" href="#"><i class="icon-th-list icon-white"></i>添加</a></td></tr></form>
        </tbody>
        </table>
  </div>

</div></div>
</body>
</html>