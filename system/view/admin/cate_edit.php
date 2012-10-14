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
$this->load_js(array('jquery', 'bootstrap-dropdown', 'xheditor-zh-cn.min', 'ajaxupload'));
$editor = 'tools:\'Bold,Italic,Underline,Strikethrough,FontColor,BackColor,|,SelectAll,Removeformat,Align,List,|,Link,Unlink,Img,Flash,Media,Table,|,Fontface,FontSize,|,test4,Source,\',upImgUrl:\''.url(array('admin', 'ajax_upload')).'\',upImgExt:\'jpg,jpeg,gif,png\'';
?>
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

<script>
$('.dropdown-toggle').dropdown()

var allPlugin={
         test4:{c:'btnCode',t:'<?=$this->p_lang['code']?>',s:'ctrl+4',h:1,e:function(){
            var _this=this;
			var htmlCode='<div><select id="xheCodeType"><option value="html">HTML/XML</option><option value="javascript">JavaScript</option><option value="css">CSS</option><option value="php">PHP</option><option value="csharp">C#</option><option value="cpp">C++</option><option value="java">Java</option><option value="perl">Perl</option><option value="python">Python</option><option value="ruby">Ruby</option><option value="vb">Visual Basic</option><option value="delphi">Delphi</option><option value="as3">Action Script 3</option><option value="sql">SQL</option><option value="plain">其它</option></select></div><div><textarea id="xheCodeValue" wrap="soft" spellcheck="false" style="width:300px;height:100px;" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="<?=$this->p_lang['submit']?>" /></div>';
			var jCode=$(htmlCode),jType=$('#xheCodeType',jCode),jValue=$('#xheCodeValue',jCode),jSave=$('#xheSave',jCode);
			jSave.click(function(){
				_this.loadBookmark();
				_this.pasteHTML('<pre class="prettyprint lang-'+jType.val()+';">\r\n'+_this.domEncode(jValue.val())+'\r\n</pre>');
				_this.hidePanel();
				return false;	
			});
			_this.saveBookmark();
			_this.showDialog(jCode);
        }}
    };

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
		
		if(<?=$rs[0]['clinkture']?> == '1') 
		{
			$('.out_link').show();	
			$('.not_out_link').hide();
		}
		else
		{
			$('.out_link').hide();	
			$('.not_out_link').show();
		}
	});
	
function on_link()
{
	if($('#clinkture').attr('checked') == 'checked') 
	{
		$('.out_link').show();	
		$('.not_out_link').hide();
	}
	else
	{
		$('.out_link').hide();	
		$('.not_out_link').show();
	}
}	
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
        <p><h2><?=$this->p_lang['classify'].$this->p_lang['edit']?></h2></p><form action="" method="post">
<table class="table">
<tr><td class="span2"><?=$this->p_lang['higher'].$this->p_lang['classify']?></td><td><?=$cate_str?>
 &nbsp;<input name="csort" type="text" value="<?=$rs[0]['csort']?>" style="width:15px;">&nbsp;<?=$this->p_lang['sort']?>&nbsp;&nbsp;
 <input name="con" type="checkbox" id="con" value="1" <? if($rs[0]['con'] == 1)echo 'checked';?>>&nbsp;<?=$this->p_lang['show']?>&nbsp;&nbsp;<input name="clinkture" type="checkbox" id="clinkture" onClick="on_link()" value="1" <? if($rs[0]['clinkture'] == 1)echo 'checked';?>>&nbsp;<?=$this->p_lang['outside']?>
  <label for="con"></label></td></tr>
<tr><td><?=$this->p_lang['classify'].$this->p_lang['name']?></td><td><input type="text" name="cname" id="cname" value="<?=$rs[0]['cname']?>"></td></tr>
  <tr class="out_link" style=" display: none"><td class="span2"><?=$this->p_lang['classify'].$this->p_lang['outlink']?></td><td><input type="text" name="clink" id="clink" value="<?=$rs[0]['clink']?>"></td></tr>

<tr class="not_out_link"><td class="span2"><?=$this->p_lang['classify'].$this->p_lang['keyword']?></td><td><input type="text" name="ckeyword" id="ckeyword" value="<?=$rs[0]['ckeyword']?>"></td></tr>
<tr class="not_out_link"><td><?=$this->p_lang['classify'].$this->p_lang['pic']?></td><td><input type="text" name="cimg" id="cimg" value="<?=$rs[0]['cimg']?>">
  <input type="button" class="btn-small btn-inverse" value="<?=$this->p_lang['upload']?>" id="upload_input"><input type="file" name="file_input" id="file_input" style="display:none"></td></tr>
<tr class="not_out_link"><td><?=$this->p_lang['classify'].$this->p_lang['template']?></td><td><input name="ctemp" type="text" id="ctemp" value="<?=$rs[0]['ctemp']?>"></td></tr>
<tr class="not_out_link"><td><?=$this->p_lang['content'].$this->p_lang['template']?></td><td><input name="ntemp" type="text" id="ntemp" value="<?=$rs[0]['ntemp']?>"></td></tr>
<tr class="not_out_link"><td><?=$this->p_lang['model'].$this->p_lang['type']?></td><td>
    <select name="cfield" id="cfield">
    <?
    foreach($form_rs as $key => $val){
		$select = ($val['id'] == $rs[0]['cfield']) ? 'selected' : '';
		echo '<option value="'.$val['id'].'" '.$select.'>'.$val['name'].'</option>';
	}
	?>
     
    </select></td></tr>
<tr class="not_out_link"><td><?=$this->p_lang['classify'].$this->p_lang['content']?></td><td><textarea name="cinfo" id="cinfo" style="width:600px; height:400px" onBlur="this.className='kuang'" class="xheditor {skin:'nostyle', plugins:allPlugin, loadCSS:'<style>pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>',forcePtag:false, <?=$editor?>}"><?=$rs[0]['cinfo']?></textarea></td></tr>
<tr>
  <td colspan="5"><button type="submit" class="btn btn-primary btn-large" ><?=$this->p_lang['save']?></button>&nbsp;&nbsp;
            <button class="btn btn-large" type="reset"><?=$this->p_lang['cancel']?></button></td></tr>
</table></form>
  </div>

</div></div>
<?
  $this->load_php('admin/footer');
?>
</body>
</html>