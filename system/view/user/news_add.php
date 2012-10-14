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
$this->load_php('user/header');
?>
<div class="container" style="max-width:1080px">
<div class="row-fluid">
  <div class="span2">
  <p><h2><?=$this->p_lang['news'].$this->p_lang['add']?></h2></p>
  <ul class="nav nav-pills nav-stacked">

        <li class="active"><a href="<?=url(array('user', 'index'))?>"><?=$this->p_lang['welcome']?>：<?=$_COOKIE['user']['username']?></a></li>
      <li><a href="<?=url(array('user', 'edit'))?>"><?=$this->p_lang['data'].$this->p_lang['manage']?></a></li>
      <li><a href="<?=url(array('user', 'password'))?>"><?=$this->p_lang['password'].$this->p_lang['manage']?></a></li>
	  <?
		$level = array(1,2);
		if(in_array($_COOKIE['user']['level'], $level))
		{		
	  ?>
	  <li><a href="<?=url(array('user', 'news'))?>"><?=$this->p_lang['content'].$this->p_lang['manage']?></a></li>
	  <li><a href="<?=url(array('user', 'news_add'))?>"><?=$this->p_lang['content'].$this->p_lang['add']?></a></li>
	  <?
	  }
	  ?>
      <!--<li><a href="<?=url(array('user', 'order'))?>"><?=$this->p_lang['business'].$this->p_lang['manage']?></a></li>
      <li><a href="<?=url(array('user', 'money'))?>"><?=$this->p_lang['finance'].$this->p_lang['manage']?></a></li>
      <li><a href="#">Discuz! X1.5 用户接口</a></li>
      <li><a href="#">PHPwind API 用户接口</a></li>
      <li><a href="#">新浪微博API用户接口</a></li>
      <li>QQ微博API用户接口</li>-->
      <li><a href="<?=url(array('home', 'logout'))?>"><?=$this->p_lang['logout']?></a></li>
      </ul>
  </div>
  <div class="span10" style="min-height:450px">
        <p><h2><?=$this->p_lang['user'].$this->p_lang['info']?></h2></p><form action="" method="post">

<table class="table">
<tr><td class="span2"><?=$this->p_lang['select'].$this->p_lang['classify']?></td><td><?=$cate_str?></td></tr>
<tr><td><?=$this->p_lang['content'].$this->p_lang['name']?></td><td><input type="text" name="ntitle" id="ntitle"> <input name="nsort" type="text" id="nsort" style="width:15px" value="0">&nbsp;<?=$this->p_lang['sort']?>

  <input name="outlink" type="checkbox" id="outlink" value="1">&nbsp;<?=$this->p_lang['outlink']?>
</td></tr>
  <tr class=".out_link" style="display:none"><td><?=$this->p_lang['class'].$this->p_lang['outlink']?></td><td><input type="text" name="clink" id="clink" value=""></td></tr>

<tr class="not_out_link"><td><?=$this->p_lang['content'].$this->p_lang['keyword']?></td><td><input type="text" name="nkeyword" id="nkeyword" ></td></tr>
<tr class="not_out_link"><td><?=$this->p_lang['content'].$this->p_lang['pic']?></td><td><input type="text" name="nimg" id="nimg">
  <input type="button" value="<?=$this->p_lang['upload']?>" id="upload_input" onClick="upload('nimg')" class="btn-small btn-inverse"></td></tr>

