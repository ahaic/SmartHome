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
      <div class="MnRt06Ct05">
        <h2 class="InnTy01">财务管理</h2>
        <form action="<?=url('plus', 'index').'&p=tenpay'?>" method="post"><ul>
          <li><span>可用余额：<?=$money?>元</span></li>
          <li><span>充值余额：
            <input type="text" name="money" id="money" />
            元</span></li>
            <li>
              <input type="submit" name="button" id="button" value="提交" />
            </li>
        </ul></form>
      </div>
    </div>
  </div>
</div>
 <?
  $this->load_php('user/footer');
  ?>
</body>
</html>
