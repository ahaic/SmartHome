<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>友情链接管理</title>
<?
$this->load_js('jquery');
$this->load_css('admin_style');
?>
<script>
function del(i){
	$.post('<?=url(array('admin', 'callback', 'links', 'index'))?>', {'id' : i, 'act' : 'del'}, function(data){
		if(data == '1'){
			alert('删除成功');
			window.location.reload();	
		}else{
			alert('删除失败');
		}
	})
}
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(/static/images/bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle">友情链接</p></td>
  </tr>
</table>
<br />
<table class="table" width="100%" border="0" cellspacing="0">
<tr bgcolor="#F9F9F9"><td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;">名称</td>
    <td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;">地址</td>
    <td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;">操作</td>
  </tr>
  <?
  foreach($linksArr as $k => $v){
  ?>
  <form name="form_edit_<?=$k?>" action="" method="post"><tr bgcolor="#F9F9F9">
    <td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"><input type="text" name="name" id="name" value="<?=$v[0]?>" />
    <input name="act" type="hidden" id="act" value="edit" />
    <input type="hidden" name="id" id="id" value="<?=$k?>" /></td>
    <td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"><input type="text" name="link" id="link" value="<?=$v[1]?>" /></td> 
    <td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"><a onclick="form_edit_<?=$k?>.submit()">修改</a>&nbsp;&nbsp;<a onclick="del(<?=$k?>)">删除</a></td>
  </tr></form>
  <?
  }
  ?>
  <form name="form_add" action="" method="post"><tr bgcolor="#F9F9F9">
    <td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;">
    <input type="text" name="name" id="name" />
    <input name="act" type="hidden" id="act" value="add" /></td>
    <td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;">
    <input type="text" name="link" id="link" /></td> 
   <td   style="font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;"><a onclick="form_add.submit()">添加</a></td>
  </tr></form>
</table>
</body>
</html>
