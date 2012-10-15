<html>
<head>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT">
if(top.location != self.location)
{
	top.location.replace(self.location)
}
</SCRIPT>
<title><?=$this->p_lang['manage']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
</head>
<frameset rows="65,*" framespacing="0" border="0" frameborder='0' frameborder="no">
<frame src="<?=url(array('admin', 'top'))?>" name="topFrame" scrolling="no" frameborder="0" border="no" />
<frameset cols="185,*" framespacing="0" border="0" frameborder="0" frameborder="no">
<frame src="<?=url(array('admin', 'menu'))?>" name="leftFrame" scrolling="no" frameborder="0" border="no" />
<frame src="<?=url(array('admin', 'main'))?>" name="mainFrame" scrolling="YES" />
</frameset>
</frameset>

<noframes>
<body>browser err !</body>
</noframes>
</html>