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
        <p><h2><?=$this->p_lang['data'].$this->p_lang['center']?>&nbsp;&nbsp;<a href="<?=url(array('admin', 'data', 'backup'))?>"><?=$this->p_lang['backup']?></a></h2></p>
        
<br />
<table class="table table-bordered">
<?
$i = 0;
foreach($dir_arr as $key => $val){
	$i += 1;
?>
<tr>
	<td><?=$i?></td>
    <td><?=$val?></td>
    <td><a href="<?=url(array('admin', 'data', 'backin', $val))?>"><u><?=$this->p_lang['import']?></u></a></td>
</tr>
<?
}
?>
</table>
        
</div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>        