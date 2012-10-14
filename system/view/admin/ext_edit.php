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
        <p><h2>
		<?
        switch($type){
			case 1:
				echo $this->p_lang['pages'];break;
			case 2:
				echo 'JS';break;
			case 3:
				echo 'XML';break;
			default:
				echo $this->p_lang['label'];break;		
		}
		?><?=$this->p_lang['add']?></h2></p><form action="" method="post">
          <table class="table">
  <tr>
    <td class="span2"><?=$this->p_lang['title']?></td>
    <td class="span10"><input name="etitle" type="text" id="etitle" value="<?=$rs['etitle']?>"></td>
  </tr>
  <tr>
    <td class="span2"><?=$this->p_lang['content']?></td>
    <td class="span10"><textarea name="einfo" rows="5" class="span6" id="einfo"><?=$rs['einfo']?></textarea></td>
  </tr>
  <tr><td colspan="4" align="center">
  <button type="submit" class="btn btn-primary btn-large" ><?=$this->p_lang['save']?></button>&nbsp;&nbsp;
            <button class="btn btn-large" type="reset"><?=$this->p_lang['cancel']?></button>
  </td></tr>
</table>
</form>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>