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
      <div class="MnRt06Ct04">
        <h2 class="InnTy01">业务管理</h2>
        <ul class="MnRt06Ct04ul01">
          <li class="MnRt06Ct04li01">编号</li>
          <li class="MnRt06Ct04li02">产品名称</li>
          <li class="MnRt06Ct04li03">订单号</li>
          <li class="MnRt06Ct04li04">金额</li>
          <li class="MnRt06Ct04li05">时间</li>
        </ul>
        <ul class="MnRt06Ct04ul02">
        <?
		if(!empty($rs)){
			foreach($rs as $key => $val)
			{
				echo '<li><span>'.$val['ono'].' / '.$val['omoney'].'元 / '.date('Y年m月d日', strtotime($val['otime'])).'</span>1 <a href="#" title="">'.$news_arr[$val['nid']]['ntitle'].'</a></li>';
			}
		}
        
		?>
        </ul>
        <div class="MnRt06Ct04Fy">
          <?=page_bar($count, $this->p_num, '', 9, 'p')?>
        </div>
      </div>
    </div>
  </div>
</div>
 <?
  $this->load_php('user/footer');
  ?>
</body>
</html>
