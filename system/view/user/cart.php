<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="UTF-8">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="UTF-8" />
<meta name="robots" content="all" />
<meta name="author" content="" />
<meta name="Copyright" content="" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="generator" content="" />
<title>QCMS PHPLite 官方标准模板</title>
<link rel="stylesheet" type="text/css" media="all" href="static/styles/main.css" />
<script type='text/javascript' charset='utf-8' src='static/scripts/jquery.js'></script>
<script>
$(document).ready(function(){
  count_toall();
}); 

function count_toall()
{
	var aa = 0;
	<?
	foreach($cart_arr as $jkey => $jval)
	{
		echo '$("#toall_'.$jkey.'").val($("#price_'.$jkey.'").html() * $("#num_'.$jkey.'").val());';
	}
	foreach($cart_arr as $jkey => $jval)
	{
		echo 'aa += parseInt($("#toall_'.$jkey.'").val());';
	}
	?>
	$("#toall").val(aa);
}
</script>
<link href="file:///F|/QCMS_SVN/PHP/qcms_php_1.5/static/styles/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="Header" class="Cauto">
  <div class="HrLogin">
    <ul>
      <li><a href="#" title="">中国语</a>|</li>
      <li><a href="#" title="">世界语</a></li>
    </ul>
    <div class="HrLnBm">
      <form method="post" action="">
        <input type="text" name="" class="HrLnBm01" />
        <input type="button" value="搜 索" onclick="" class="HrLnBm02" />
      </form>
    </div>
  </div>
  <h1></h1>
</div>
<div id="MainCt" class="Cauto">
  <div class="McLeft">
    <div class="McLf01">
      <form action="" method="post"><table width="100%" border="0">
        <tr>
          <td ><?=$this->p_lang['name']?></td>
          <td><?=$this->p_lang['name']?></td>
          <td><?=$this->p_lang['num']?></td>
          <td><?=$this->p_lang['price']?></td>
          <td><?=$this->p_lang['toall']?></td>
          <td><?=$this->p_lang['delete']?></td>
        </tr>
        <?
        foreach($cart_arr as $key => $val)
		{
			$field_arr = @unserialize($news_rs[$key]['nfield']);
			$price = empty($field_arr['price']) ? 0 : $field_arr['price'];
			echo '<tr><td><input name="nid['.$key.']" type="text" value="'.$key.'" readonly="readonly" style="width:25px" /></td><td>'.$news_rs[$key]['ntitle'].'</td><td><input id="num_'.$key.'" name="num['.$key.']" style="width:25px" type="text" value="1" onchange="count_toall()"/></td><td id="price_'.$key.'">'.$price.'</td><td><input id="toall_'.$key.'" name="toall['.$key.']" type="text" value="" readonly="readonly" style="width:25px" /></td><td><a href="">'.$this->p_lang['delete'].'</a></td></tr>';
		}
		?>
        <tr>
          <td colspan="5" align="center" ><?=$this->p_lang['toall']?>:<input name="toall" id="toall" type="text" value="0" /> </td>
          </tr>
        <tr>
          <td colspan="5" align="center" ><input name="" type="submit" value="<?=$this->p_lang['submit']?>" onclick="return confirm('<?=$this->p_lang['sure'].$this->p_lang['buy']?>?');" /> </td>
          </tr>
      </table></form>
    </div>
  </div>
</div>
<div id="Footer" class="Cauto">
  <p>&copy; 2008 - 2010 DEMO TEMPLATE BY WWW.Q-CMS.CN</p>
</div>
</body>
</html>
