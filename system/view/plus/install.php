<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QCMS 企业网站管理系统 - 安装</title>
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
$(function(){
	$('#dbDriver').change(function(){
		if($('#dbDriver').val() == '2'){
			$('.mysql').css('display', 'none');
		}else{
			$('.mysql').css('display', 'block');
		}	
	})	
})
</script>
</head>
<body>
<div class="container-fluid" style="padding-top:30px;">
  <div class="row-fluid">
  <div class="span2">
      &nbsp;
    </div>
    <div class="span10">
<form action="" method="post" class="span4"><h2 class="span4"><img src="<?=IMG_PATH?>logo.jpg"/>
  <div class="control-group"><label class="control-label">数据类型</label>
	<div class="controls docs-input-sizes">
      <select name="dbDriver" id="dbDriver">
        <option value="1">Mysql</option>
        <option value="2">Sqlite</option>
      </select></div>
  </div>
<div class="control-group" ><label class="control-label">数据名称</label>
<div class="controls docs-input-sizes">
      <input name="mysqlName" type="text" id="mysqlName" value="qcms"></div></div>
  <div class="control-group mysql"><label class="control-label">数据地址</label>
<div class="controls docs-input-sizes">
      <input name="mysqlHost" type="text" id="mysqlHost" value="localhost"></div></div>
<div class="control-group mysql"><label class="control-label">数据帐号</label>
<div class="controls docs-input-sizes">
      <input name="mysqlUsername" type="text" id="mysqlUsername" value="root"></div></div>
    <div class="control-group mysql"><label class="control-label">数据密码</label>
<div class="controls docs-input-sizes">
      <input name="mysqlPassword" type="text" id="mysqlPassword" value="123456"></div></div>
    <div class="control-group mysql"><label class="control-label">数据前惙</label>
<div class="controls docs-input-sizes">
      <input name="mysqlPrefix" type="text" id="mysqlPrefix" value="qcms_">
      </div></div>
          <div class="control-group">
<div class="controls docs-input-sizes">
      <input name="" value="安装" class="btn btn-large btn-primary" type="submit">
      </div></div>

</form>
    </div>
    
  </div>
</div>
</body>
</html>
