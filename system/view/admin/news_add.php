<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.btnCode {
	background:transparent url(<?=IMG_PATH?>code.gif) no-repeat 16px 16px;
	background-position:2px 2px;
}
.plus {
	background:transparent url(<?=IMG_PATH?>plugin.gif) no-repeat 16px 16px;
	background-position:2px 2px;
}
pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}
-->
</style>
<?
$this->load_js(array('jquery', 'xheditor-zh-cn.min', 'ajaxupload', 'swfupload', 'swfupload.queue', 'fileprogress', 'handlers', 'prettify/prettify'));
$this->load_css(array('admin_style'));
$td_style = "style='font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;'";
$input_style = 'style="width:200px;" class="kuang" onBlur="this.className=\'kuang\'" onFocus="this.className=\'kuang1\'"';
$editor = 'tools:\'Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,SelectAll,Removeformat,Align,List,|,Link,Unlink,Img,Flash,Media,Table,|,Fontface,FontSize,|,test4,test2,Source,\',upImgUrl:\''.url(array('admin', 'ajax_upload')).'\',upImgExt:\'jpg,jpeg,gif,png\'';
?>
<script>
var allPlugin={
         test4:{c:'btnCode',t:'插入代码',s:'ctrl+4',h:1,e:function(){
            var _this=this;
			var htmlCode='<div><select id="xheCodeType"><option value="html">HTML/XML</option><option value="javascript">JavaScript</option><option value="css">CSS</option><option value="php">PHP</option><option value="csharp">C#</option><option value="cpp">C++</option><option value="java">Java</option><option value="perl">Perl</option><option value="python">Python</option><option value="ruby">Ruby</option><option value="vb">Visual Basic</option><option value="delphi">Delphi</option><option value="as3">Action Script 3</option><option value="sql">SQL</option><option value="plain">其它</option></select></div><div><textarea id="xheCodeValue" wrap="soft" spellcheck="false" style="width:300px;height:100px;" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="确定" /></div>';
			var jCode=$(htmlCode),jType=$('#xheCodeType',jCode),jValue=$('#xheCodeValue',jCode),jSave=$('#xheSave',jCode);
			jSave.click(function(){
				_this.loadBookmark();
				_this.pasteHTML('<pre class="prettyprint lang-'+jType.val()+';">\r\n'+_this.domEncode(jValue.val())+'\r\n</pre>');
				_this.hidePanel();
				return false;	
			});
			_this.saveBookmark();
			_this.showDialog(jCode);
			
            //var jTest=$('<div style="padding:5px;">测试showPanel</div>');
            //_this.showPanel(jTest);
        }},
		test2:{c:'plus',t:'插入分页',s:'ctrl+4',e:function(){
			var _this=this;
			_this.pasteHTML('[page]');
		}}
    };
</script>
<script>
$(document).ready(function(){	
		var button = $('#upload_input'), interval;			
		new AjaxUpload(button, {
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
				$('#nimg').val(json_str['msg']);		
			}
		});		
		$('#outlink').click(function(){
			if($('#outlink').attr('checked') == true){
				$('#out_link').css('display', 'block');
				$('#not_out_link').css('display', 'none');
			}else{
				$('#out_link').css('display', 'none');
				$('#not_out_link').css('display', 'block');
			}
		})
		
});

function cate_channge()
{
	window.location.href="<?=url(array('admin', 'news_add'))?>&cid="+$('#cate').val()+"";	
}
</script>
</head>
<body>
<form action="" method="post">
<table width="100%" border="0"  cellpadding="0" cellspacing="0" style="background-image:url(<?=IMG_PATH?>bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle"><?=$title?></p></td>
  </tr>
</table>
<br />
<table class="table" width="100%" border="0" cellspacing="0">
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['select'].$this->p_lang['class']?></td><td  <?=$td_style?>><?=$cate_str?></td></tr>
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['content'].$this->p_lang['title']?></td><td  <?=$td_style?>><input type="text" name="ntitle" id="ntitle" <?=$input_style?>> <input name="nsort" type="text" id="nsort" style="width:30px" value="0">&nbsp;<?=$this->p_lang['sort']?>

  <input name="outlink" type="checkbox" id="outlink" value="1">&nbsp;<?=$this->p_lang['outlink']?>
