<html>
<head>
<link rel=stylesheet href="styles/advanced/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$this->load_js('jquery');
$this->load_css('admin_style');
?>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(<?=IMG_PATH?>bg3.gif);  background-repeat:repeat-x;  padding-left:   2px; padding-right:  2px; padding-bottom: 2px; margin-top:5px;  border:#dfdfdf solid 1px;">
  <tr>
    <td align="center"><p class="pagetitle">
       <?=$title?>
      </p></td>
  </tr>
</table>
<br />

<div id=divmain2>
  <table class=table border=0 cellspacing=0 width="100%">

      <tr bgcolor=#dae2e8>
        <td width="100%" height=36 bgcolor="#ffffff" style="BORDER-BOTTOM: #cccccc 1px solid; PADDING-BOTTOM: 10px; MARGIN: 0px; PADDING-LEFT: 10px; FONT-SIZE: 12px; BORDER-RIGHT: #cccccc 1px solid; PADDING-TOP: 10px">Hi
          ，<?=$_COOKIE['user']['username']?> （管理员）
         </td>
      </tr>

  </table>
  <br>
<iframe src="http://www.q-cms.cn/info.php?n=<?=base64_encode($_SERVER['HTTP_HOST'].$this->p_site['connect'])?>" width="100%" height="400px" frameborder="0" ></iframe>
</div>
<br />
<br />
<?
$this->load_php('admin/footer');
?>
</body>
</html>