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
        <p><h2><?=$this->p_lang['template'].$this->p_lang['list']?>&nbsp;&nbsp;<a href="<?=url(array('admin', 'temp_add'))?>"><?=$this->p_lang['add']?></a></h2></p><form action="" method="post">
          <table class="table table-bordered">
<thead><tr><td><?=$this->p_lang['name']?></td><td><?=$this->p_lang['handle']?></td></tr></thead>
<tbody>
<?
foreach($rs as $k => $v){
?>
<tr>
	<td class="span10"><i class="icon-file"></i>&nbsp;<?=$v['name']?></td>
    <td><div class="btn-group">
  <a class="btn btn-primary" href="#"><i class="icon-th-list icon-white"></i> <?=$this->p_lang['handle']?></a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
  <ul class="dropdown-menu">
	<li><a href="<?=url(array('admin', 'temp_edit', $v['name']))?>"><i class="icon-pencil"></i> <?=$this->p_lang['edit']?></a></li>
	<li><a href="<?=url(array('admin', 'temp_del', $v['name']))?>"><i class="icon-trash"></i> <?=$this->p_lang['delete']?></a></li>
	<!--<li><a href="#"><i class="icon-ban-circle"></i> <?=$this->p_lang['ban']?></a></li>-->
  </ul>
</div></td>
</tr>
<?
}
?>
</tbody>
</form>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>