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
<div id="Mnav" class="Cauto">
  <ul>
  <?
  foreach($this->head_rs as $key => $val)
  {
	  if(!$val['clinkture'])
	  {
	  	$url = url(array('home', 'cate', $val['cid']));
	  }
	  else
	  {
		$url = $val['clink'];
		}
  	echo '<li><a href="'.$url.'" title="'.$val['cname'].'">'.$val['cname'].'</a>|</li>';
  }
  ?>
  </ul>
</div>
<div id="InnNav" class="Cauto">
  <p><?=$this->p_lang['location']?>：<a href="#" title=""><?=$this->p_lang['home']?></a>><a href="#" title=""><?=$this->p_lang['guest']?></a></p>
</div>