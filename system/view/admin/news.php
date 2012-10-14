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
        <p><h2><?=$this->p_lang['content'].$this->p_lang['list']?>&nbsp;&nbsp;<a href="<?=url(array('admin', 'news_add'))?>"><?=$this->p_lang['add']?></a></h2></p>
<table class="table table-bordered"><thead>
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
	<li><a href="<?=url(array('admin', 'news_edit', $v['nid'], $v['cid']))?>"><i class="icon-pencil"></i> <?=$this->p_lang['edit']?></a></li>
	<li><a href="<?=url(array('admin', 'news_del', $v['nid'], $v['cid']))?>"><i class="icon-trash"></i> <?=$this->p_lang['delete']?></a></li>
	<li><a href="<?=url(array('admin', 'news_hot', $v['nid']))?>"><i class="icon-check"></i> <?=$this->p_lang['recommend']?></a></li>
    <li><a href="<?=url(array('admin', 'news_recommend', $v['nid']))?>"><i class="icon-fire"></i> <?=$this->p_lang['hot']?></a></li>
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

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>