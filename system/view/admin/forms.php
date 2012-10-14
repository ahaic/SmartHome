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
        <p><h2><?=(empty($type) ? $this->p_lang['model'] : $this->p_lang['form']).$this->p_lang['list']?>&nbsp;&nbsp;<a href="<?=empty($type) ? url(array('admin', 'forms_add')) : url(array('admin', 'forms_add', '1'))?>"><?=$this->p_lang['add']?></a></h2></p>
        <table class="table table-bordered">
<thead><tr>
<th><?=$this->p_lang['name']?></th><th><?=$this->p_lang['handle']?></th>
</tr></thead>
<tbody>
<?
foreach($rs as $k => $v){
?>
<tr>
	<td class="span10"><?=$v['name']?></td>
    <td><div class="btn-group">
  <a class="btn btn-primary" href="#"><i class="icon-th-list icon-white"></i> <?=$this->p_lang['handle']?></a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
  <ul class="dropdown-menu">
	<li><a href="<?=url(array('admin', 'forms_edit', $v['id'], $v['type']))?>"><i class="icon-pencil"></i> <?=$this->p_lang['edit']?></a></li>
	<li><a href="<?=url(array('admin', 'forms_del', $v['id'], $v['type']))?>"><i class="icon-trash"></i> <?=$this->p_lang['delete']?></a></li>
  </ul>
</div></td>
</tr>
<?
}
?>
</tbody></table>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>