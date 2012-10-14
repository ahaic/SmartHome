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
        <p><h2><?=$this->p_lang['user'].$this->p_lang['list']?>&nbsp;&nbsp;<a href="<?=url(array('admin', 'user_add'))?>"><?=$this->p_lang['add']?></a></h2></p>
        
<br />
<table class="table table-bordered">
<thead><tr>
<th>ID</th>
<th><?=$this->p_lang['account']?></th>
<th><?=$this->p_lang['level']?></th>
<th><?=$this->p_lang['sex']?></th>
<th><?=$this->p_lang['email']?></th>
<th><?=$this->p_lang['money']?></th>
<th><?=$this->p_lang['add'].$this->p_lang['time']?></th>
<th><?=$this->p_lang['handle']?></th>
</tr></thead>
<tbody>
<?
foreach($rs as $k => $v){
?>
<tr>
	<td><?=$v['uid']?></td>
    <td><?=$v['username']?></td>
    <td><?
    switch($v['level']){
		case 1:
		echo $this->p_lang['administrator'];break;
		case 2:
		echo $this->p_lang['editor'];break;	
		default:
		echo $this->p_lang['general'].$this->p_lang['user'];break;	
	}
	?></td>
    <td><?=empty($v['sex']) ? $this->p_lang['man'] : $this->p_lang['woman']?></td>
    <td><?=$v['email']?></td>
    <td><?=$v['money']?></td>
    <td><?=substr($v['add_time'], 0, 10)?></td>
    <td><div class="btn-group">
  <a class="btn btn-primary" href="#"><i class="icon-user icon-white"></i> <?=$this->p_lang['handle']?></a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
  <ul class="dropdown-menu">
	<li><a href="<?=url(array('admin', 'user_edit', $v['uid']))?>"><i class="icon-pencil"></i> <?=$this->p_lang['edit']?></a></li>
	<li><a href="<?=url(array('admin', 'user_del', $v['uid']))?>"><i class="icon-trash"></i> <?=$this->p_lang['delete']?></a></li>
	<!--<li><a href="#"><i class="icon-ban-circle"></i> <?=$this->p_lang['ban']?></a></li>-->
  </ul>
</div></td>
</tr>
<?
}
?>
<tr><td colspan="8"><?=$page?></td></tr>
</tbody>
</table>
        
</div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>        