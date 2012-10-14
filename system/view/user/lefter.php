<div class="MnLeft">
    <ul>
      <li><a href="<?=url(array('user', 'index'))?>"><?=$this->p_lang['welcome']?>：<?=$_COOKIE['user']['username']?></a></li>
      <li><a href="<?=url(array('user', 'edit'))?>"><?=$this->p_lang['data'].$this->p_lang['manage']?></a></li>
      <li><a href="<?=url(array('user', 'password'))?>"><?=$this->p_lang['password'].$this->p_lang['manage']?></a></li>
	  <?
		$level = array(1,2);
		if(in_array($_COOKIE['user']['level'], $level))
		{		
	  ?>
	  <li><a href="<?=url(array('user', 'news'))?>"><?=$this->p_lang['content'].$this->p_lang['manage']?></a></li>
	  <li><a href="<?=url(array('user', 'news_add'))?>"><?=$this->p_lang['content'].$this->p_lang['add']?></a></li>
	  <?
	  }
	  ?>
      <li><a href="<?=url(array('user', 'order'))?>"><?=$this->p_lang['business'].$this->p_lang['manage']?></a></li>
      <!--<li><a href="<?=url(array('user', 'money'))?>"><?=$this->p_lang['finance'].$this->p_lang['manage']?></a></li>
      <li><a href="#">Discuz! X1.5 用户接口</a></li>
      <li><a href="#">PHPwind API 用户接口</a></li>
      <li><a href="#">新浪微博API用户接口</a></li>
      <li>QQ微博API用户接口</li>-->
      <li><a href="<?=url(array('home', 'logout'))?>"><?=$this->p_lang['logout']?></a></li>
    </ul>
  </div>