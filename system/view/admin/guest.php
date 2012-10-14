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
        <p><h2><?=$this->p_lang['message'].$this->p_lang['list']?>&nbsp;&nbsp;<a href="<?=url(array('admin', 'guest', 1))?>"><?=$this->p_lang['reply'].$this->p_lang['list']?></a></h2></p>
        <table class="table table-bordered">
        <thead><tr>
        <th>ID</th>
        <th><?=$this->p_lang['title']?></th>
        <th><?=$this->p_lang['user']?></th>
        <th><?=$this->p_lang['time']?></th>
        <th><?=$this->p_lang['handle']?></th>
        </tr></thead>
        <tbody>
        <?
        foreach($rs as $k => $v){
		?>
        <tr>
        <td><?=$v['gid']?></td>
        <td><?=$v['gtitle']?></td>
        <td><?=empty($v['uid']) ? $this->p_lang['anonymous'] : $userRs[$v['uid']]['username']?></td>
        <td><?=$v['gtime']?></td>
        <td><div class="btn-group">
  <a class="btn btn-primary" href="#"><i class="icon-th-list icon-white"></i> <?=$this->p_lang['handle']?></a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
  <ul class="dropdown-menu">
	<li><a href="<?=url(array('admin', 'guest_edit', $v['gid'], $v['gtype']))?>"><i class="icon-pencil"></i> <?=$this->p_lang['edit']?></a></li>
	<li><a href="<?=url(array('admin', 'guest_del', $v['gid'], $v['gtype']))?>"><i class="icon-trash"></i> <?=$this->p_lang['delete']?></a></li>
  </ul>
</div></td>
        </tr>
        <?
		}
		?>
        <tr><td colspan="6"><?=$page?></td></tr>
        </tbody>
        </table>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>