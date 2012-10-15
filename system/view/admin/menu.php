<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$this->load_js(array('jquery', 'menu'));
$this->load_css('admin_menu');
?>
<script>
function qclick(n)
{
	for(i=1;i<=9;i++)
		{
			if(n !=i )
			{
				$("#q"+i).css("color","#000");
				$("#q"+i).css("backgroundImage","url('<?=IMG_PATH?>menu1.gif')");
				$("#u"+i).hide();
			}
			else
			{
				
				$("#q"+i).css("backgroundImage","url('<?=IMG_PATH?>menu2.gif')");
				$("#q"+i).css("color","#FFF");
				$("#u"+i).show("fast");
			}
		}
}
</script>
</head>
<body>
<div id="menu">
<h5 id="q1" onClick="qclick(1)" style="background:url(<?=IMG_PATH?>menu2.gif) repeat-x;padding-left:10px;" class="mu1">
<?=$this->p_lang['config']?>
</h5>
<ul id="u1" >
<li><a href="<?=url(array('admin', 'basic'))?>" target="mainFrame">
<?=$this->p_lang['basic'].$this->p_lang['config']?>
</a></li>
<li><a href="<?=url(array('admin', 'cache'))?>" target="mainFrame">
<?=$this->p_lang['update'].$this->p_lang['cache']?>
</a></li>
<li><a href="<?=url(array('admin', 'data'))?>" target="mainFrame">
<?=$this->p_lang['data'].$this->p_lang['manage']?>
</a></li>
<li><a href="http://www.q-cms.cn/help/" target="mainFrame" >
<?=$this->p_lang['user'].$this->p_lang['manual']?>
</a></li>
</ul>
<h5 id="q2" onClick="qclick(2)"  style="padding-left:10px;" class="mu2">
<?=$this->p_lang['user']?>
</h5>
<ul id="u2"  style="display:none">
<li><a href="<?=url(array('admin', 'user'))?>" target="mainFrame">
<?=$this->p_lang['user'].$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'user_add'))?>" target="mainFrame">
<?=$this->p_lang['user'].$this->p_lang['add']?>
</a></li>
<li><a href="<?=url(array('admin', 'order'))?>" target="mainFrame">
<?=$this->p_lang['order'].$this->p_lang['manage']?>
</a></li>
</ul>
<h5 id="q3" onClick="qclick(3)"  style="padding-left:10px;" class="mu2">
<?=$this->p_lang['class']?>
</h5>
<ul id="u3"  style="display:none">
<li><a href="<?=url(array('admin', 'cate'))?>" target="mainFrame">
<?=$this->p_lang['class'].$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'cate_add'))?>" target="mainFrame">
<?=$this->p_lang['class'].$this->p_lang['add']?>
</a></li>
</ul>
<h5 id="q4" onClick="qclick(4)"  style="padding-left:10px;" class="mu2">
<?=$this->p_lang['content']?>
</h5>
<ul id="u4" style="display:none">
<li><a href="<?=url(array('admin', 'news'))?>" target="mainFrame">
<?=$this->p_lang['content'].$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'news_add'))?>" target="mainFrame">
<?=$this->p_lang['content'].$this->p_lang['add']?>
</a></li>
</ul>
<h5 id="q5" onClick="qclick(5)"  style="padding-left:10px;" class="mu2">
<?=$this->p_lang['review']?>
</h5>
<ul id="u5" style="display:none">
<li><a href="<?=url(array('admin', 'guest'))?>" target="mainFrame">
<?=$this->p_lang['guest'].$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'guest', 1))?>" target="mainFrame">
<?=$this->p_lang['review'].$this->p_lang['manage']?>
</a></li>
</ul>
<h5 id="q6" onClick="qclick(6)"  style="padding-left:10px;" class="mu2">
<?=$this->p_lang['temp']?>
</h5>
<ul id="u6" style="display:none">
<li><a href="<?=url(array('admin', 'temp'))?>" target="mainFrame">
<?=$this->p_lang['temp'].$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'temp_add'))?>" target="mainFrame">
<?=$this->p_lang['temp'].$this->p_lang['add']?>
</a></li>
</ul>
<h5 id="q8" onClick="qclick(8)"  style="padding-left:10px;" class="mu2">
<?=$this->p_lang['model']?>
</h5>
<ul id="u8" style="display:none">
<li><a href="<?=url(array('admin', 'forms'))?>" target="mainFrame">
<?=$this->p_lang['model'].$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'forms_add'))?>" target="mainFrame">
<?=$this->p_lang['model'].$this->p_lang['add']?>
</a></li>
<li><a href="<?=url(array('admin', 'forms', 1))?>" target="mainFrame">
<?=$this->p_lang['forms'].$this->p_lang['manage']?></a></li>
<li><a href="<?=url(array('admin', 'forms_add', 1))?>" target="mainFrame">
<?=$this->p_lang['forms'].$this->p_lang['add']?>
</a></li>
</ul>
<h5 id="q7" onClick="qclick(7)"  style="padding-left:10px;" class="mu2">
<?=$this->p_lang['other']?>
</h5>
<ul id="u7" style="display:none">
<li><a href="<?=url(array('admin', 'ext'))?>" target="mainFrame">
<?=$this->p_lang['tag'].$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'ext_add'))?>" target="mainFrame">
<?=$this->p_lang['tag'].$this->p_lang['add']?>
</a></li>
<li><a href="<?=url(array('admin', 'ext', 1))?>" target="mainFrame">
<?=$this->p_lang['page'].$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'ext_add', 1))?>" target="mainFrame">
<?=$this->p_lang['page'].$this->p_lang['add']?>
</a></li>
<li><a href="<?=url(array('admin', 'ext', 2))?>" target="mainFrame">
<?=$this->p_lang['js'].$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'ext_add', 2))?>" target="mainFrame">
<?=$this->p_lang['js'].$this->p_lang['add']?>
</a></li>
<li><a href="<?=url(array('admin', 'ext', 3))?>" target="mainFrame">
<?='XML'.$this->p_lang['manage']?>
</a></li>
<li><a href="<?=url(array('admin', 'ext_add', 3))?>" target="mainFrame">
<?='XML'.$this->p_lang['add']?>
</a></li>
</ul>
<h5 id="q9" onClick="qclick(9)"  style="padding-left:10px;" class="mu2">
<?=$this->p_lang['plugins']?>
</h5>
<ul id="u9" style="display:none">
<?php 
echo '<li><a href="'.url(array('admin', 'plus')).'" target="mainFrame">'.$this->p_lang['plugins'].$this->p_lang['manage'].'</a></li>';
if(!empty($rs)){
	foreach($rs as $k => $v){
		echo '<li><a href="'.url(array('admin', 'callback', $v['mtitle'], 'index')).'" target="mainFrame">'.$v['mtitle'].'</a></li>';
	}
}
?>
<ul>

</ul>
</div>
</body>
</html>
