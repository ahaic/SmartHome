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
$this->load_js(array('jquery', 'bootstrap-dropdown', 'ajaxupload'));
?>
<script>
$('.dropdown-toggle').dropdown()
$(function(){
	var button = $('#upload_input'), interval;		
	new AjaxUpload(button, {
		action: '<?=SITEPATH?>index.php?q=admin/ajax_upload.html', 
		name: 'filedata',
		onSubmit : function(file, ext){
			this.disable();			
		},			
		onComplete: function(file, response){	
			var json_str = eval("(" + response + ")");
			if(json_str['err'] != "")
			{
				this.enable();
				alert(json_str['err']);return;
			}
			window.clearInterval(interval);
			this.enable();				
			$('#logo').val(json_str['msg']);		
		}
	});
})
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
        <iframe src="http://www.q-cms.cn/help/?n=<?=base64_encode($_SERVER['HTTP_HOST'].$this->p_site['connect'])?>" width="100%" height="400px" frameborder="0" ></iframe>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>