<ul class="nav nav-list">
	<li class="nav-header"><?=$this->p_lang['system'].$this->p_lang['settings']?></li>
	<li <?=(Router::$s_method == 'basic') ? 'class="active"' : ''?>><a href="<?=url(array('admin', 'basic'))?>"><i class="<?=($menu == 1) ? 'icon-white' : ''?> icon-asterisk"></i><?=$this->p_lang['basic'].$this->p_lang['settings']?></a></li>
	<?
	if(!IS_SINA_APP){
	?>
	<li <?=((Router::$s_method == 'data')) ? 'class="active"' : ''?>><a href="<?=url(array('admin', 'data'))?>"><i class="<?=($menu == 2) ? 'icon-white' : ''?> icon-book"></i><?=$this->p_lang['data'].$this->p_lang['center']?></a></li>
	<?
	}
	?>
	
	<li><a href="<?=url(array('admin', 'help'))?>"><i class="icon-flag"></i><?=$this->p_lang['help'].$this->p_lang['center']?></a></li>
	<li class="divider"></li>
	<li class="nav-header"><?=$this->p_lang['basic'].$this->p_lang['center']?></li>
	<li <?=(Router::$s_method == 'user') ? 'class="active"' : ''?>><a href="<?=url(array('admin', 'user'))?>"><i class="<?=($menu == 3) ? 'icon-white' : ''?> icon-user"></i><?=$this->p_lang['user'].$this->p_lang['manage']?></a></li>
	<li <?=(Router::$s_method == 'cate') ? 'class="active"' : ''?>><a href="<?=url(array('admin', 'cate'))?>"><i class="icon-align-justify"></i><?=$this->p_lang['classify'].$this->p_lang['manage']?></a></li>
	<li <?=(Router::$s_method == 'news') ? 'class="active"' : ''?>><a href="<?=url(array('admin', 'news'))?>"><i class="icon-list"></i><?=$this->p_lang['content'].$this->p_lang['manage']?></a></li>
	<li <?=(Router::$s_method == 'guest') ? 'class="active"' : ''?>><a href="<?=url(array('admin', 'guest'))?>"><i class="icon-comment"></i><?=$this->p_lang['message'].$this->p_lang['manage']?></a></li>
	<li class="divider"></li>
	<li class="nav-header"><?=$this->p_lang['other'].$this->p_lang['manage']?></li>
	<li><a href="<?=url(array('admin', 'forms'))?>"><i class="icon-th-large"></i><?=$this->p_lang['model'].$this->p_lang['manage']?></a></li>
	<li <?=(Router::$s_method == 'temp') ? 'class="active"' : ''?>><a href="<?=url(array('admin', 'temp'))?>"><i class="icon-file"></i><?=$this->p_lang['template'].$this->p_lang['manage']?></a></li>
	<li><a href="<?=url(array('admin', 'forms', '1'))?>"><i class="icon-leaf"></i><?=$this->p_lang['form'].$this->p_lang['manage']?></a></li>
	<li <?=(Router::$s_method == 'ext') ? 'class="active"' : ''?>><a href="<?=url(array('admin', 'ext'))?>"><i class="icon-share-alt"></i><?=$this->p_lang['calls'].$this->p_lang['manage']?></a></li>
	<li class="divider"></li>
	<li class="nav-header"><?=$this->p_lang['plugin'].$this->p_lang['center']?></li>
    <li <?=(Router::$s_method == 'plus') ? 'class="active"' : ''?>><a href="<?=url(array('admin', 'plus'))?>"><i class="icon-fire"></i><?=$this->p_lang['plugin'].$this->p_lang['manage']?></a></li>
    <?
    foreach($this->plusArr as $k => $v){
		if($v == 1){
			echo '<li><a href="'.url(array('admin', 'callback', $k)).'"><i class="icon-inbox"></i>'.$k.$this->p_lang['manage'].'</a></li>';
		}		
	}
	?>
</ul>