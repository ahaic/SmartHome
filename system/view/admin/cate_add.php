<html>
<head>
<link rel=stylesheet href="styles/advanced/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.btnCode {
	background:transparent url(static/images/code.gif) no-repeat 16px 16px;
	background-position:2px 2px;
}
pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}
-->
</style>
<?
$this->load_js(array('jquery', 'xheditor-zh-cn.min', 'ajaxupload', 'prettify/prettify'));
$this->load_css('admin_style');
$td_style = "style='font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;'";
$input_style = 'style="width:200px;" class="kuang" onBlur="this.className=\'kuang\'" onFocus="this.className=\'kuang1\'"';
$editor = 'tools:\'Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,SelectAll,Removeformat,Align,List,|,Link,Unlink,Img,Flash,Media,Table,|,Fontface,FontSize,|,test4,Source,\',upImgUrl:\''.url(array('admin', 'ajax_upload')).'\',upImgExt:\'jpg,jpeg,gif,png\'';
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
				$('#cimg').val(json_str['msg']);		
			}
		});
	});
	
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
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['higher'].$this->p_lang['class']?></td><td  <?=$td_style?>><?=$cate_str?>
  <input name="con" type="checkbox" id="con" value="1" checked>&nbsp;<?=$this->p_lang['view']?>&nbsp;&nbsp;<input name="clinkture" type="checkbox" id="clinkture" onClick="on_link()" value="1">&nbsp;<?=$this->p_lang['outlink']?>&nbsp;&nbsp;<input name="csort" type="text" style="width:30px" value="1">&nbsp;<?=$this->p_lang['sort']?>
  <label for="con"></label></td></tr>
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['class'].$this->p_lang['name']?></td><td  <?=$td_style?>><input type="text" name="cname" id="cname" <?=$input_style?>></td></tr></table>
<table class="table2" width="100%" border="0" cellspacing="0" id="out_link" style="display:none">
  <tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['class'].$this->p_lang['outlink']?></td><td  <?=$td_style?>><input type="text" name="clink" id="clink" <?=$input_style?> value=""></td></tr>
  </table>
<table class="table2" id="not_out_link" width="100%" border="0" cellspacing="0">
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['class'].$this->p_lang['keyword']?></td><td  <?=$td_style?>><input type="text" name="ckeyword" id="ckeyword" <?=$input_style?>></td></tr>
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['class'].$this->p_lang['pic']?></td><td  <?=$td_style?>><input type="text" name="cimg" id="cimg" <?=$input_style?>>
  <input type="button" value="<?=$this->p_lang['upload']?>" id="upload_input"><input type="file" name="file_input" id="file_input" style="display:none"></td></tr>
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['class'].$this->p_lang['temp']?></td><td  <?=$td_style?>><input name="ctemp" type="text" id="ctemp" value="cate" <?=$input_style?>></td></tr>
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['content'].$this->p_lang['temp']?></td><td <?=$td_style?>><input name="ntemp" type="text" id="ntemp" value="view" <?=$input_style?>></td></tr>
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['model'].$this->p_lang['type']?></td><td <?=$td_style?>>
    <select name="cfield" id="cfield" style="width:200px">
    <?
    foreach($form_rs as $key => $val){
		echo '<option value="'.$val['id'].'">'.$val['name'].'</option>';
	}
	?>
     
    </select></td></tr>
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['class'].$this->p_lang['explanation']?></td><td  <?=$td_style?>><textarea name="cinfo" id="cinfo" style="width:600px; height:400px" onBlur="this.className='kuang'" class="xheditor {skin:'nostyle', plugins:allPlugin, loadCSS:'<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>',forcePtag:false, <?=$editor?>}"></textarea></td></tr>
</table>

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