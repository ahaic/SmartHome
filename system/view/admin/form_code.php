<html>
<head>
<link rel=stylesheet href="styles/advanced/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$this->load_js(array('jquery', 'xheditor-zh-cn.min', 'ajaxupload', 'swfupload', 'swfupload.queue', 'fileprogress', 'handlers'));
$this->load_css('admin_style');
$td_style = "style='font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;'";
$input_style = 'style="width:200px;" class="kuang" onBlur="this.className=\'kuang\'" onFocus="this.className=\'kuang1\'"';
$editor = 'tools:\'Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,SelectAll,Removeformat,Align,List,|,Link,Unlink,Img,Flash,Media,Table,|,Fontface,FontSize,|,Source\',upImgUrl:\''.url(array('admin', 'ajax_upload')).'\',upImgExt:\'jpg,jpeg,gif,png\'';
$nfield = unserialize($rs[0]['nfield']);
?>
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
	});
	
function add()
{
	var $table=$("#tab tr");
	var len=$table.length;
	$("#tab").append("<tr id="+(len+1)+"><td <?=$td_style?>><?=$this->p_lang['field'].$this->p_lang['explanation']?></td><td <?=$td_style?>><input name='field_info["+len+"]' type='text' id='field_info["+len+"]' value='' class='kuangy' /> <font color='#ff0000'>*</font> </td><td <?=$td_style?>><?=$this->p_lang['field'].$this->p_lang['name']?></td><td <?=$td_style?>><input name='field_name["+len+"]' type='text' id='field_name["+len+"]' value='' class='kuangy' /> <font color='#ff0000'>*</font> </td><td <?=$td_style?>><input name='' type='button' value='<?=$this->p_lang['delete']?>' onClick='del("+(len+1)+")' style='border:1px #000000 solid;vertical-align:middle;height:25px'></td></tr>");　　　
}
function del(i)
{
	var $table=$("#tab tr");
	var len=$table.length;
	$("tr[id='"+i+"']").remove();　
}
	
function on_link()
{

	if($('#clinkture').attr('checked') == true) 
	{
		$('#out_link').show();	
		$('#not_out_link').hide();
	}
	else
	{
		$('#out_link').hide();	
		$('#not_out_link').show();
	}
}	

function cate_channge()
{
	window.location.href="<?=url(array('admin', 'news_edit', $id))?>?cid="+$('#cate').val()+"";	
}
</script>
</head>
<body>
<table width="100%" border="0"  cellpadding="0" cellspacing="0" style="background-image:url(<?=IMG_PATH?>bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle"><?=$this->p_lang['code']?></p></td>
  </tr>
</table>
<br />
<table class="table2" width="100%" border="0" cellspacing="0" id="out_link" style="display:none">
  <tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['class'].$this->p_lang['outlink']?></td><td  <?=$td_style?>><input type="text" name="clink" id="clink" <?=$input_style?> value=""></td></tr>
</table>
<table class="table2" id="not_out_link" width="100%" border="0" cellspacing="0">
<?
	$code_str = '';
	foreach ($str as $key => $val)
	{
		switch($val['field_type']){
			case 1:
			$code_str .= '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'><input type="input" '.$input_style.' name="nfield['.$val['field_name'].']" id="nfield['.$val['field_name'].']" value="" ></td></tr>';
			break;	
			case 2:
			$code_str .= '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'><textarea name="nfield['.$val['field_name'].']" id="nfield['.$val['field_name'].']" style="width:600px; height:400px" onBlur="this.className=\'kuang\'" class="xheditor {skin:\'nostyle\','.$editor.'}"></textarea></td></tr>';
			break;
			case 3:
			$temp_arr = array();
			$temp = '';
			$temp_arr = explode('|', $val['field_parameter']);
			foreach($temp_arr as $k => $v){
				$temp .= '<input name="nfield['.$val['field_name'].']" type="radio" value="'.$v.'">'.$v.' ';	
			}
			$code_str .= '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'>'.$temp.'</td></tr>';
			break;
			case 4:
			$temp_arr = array();
			$temp = '';
			$temp_arr = explode('|', $val['field_parameter']);
			foreach($temp_arr as $k => $v){
				$temp .= '<input name="nfield['.$val['field_name'].'][]" type="checkbox" value="'.$v.'" >'.$v.' ';	
			}
			$code_str .= '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'>'.$temp.'</td></tr>';
			break;
			case 5:

            $code_str .=  "<script>
$(document).ready(function(){
		var button_".$val['field_name']." = $('#upload_input_".$val['field_name']."'), interval;			
		new AjaxUpload(button_".$val['field_name'].", {
			action: '".url(array('admin', 'ajax_upload'))."', 
			name: 'filedata',
			onSubmit : function(file, ext){
				this.disable();			
			},			
			onComplete: function(file, response){	
				var json_str = eval(\"(\" + response + \")\");
				if(json_str['err'] != \"\")
				{
					this.enable();
					alert(json_str['err']);return;
				}
				window.clearInterval(interval);
				this.enable();				
				$('#nimg_".$val['field_name']."').val(json_str['msg']);		
			}
		});		
});</script>";

			$code_str .=  '<tr bgcolor="#f9f9f9"><td '.$td_style.' width="110">'.$val['field_info'].'</td><td  '.$td_style.'><input type="input" '.$input_style.' name="nfield['.$val['field_name'].']" id="nimg_'.$val['field_name'].'" value="" ><input type="button" value="'.$this->p_lang['upload'].'" id="upload_input_'.$val['field_name'].'"></td></tr>';
			break;
		}
		
	}
?>
<textarea name="" style="width:100%; height:300px"><?=htmlspecialchars('<form action="'.url(array('home', 'form', $id)).'" method="post"><table>'.$code_str.'<tr bgcolor="#f9f9f9"><td colspan="2"><input name="" type="submit" value="'.$this->p_lang['submit'].'" /></td></tr></table></form>')?></textarea>
</table>

<br /><br />
<?
$this->load_php('admin/footer');
?>

</body>
</html>