<tr class="not_out_link"><td><?=$this->p_lang['content']?></td><td><textarea name="ncontent" id="ncontent" style="width:600px; height:400px" class="xheditor {skin:'nostyle',plugins:allPlugin,loadCSS:'<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>',forcePtag:false,<?=$editor?>}"></textarea></td></tr>
<tr class="not_out_link"><td><?=$this->p_lang['content'].$this->p_lang['time']?></td><td><input type="text" name="ntime" id="ntime" value="<?=date('Y-m-d H:i:s')?>"></td></tr>
<?
if(!empty($cfield))
{
	foreach ($cfield as $key => $val)
	{
		switch($val['field_type']){
			case 1:
			echo '<tr class="not_out_link"><td>'.$val['field_info'].'</td><td><input type="input" name="nfield['.$val['field_name'].']" id="nfield['.$val['field_name'].']" ></td></tr>';
			break;	
			case 2:
			echo '<tr class="not_out_link"><td>'.$val['field_info'].'</td><td><textarea name="nfield['.$val['field_name'].']" id="nfield['.$val['field_name'].']" style="width:600px; height:400px" class="xheditor {skin:\'nostyle\','.$editor.'}"></textarea></td></tr>';
			break;
			case 3:
			$temp_arr = array();
			$temp = '';
			$temp_arr = explode('|', $val['field_parameter']);
			foreach($temp_arr as $k => $v){
				$temp .= '<input name="nfield['.$val['field_name'].']" type="radio" value="'.$v.'">'.$v.' ';	
			}
			echo '<tr class="not_out_link"><td>'.$val['field_info'].'</td><td>'.$temp.'</td></tr>';
			break;
			case 4:
			$temp_arr = array();
			$temp = '';
			$temp_arr = explode('|', $val['field_parameter']);
			foreach($temp_arr as $k => $v){
				$temp .= '<input name="nfield['.$val['field_name'].'][]" type="checkbox" value="'.$v.'">'.$v.' ';	
			}
			echo '<tr class="not_out_link"><td>'.$val['field_info'].'</td><td>'.$temp.'</td></tr>';
			break;
			case 5:
			?>
            <script>
$(document).ready(function(){
		var button_<?=$val['field_name']?> = $('#upload_input_<?=$val['field_name']?>'), interval;			
		new AjaxUpload(button_<?=$val['field_name']?>, {
			action: '<?=url(array('admin', 'ajax_upload'))?>', 
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
				$('#nimg_<?=$val['field_name']?>').val(json_str['msg']);		
			}
		});		
});</script>
            <?
			echo '<tr class="not_out_link"><td>'.$val['field_info'].'</td><td><input type="input" name="nfield['.$val['field_name'].']" id="nimg_'.$val['field_name'].'" ><input type="button" value="'.$this->p_lang['upload'].'" id="upload_input_'.$val['field_name'].'"></td></tr>';
			break;
			case 6:
			?>

<script type="text/javascript">
var swfu;
window.onload = function() {
	var settings = {
		flash_url : "<?=JS_PATH?>swfupload.swf",
		upload_url: "<?=url(array('admin', 'upload_swf'))?>",
		post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
		file_size_limit : "100 MB",
		file_types : "*.*",
		file_types_description : "All Files",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		button_width: "100px",
		button_height: "25",
		button_placeholder_id: "spanButtonPlaceHolder",
		button_text: '<span class="theFont"><?=$this->p_lang['please'].$this->p_lang['select'].$this->p_lang['file']?></span>',
		button_text_style: ".theFont {font-size: 12px; border:1px solid #000000; color:#ff2200; font-weight:bold;}",
		button_text_left_padding: 12,
		button_text_top_padding: 3,
		
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete	// Queue plugin event
	};

	swfu = new SWFUpload(settings);
 };
 
function get_pic(){
	$.get("<?=url(array('admin', 'pic'))?>&r="+Math.random()+"", function(data){
  		$("#nfield_<?=$val['field_name']?>").val(data);
	});	
}
</script>

<tr class="not_out_link">
	<td><?=$this->p_lang['batch'].$this->p_lang['upload']?></td>
	<td>
		<span id="spanButtonPlaceHolder" style="font-size: 12px;float: left;height: 100px;width: 100px;"></span>
		<div class="fieldset flash" id="fsUploadProgress"><strong class="legend"><?=$this->p_lang['upload'].$this->p_lang['queue']?>:</strong><strong id="divStatus">0<?=$this->p_lang['upload'].$this->p_lang['file']?></strong></div>		<input id="btnCancel" type="button" value="<?=$this->p_lang['cancel'].$this->p_lang['upload'].$this->p_lang['queue']?>" onClick="swfu.cancelQueue();" disabled="disabled" style="float:left; margin-left: 2px; font-size: 12px;" />
        <input type="hidden" name="nfield[<?=$val['field_name']?>]" id="nfield_<?=$val['field_name']?>" >
	</td>
</tr>

            <?
			break;
		}
		
	}
}
?>
<tr>
  <td colspan="5" align="center"><button type="submit" class="btn btn-primary btn-large" ><?=$this->p_lang['save']?></button>&nbsp;&nbsp;
            <button class="btn btn-large" type="reset"><?=$this->p_lang['cancel']?></button></td></tr>
</table></form>
  </div>

</div>
<?
$this->load_php('user/footer');
?></div>
</body>
</html>