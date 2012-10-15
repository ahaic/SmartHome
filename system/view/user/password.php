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
<?
$this->load_php('user/header');
?>
<div id="MInn" class="Cauto">
  <?
  $this->load_php('user/lefter');
  ?>
  <div class="MnRight">
    <div class="MnRt06">
    <form action="" method="post" id="form1">
      <div class="MnRt06Ct01">
        <h2 class="InnTy01"><?=$this->p_lang['user'].$this->p_lang['data']?></h2>
        <ul>
          <li>
           <?=$this->p_lang['password']?>1：
            <input name="password" type="text" value="" /></li>
          <li>
            <?=$this->p_lang['password']?>2：
            <input name="password2" type="text" value="" /></li>
            <li><input name="" type="submit" value="<?=$this->p_lang['submit']?>" /></li>
        </ul>
      </div></form>
    </div>
  </div>
</div>
 <?
  $this->load_php('user/footer');
  ?>
</body>
</html>