</td></tr></table>
<table class="table2" width="100%" border="0" cellspacing="0" id="out_link" style="display:none">
  <tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['class'].$this->p_lang['outlink']?></td><td  <?=$td_style?>><input type="text" name="clink" id="clink" <?=$input_style?> value=""></td></tr>
  </table>
<table class="table2" id="not_out_link" width="100%" border="0" cellspacing="0">
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['content'].$this->p_lang['keyword']?></td><td  <?=$td_style?>><input type="text" name="nkeyword" id="nkeyword" <?=$input_style?>></td></tr>
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['content'].$this->p_lang['pic']?></td><td  <?=$td_style?>><input type="text" name="nimg" id="nimg" <?=$input_style?>>
  <input type="button" value="<?=$this->p_lang['upload']?>" id="upload_input" onClick="upload('nimg')"></td></tr>

<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['content']?></td><td  <?=$td_style?>><textarea name="ncontent" id="ncontent" style="width:600px; height:400px" onBlur="this.className='kuang'" class="xheditor {skin:'nostyle',plugins:allPlugin,loadCSS:'<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>',forcePtag:false,<?=$editor?>}"></textarea></td></tr>
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['content'].$this->p_lang['time']?></td><td  <?=$td_style?>><input type="text" name="ntime" id="ntime" <?=$input_style?> value="<?=date('Y-m-d H:i:s')?>"></td></tr>
<?
if(!empty($cfield))
{
	foreach ($cfield as $key => $val)
	{
		switch($val['field_type']){
			case 1:
			echo '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'><input type="input" '.$input_style.' name="nfield['.$val['field_name'].']" id="nfield['.$val['field_name'].']" ></td></tr>';
			break;	
			case 2:
			echo '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'><textarea name="nfield['.$val['field_name'].']" id="nfield['.$val['field_name'].']" style="width:600px; height:400px" onBlur="this.className=\'kuang\'" class="xheditor {skin:\'nostyle\','.$editor.'}"></textarea></td></tr>';
			break;
			case 3:
			$temp_arr = array();
			$temp = '';
			$temp_arr = explode('|', $val['field_parameter']);
			foreach($temp_arr as $k => $v){
				$temp .= '<input name="nfield['.$val['field_name'].']" type="radio" value="'.$v.'">'.$v.' ';	
			}
			echo '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'>'.$temp.'</td></tr>';
			break;
			case 4:
			$temp_arr = array();
			$temp = '';
			$temp_arr = explode('|', $val['field_parameter']);
			foreach($temp_arr as $k => $v){
				$temp .= '<input name="nfield['.$val['field_name'].'][]" type="checkbox" value="'.$v.'">'.$v.' ';	
			}
			echo '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'>'.$temp.'</td></tr>';
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
			echo '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'><input type="input" '.$input_style.' name="nfield['.$val['field_name'].']" id="nimg_'.$val['field_name'].'" ><input type="button" value="'.$this->p_lang['upload'].'" id="upload_input_'.$val['field_name'].'"></td></tr>';
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
		button_text: '<span class="theFont">请选择文件</span>',
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

<tr bgcolor="#f9f9f9">
	<td <?=$td_style?>>批量上传：</td>
	<td <?=$td_style?>>
		<span id="spanButtonPlaceHolder" style="font-size: 12px;float: left;height: 100px;width: 100px;"></span>
		<div class="fieldset flash" id="fsUploadProgress"><strong class="legend">上传队列：</strong><strong id="divStatus">0个上传文件</strong></div>		<input id="btnCancel" type="button" value="取消所有上传的文件" onClick="swfu.cancelQueue();" disabled="disabled" style="float:left; margin-left: 2px; font-size: 12px;" />
        <input type="hidden" <?=$input_style?> name="nfield[<?=$val['field_name']?>]" id="nfield_<?=$val['field_name']?>" >
	</td>
</tr>

            <?
			break;
		}
		
	}
}
?>
</table>
<table class="table2" width="100%" border="0" cellspacing="0" id="tab"></table>
<table class="table2" width="100%" border="0" cellspacing="0">
<tr bgcolor="#f9f9f9">
  <td colspan="5" <?=$td_style?> align="center"><input type="submit" value="<?=$this->p_lang['submit']?>" style="border:1px #000000 solid;vertical-align:middle;height:25px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="button2" id="button2" value="<?=$this->p_lang['reset']?>" style="border:1px #000000 solid;vertical-align:middle;height:25px"/></td></tr>
</table></form>
<br />
<?
$this->load_php('admin/footer');
?>
</body>
</html>