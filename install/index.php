<?php 
define('IMG_PATH', '../static/images/');
define('JS_PATH', '../static/scripts/');
if(file_exists('../lock.txt'))
{
	echo 'Install locked !';
	return ;
}

if(!empty($_POST))
{
	$sysInfo = unserialize(@file_get_contents('../qlib/config.qcms'));
	$sysInfo['connect'] = md5(uniqid(rand(100,999)));
	file_put_contents('../qlib/config.qcms', serialize($sysInfo));
	$config = '';
	if($_POST['db_driver'] == 'Mysql')
	{
		$link = @mysql_connect($_POST['mysql_host'], $_POST['mysql_username'], $_POST['mysql_password']);
		if (!$link) {
			echo '<script>alert("数据库连接失败");window.location.href="index.php";</script>';exit();
		}
		mysql_close($link);
		$config .= "<?php return array('qcms' => array(
		'db_driver' => 'Mysql',	
		'host' => '".$_POST['mysql_host']."', 
		'username' => '".$_POST['mysql_username']."', 
		'password' => '".$_POST['mysql_password']."', 
		'db_name' => '".$_POST['mysql_db_name']."', 				
		'db_port' => '3306', 
		'db_prefix' => '".$_POST['mysql_db_prefix']."', 
		'charset' => 'utf8')
		);?>";
		$access = @file_put_contents('../qlib/site/config.php', $config);
		if(!$access){
			echo '<script>alert("程序没有权限，你修改权限后再安装！");window.location.href="index.php";</script>';exit();
		}
		echo '<script>window.location.href="../index.php?q=home/data_bakin";</script>';exit();
	}
	else 
	{
		$result = rename('../qlib/qcms.db3', '../qlib/'.$_POST['sqlite_db_name'].'.db3');
		if($result)
		{
			$db_name = $_POST['sqlite_db_name'];
		}
		else
		{
			$db_name = 'qcms';
		}
		$config .= "<?php return array('qcms' => array(
		'db_driver' => 'DB_Pdo',	
		'db_name' => '".$db_name."', 				
		'db_prefix' => 'qcms_')
		);?>";	
		file_put_contents('../qlib/site/config.php', $config);
		file_put_contents('../lock.txt', '');		
		echo '<script>alert("安装成功");window.location.href="../index.php";</script>';exit();	
	}
	
	return;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
      QCMS PHPLite 安装程序
    </title>
    <style type="text/css">
 body {
	background-color: #f9f9f9;
}
.phplite1, .phplite2, .phplite3, .phplite4, .phplite5, .phplite6, .phplite7 {
	width: 765px;
	height: auto;
	overflow: hidden;
	margin: auto;
	color: #333;
	font-family: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
	margin: 2em auto;
	width: 700px;
	padding: 1em 2em;
	-moz-border-radius: 11px;
	-khtml-border-radius: 11px;
	-webkit-border-radius: 11px;
	border-radius: 11px;
	border: 1px solid #dfdfdf;
	background-color: #FFF;
}	
.phplite2, .phplite3, .phplite4, .phplite5, .phplite6, .phplite7 {
display: none;
}
html {
	background: #f9f9f9;
}
a {
	color: #2583ad;
	text-decoration: none;
}
a: hover {
	color: #d54e21;
}
h1 {
	border-bottom: 1px solid #dadada;
	clear: both;
	color: #666;
	font: 24px Georgia, "Times New Roman", Times, serif;
	margin: 5px 0 0 -4px;
	padding: 0;
	padding-bottom: 7px;
}
h2 {
	text-align: center;
	margin-bottom: 40px;
}
p, li, dd, dt {
	padding-bottom: 2px;
	font-size: 12px;
	line-height: 18px;
}
textarea {
	font-weight: normal;
	border: #CCC solid 1px;
}
    </style>
    <script type="text/javascript" src="<?=JS_PATH?>jquery.js" ></script>
