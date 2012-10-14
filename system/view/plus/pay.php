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
<title><?=$this->p_lang['user'].$this->p_lang['center']?></title>
<?
$this->load_css('main');
?>
</head>

<body>
<form id="form1" name="form1" method="post" action="index.php?c=plus&p=tenpay">
  <label for="money"></label>
  <input type="text" name="money" id="money" />
  <input type="submit" name="button" id="button" value="提交" />
</form>
</body>
</html>
