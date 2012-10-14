<html>
<head>
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
$this->load_css(array('admin_style','syntaxhighlighter/shCore','syntaxhighlighter/shThemeDefault'));
$td_style = "style='font-size:12px;border-right-width: 1px;border-bottom-width: 1px;border-right-style: solid;border-bottom-style: solid;border-right-color: #cccccc;border-bottom-color: #cccccc;margin: 0px;padding-left: 10px;padding-top: 10px;padding-bottom: 10px;'";
$input_style = 'style="width:200px;" class="kuang" onBlur="this.className=\'kuang\'" onFocus="this.className=\'kuang1\'"';
?>
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
<tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['select'].$this->p_lang['class']?></td><td  <?=$td_style?>><?=$cate_str?></td></tr></table>
<table class="table2" width="100%" border="0" cellspacing="0" id="out_link" style="display:none">
  <tr bgcolor="#f9f9f9"><td <?=$td_style?> width="110"><?=$this->p_lang['class'].$this->p_lang['outlink']?></td><td  <?=$td_style?>><input type="text" name="clink" id="clink" <?=$input_style?> value=""></td></tr>
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