<script>
function allowed()
{
	if($("#allow").attr("checked") == true) 
	{
		$(".sp").attr("disabled", false);
	} else {
		$(".sp").attr("disabled", true);
	}
} 
$(document).ready(function() {
	$("#allow").click(function(){allowed()});		
	$("#setup").bind("click", function(){
	$(".phplite1").slideUp("10000", function(){
	$(".phplite2").slideDown("10000");});});	
	$("#back1").bind("click", function(){
	$(".phplite2").slideUp("10000", function(){
	$(".phplite1").slideDown("10000");});});	
	$("#back2").bind("click", function(){
	$(".phplite3").slideUp("10000", function(){
	$(".phplite2").slideDown("10000");});});	
	$("#back3").bind("click", function(){
	$(".phplite4").slideUp("10000", function(){
	$(".phplite2").slideDown("10000");});});	
	$("#next1").bind("click", function(){
		if($("input:[name=db_driver]:radio:checked").val() == "Mysql")
		{
			$(".phplite2").slideUp("10000", function(){
			$(".phplite4").slideDown("10000");});
		}
		else
		{
			$(".phplite2").slideUp("10000", function(){
			$(".phplite3").slideDown("10000");});
		}
	});
});

 
</script>
  </head>
  
  <body>
    <div class="phplite1">
      <h2>
        <img src="<?=IMG_PATH?>logo.gif" />
      </h2>
      <h1>
        欢迎你使用PHPLite
      </h1>
      <p>
        激动人心的时刻，欢迎使用QCMS PHPLite 内容管理系统！让我们完成简单的数据安装吧：）
      </p>
      <h1>&nbsp;
        
      </h1>
      <p>
        仔细阅读以下安装协议
      </p>
      <table width="100%">
        <tbody>
          <tr>
            <th colspan="2" align="left" scope="row">
              <p>
                <textarea name="" cols="85" rows="10">
                
感谢您选择QCMS PHPLite MVC CMS建站管理系统（以下简称PHPLite）.

PHPLite管理系统大中小任意型门户网站建设解决方案之一，居于 PHP5的技术开发，全部源码开放。

PHPLite的官方网址是： www.Q-CMS.cn 为了使你正确并合法的使用本软件，请你在使用前务必阅读清楚下面的协议条款： 

一、本授权协议适用且仅适用于PHPLite，PHP 1.3及 ASP2.0版本，PHPLite官方对本授权协议的最终解释权。 

二、协议许可的权利：
   1、您可以在完全遵守本最终用户授权协议的基础上，并购买本软件，不限制任何商业版权限制。 
   2、您可以在协议规定的约束和限制范围内修改PHPLite 源代码或界面风格以适应您的网站要求。 
   3、您拥有使用本软件构建的网站全部内容所有权，并独立承担与这些内容的相关法律义务。 
   4、获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。

三、协议规定的约束和限制： 
   1、未获商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目的或实现盈利的网站）。购买商业授权请登陆www.Q-CMS.cn了解最新说明。 
   2、未经官方许可，不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。 
   3、不管你的网站是否整体使用PHPLite，还是部份栏目使用 PHPLite，在你使用了 PHPLite 的网站主页上必须加上 PHPLite版权信息,官方网址(www.PHPLite.com)的链接。商业版可去掉连接。
   4、未经官方许可，禁止在 PHPLite 的整体或任何部分基础上以发展任何派生版本、修改版本2次开发或第三方版本用于重新分发。 
   5、如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。

四、有限担保和免责声明： 
   1、本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。 
   2、用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺对免费用户提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关 
   3、电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始确认本协议并安装 PHPLite，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
   4、如果本软件带有其它软件的整合API示范例子包，这些文件版权不属于本软件官方，并且这些文件是没经过授权发布的，请参考相关软件的使用许可合法的使用。

