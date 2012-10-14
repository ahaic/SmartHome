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
       <div class="alert alert-block alert-<?=empty($isErr) ? 'success' : 'error'?> fade in">
            <h4 class="alert-heading"><?=empty($isErr) ? $this->p_lang['handle'].$this->p_lang['success'] : $this->p_lang['handle'].$this->p_lang['fail']?>!</h4>
            <p><?=empty($isErr) ? $this->p_lang['actInfo'] : $this->p_lang['actInfoErr']?>!</p>
            <p>
              <a class="btn <?=empty($isErr) ? 'btn-success' : 'btn-danger'?>" href="<?=$yesUrl?>"><?=$this->p_lang['continue'].$str?></a> <a class="btn" href="<?=$noUrl?>"><?=$this->p_lang['return'].$this->p_lang['list']?></a>
            </p>
          </div>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>