协议发布时间： 2011年3月。
                </textarea>
              </p>
            </th>
          </tr>
          <tr>
            <td colspan="2">
              <input name="alow" type="checkbox" id="allow" value="1" style="margin-top:18px;">
              同意协议
            </td>
          </tr>
        </tbody>
      </table>
      <h1>
      </h1>
      <p>
        <input type="button" name="button" id="setup" value="开始安装PHPLite" disabled="true"
        class="sp">
      </p>
    </div>
    <form action="" method="post" target="_self" id="setup">
      <div class="phplite2">
        <h2>
          <img src="<?=IMG_PATH?>logo.gif" />
        </h2>
        <h1>
          选择你需要的数据库
        </h1>
        <p>
          建议初学者选择SQLite
        </p>
        <table width="100%">
          <tbody>
            <tr>
              <th width="13%" height="30" align="left" scope="row">
                <p>
                  数据类型
                </p>
              </th>
              <td width="87%" height="30">
                <label>
                  <input type="radio" name="db_driver" value="Sqlite" />
                  初学者用 SQLite 数据库
                </label>
                <br />
                <label>
                  <input name="db_driver" type="radio" checked="checked"  value="Mysql"/>
                  专业用户 MYSQL 数据库
                </label>
                <br />
              </td>
            </tr>
          </tbody>
        </table>
        <h1>
        </h1>
        <p>
          <input value="返回" type="button" name="" id="back1" >
          <input value="进行下一步" type="button" name="" id="next1">
        </p>
      </div>
      <div class="phplite3">
        <h2>
          <img src="<?=IMG_PATH?>logo.gif" />
        </h2>
        <h1>
          初学者使用SQLite数据
        </h1>
        <p>
          只要你的PHP空间支持SQLite数据库即可。
        </p>
        <table width="100%">
          <tbody>
            <tr>
              <th height="14" align="left" scope="row">
                <p>
                  数据名称
                </p>
              </th>
              <td width="86%" height="-2">
                <input id="""2" size="25" type="text" name="sqlite_db_name" value="qcms" />
              </td>
            </tr>            
            <tr>
              <th height="14" align="left" scope="row">
                <p>
                  数据前惙
                </p>
              </th>
              <td width="86%" height="-1">
                <input name="" type="text" id="" value="qcms" size="25" readonly="readonly" style="background-color:#DFDFDF"/>
              </td>
            </tr>
          </tbody>
        </table>
        <h1>
        </h1>
        <p>
          <input value="返回" type="button" name="" id="back2">
          <input value="安装" type="submit" name="" id="setup2">
        </p>
      </div>
      <div class="phplite4">
        <h2>
          <img src="<?=IMG_PATH?>logo.gif" />
        </h2>
        <h1>
          专业用户MYSQL数据安装
        </h1>
        <p>
          只要你的PHP空间支持Mysql数据库即可。
        </p>
        <table width="100%">
          <tbody>
            <tr>
              <th width="14%" height="14" align="left" scope="row">
                <p>
                  数据路径
                </p>
              </th>
              <td width="86%" height="-4">
                <input id="9" size="25" type="text" name="mysql_host" value="127.0.0.1" />
              </td>
            </tr>
            <tr>
              <th height="14" align="left" scope="row">
                <p>
                  数据名称
                </p>
              </th>
              <td width="86%" height="-2">
                <input id="10" size="25" type="text" name="mysql_db_name" />
              </td>
            </tr>
            <tr>
              <th height="14" align="left" scope="row">
                <p>
                  数据帐号
                </p>
              </th>
              <td width="86%" height="-2">
                <input id="10" size="25" type="text" name="mysql_username" />
              </td>
            </tr>
            <tr>
              <th height="14" align="left" scope="row">
                <p>
                  数据密码
                </p>
              </th>
              <td width="86%" height="-3">
                <input id="11" size="25" type="text" name="mysql_password" />
              </td>
            </tr>
            <tr>
              <th height="14" align="left" scope="row">
                <p>
                  数据前惙
                </p>
              </th>
              <td width="86%" height="-1">
                <input id="13" size="25" type="text" name="mysql_db_prefix" value="qcms_" />
              </td>
            </tr>
          </tbody>
        </table>
        <h1>
        </h1>
        <p>
          <input value="返回" type="button" name="" id="back3">
          <input value="安装" type="submit" name="Submit2" id="setup3">
        </p>
      </div>
      
      
      
    </form>
  </body>

</html>