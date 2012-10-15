<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends Base
{
	private $_user_obj;
	function __construct(){
		$this->load_config();
	}
	public function index()
	{
		if($this->p_site['cache_time'] > 0)
		{
			$cache = new Cache();
			$cache->cached_time = $this->p_site['cache_time'] * 60;
			$cache->start();
			$this->load_view('home/'.$this->p_site['tempdir'].'/index');
			$cache->end();
			return;
		}
		$this->load_view('home/'.$this->p_site['tempdir'].'/index');
		return;
	}
	
	public function ext($eid)
	{
		if(empty($eid))
		{
			echo 'ID get failed';
			return;
		}
		$ext_obj = $this->load_model('Q_Tag');
		$result = $ext_obj->select(array('eid' => $eid));		
		switch ($result[0]['etype'])
		{
			case 1:		
				$this->p_eid = $eid;
				$this->load_view('home/'.$this->p_site['tempdir'].'/diy', 'diy');
				break;
			case 2:
				echo 'document.write("'.$this->html_2_js($this->_temp->index($result[0]['einfo'], 1)).'");';
				break;
			case 3:
				$this->_temp = new Temp();
				header("Content-Type: text/xml;");
				$this->_temp->index($result[0]['einfo']);				
				break;
			default:
				echo 'Err!';
				break;				
		}
		return;
	}
	
	public function app($table_id = 0, $row = 10, $cid = 0, $gtype = 0, $nid = 0)
	{
		$limit = array(0, $row);
		$cond_arr = array();
		if(!empty($cid))
		{
			$cond_arr = array('cid' => $cid);
		}
		$cond_arr = array('gtype' => $gtype);
		if(!empty($nid))
		{
			$cond_arr = array('nid' => $nid);
		}		
		switch($table_id)
		{
			case 1:
				$app_obj = $this->load_model('Q_News');
				break;
			case 2:
				$app_obj = $this->load_model('Q_Guest');
				break;
			default:
				$app_obj = $this->load_model('Q_News');
				break;
		}
		$count  = 0;
		$offset = empty($_GET['p']) ? 0 : ($_GET['p']-1) * $row;
		$result = $app_obj->select_all($cond_arr, array($offset, $row), '*', $count);
		$str = array();
		if($table_id == 2){		
			foreach($result as $k => $v){				
				$str[$k]['gid'] = $v['gid'];
				$str[$k]['gtitle'] = $v['gtitle'];
				$str[$k]['ginfo'] = $v['ginfo'];
				$str[$k]['gtime'] = $v['gtime'];
				$str[$k]['uid'] = $v['uid'];
				$str[$k]['gtype'] = $v['gtype'];
				$str[$k]['nid'] = $v['nid'];
				$str[$k]['avatar'] = md5($v['gtitle']);
			}
		}
		$result = empty($str) ? $result : $str;		
		$toall = ceil($count[0]['count']/$row);
		echo json_encode(array('toall' => $toall, 'data' => $result));
		return;
	}
	
	public function guest($id = 0)
	{
		session_start();
		if(!empty($_POST))
		{
			if(!empty($this->p_site['veri'])){
				if(empty($_POST['veri']) || $_POST['veri'] != $_SESSION['authnum']){
					exec_script('alert("验证码错误，请重新留言");history.back();');return ;
				}
			}
			$tag_obj = $this->load_model('Q_Guest');
			$gtime  = empty($_POST['gtime']) ? date('Y-m-d H:i:s') : $_POST['gtime'];
			$uid = empty($_COOKIE['user']['uid'])? 0 : $_COOKIE['user']['uid'];
			$gtype = empty($_POST['gtype']) ? 0 : 1;
			if($gtype == 1)
			{
				$nid = empty($_POST['id']) ? $id : $_POST['id'];
			}
			else
			{
				$nid = 0;
			}
			$insert_arr = array('gtitle' => $_POST['title'], 'ginfo' => $_POST['ginfo'],			
			 'gtime' => $gtime, 'uid' => $uid, 'gtype' => $gtype,
			 'nid' => $nid);
			$result = $tag_obj->insert($insert_arr);
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['content'].' save err !");history.back();');return ;
			}
			else
			{
				if($gtype == 0)
				{
					exec_script('alert("'.$this->p_lang['guest'].' save OK !");history.back();');return ;
				}
				else
				{
					exec_script('window.location.href = "'.url(array('home', 'view', $nid)).'";');
				}
				
			}
		}
	}
	
	public function cate($cid = 0)
	{
		if(empty($cid))
		{
			exec_script('alert("cid lost !");history.back();');return ;
		}
		$cate_obj = $this->load_model('Q_Cate');
		$this->p_cid = $cid;
		if($this->p_site['cache_time'] > 0)
		{
			$cache = new Cache();
			$cache->cached_time = $this->p_site['cache_time'] * 60;
			$cache->start();
			$rs_temp = $cate_obj->select(array('cid' => $cid), '', 'ctemp');		
			$this->load_view('home/'.$this->p_site['tempdir'].'/'.$rs_temp[0]['ctemp'], 'cate');
			$cache->end();
			return;
		}
		$rs_temp = $cate_obj->select(array('cid' => $cid), '', 'ctemp');		
		$this->load_view('home/'.$this->p_site['tempdir'].'/'.$rs_temp[0]['ctemp'], 'cate');
		return;
	}
	
	public function view($id = 0)
	{
		if(empty($id))
		{
			exec_script('alert("id lost !");history.back();');return ;
		}		
		$this->p_nid = $id;
		$news_obj = $this->load_model('Q_News');
		$cate_obj = $this->load_model('Q_Cate');
		if($this->p_site['cache_time'] > 0)
		{
			$cache = new Cache();
			$cache->cached_time = $this->p_site['cache_time'] * 60;
			$cache->start();
			$rs = $news_obj->select(array('nid' => $id), '', 'cid');
			$rs_temp = $cate_obj->select(array('cid' => $rs[0]['cid']), '', 'ntemp');
			$this->load_view('home/'.$this->p_site['tempdir'].'/'.$rs_temp[0]['ntemp'], 'view');
			$cache->end();
			return;
		}		
		$rs = $news_obj->select(array('nid' => $id), '', 'cid');
		$rs_temp = $cate_obj->select(array('cid' => $rs[0]['cid']), '', 'ntemp');
		$this->load_view('home/'.$this->p_site['tempdir'].'/'.$rs_temp[0]['ntemp'], 'view');
	}	
	
	public function count($id = 0)
	{
		if(empty($id))
		{
			exec_script('alert("id lost !");history.back();');return ;
		}
		$news_obj = $this->load_model('Q_News');
		$rs = $news_obj->select(array('nid' => $id), '', 'count');
		$news_obj->update('count = count +1', array('nid' => $id));
		echo 'document.writeln("'.$rs[0]['count'].'")';
		return;
	}	
	
	public function down($id = 0)
	{
		if(empty($id))
		{
			exec_script('alert("id lost !");history.back();');return ;
		}
		$news_obj = $this->load_model('Q_News');
		$rs = $news_obj->select(array('nid' => $id));
		$field_arr = unserialize($rs[0]['nfield']);
		$qcms['down'] = $field_arr['down'];
		$this->load_php('plus/down', $qcms);
	}
	
	public function js($id = 0)
	{
		if(empty($id))
		{
			exec_script('alert("id lost !");history.back();');return ;
		}
	}
	
	public function form($id){
		$form_obj = $this->load_model('Q_Form');
		$rs = $form_obj->select(array('id' => $id));
		if(!empty($rs[0]['login']) && empty($_COOKIE['user']['uid'])){
			exec_script('alert("请登录后留言！");history.back();');return ;
		}
		$result = $form_obj->insert(array('form_id' => $id, 'field' => @serialize($_POST['nfield'])), 1);
		if(!$result)
		{
			exec_script('alert("'.$this->p_lang['submit'].' save err !");history.back();');return ;
		}
		else
		{
			exec_script('alert("'.$this->p_lang['submit'].' save OK !");window.location.href = "'.url(array('home', 'index')).'";');
		}
	}
	
	public function reg()
	{		
		if(!empty($_POST))
		{
			if(empty($_POST['username']) || empty($_POST['password']))
			{
				exec_script('alert("'.$this->p_lang['save'].$this->p_lang['err'].'!");history.back();');return ;
			}
			$this->_user_obj = $this->load_model('Q_User');
			$rs = $this->_user_obj->select(array('username' => $_POST['username']));
			if(!empty($rs))
			{
				exec_script('alert("'.$this->p_lang['save'].$this->p_lang['err'].'!");history.back();');return ;
				return;
			}
			$insert = array('username' => $_POST['username'], 'password' => md5($_POST['password']), 'sex' => $_POST['sex'], 
			'email' => $_POST['email'], 'qq' => $_POST['qq'], 'tel' => $_POST['tel'], 'address' => $_POST['address'], 
			'add_time' => date('Y-m-d H:i:s'));
			$result = $this->_user_obj->insert($insert);
			if(!$result)
			{
				exec_script('alert("'.$this->p_lang['save'].$this->p_lang['err'].'!");history.back();');return ;
			}
			else
			{
				exec_script('window.location.href = "'.url(array('home', 'login')).'";');return;
			}
		}
		$this->load_view('home/'.$this->p_site['tempdir'].'/reg');
		return;
	}
	
	public function search()
	{
		$this->load_view('home/'.$this->p_site['tempdir'].'/search', 'search');
		return;
	}
	
	public function login()
	{
		if(!empty($_POST))
		{
			$user_obj = self::load_model('Q_User');	
			if(empty($_POST['username']) || empty($_POST['password']))
			{
				exec_script('alert("parameter err !");history.back();');return ;
			}
			$result = $user_obj->select(array('username' => $_POST['username'], 'password' => md5($_POST['password'])));
			if($result)
			{
				$this->p_login($result);
				exec_script('window.location.href="'.url(array('user', 'index')).'"');return;
			}
			else
			{
				$this->p_logout();
				exec_script('alert("Login err !");history.back();');return ;
			}
		}
		$this->load_view('home/'.$this->p_site['tempdir'].'/login');
	}
	
	public function login_ajax(){
		if(!empty($_POST))
		{
			$user_obj = self::load_model('Q_User');	
			if(empty($_POST['username']) || empty($_POST['password']))
			{
				echo 0;return ;
			}
			$result = $user_obj->select(array('username' => $_POST['username'], 'password' => md5($_POST['password'])));
			if($result)
			{
				$this->p_login($result);
				echo $_POST['username'];return;
			}
			else
			{
				$this->p_logout();
				echo -1;return ;
			}
		}
	}
	
	public function cookie_ajax(){
		if(empty($_COOKIE['user'])){
			echo 0;
		}else{
			echo $_COOKIE['user']['username'];
		}
	}
	
	public function admin_login()
	{
		$user_obj = self::load_model('Q_User');	
		if(!empty($_POST))
		{
			if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['code']))
			{
				exec_script('alert("parameter err !");history.back();');return ;
			}
			if($_POST['code'] != $this->p_site['code'])
			{
				exec_script('alert("code err !");history.back();');return ;
			}
			$result = $user_obj->select(array('username' => $_POST['username'], 'password' => md5($_POST['password']), 'level' => array(1,2)));
			if($result)
			{
				$this->p_login($result);
				exec_script('window.location.href="'.url(array('admin', 'index')).'"');return;
			}
			else
			{
				$this->p_logout();
				exec_script('alert("Login err !");history.back();');return ;
			}
		}
		$this->load_view('home/'.$this->p_site['tempdir'].'/admin_login');
	}

	public function err(){
		$this->load_view('home/'.$this->p_site['tempdir'].'/err');
	}
	
	public function data_bakin()
	{
		set_time_limit(0);
		$admin_obj = $this->load_model('Q_Cate');
		if(file_exists('lock.txt'))
		{
			echo 'Install locked !';
			return ;
		}
		$result = $admin_obj->sql_bakin('qcms_database');
		if(!$result)
		{
			exec_script('alert("err !");window.location.href = "'.url(array('home', 'index')).'";');
		}
		else
		{
			file_put_contents('lock.txt', '');
			exec_script('alert("ok !");window.location.href = "'.url(array('home', 'index')).'";');			
			return;
		}
		
	}
	
	public function callback($name, $method = 'index', $action = ''){
		parent::p_callback($name, $method, $action);
	}
	
	public function logout()
	{
		$this->p_logout();
		exec_script('window.location.href="'.SITEPATH.'"');return;
	}

	public function php()
	{		
		phpinfo();
	}
	
	public function flush(){
		$cache = new cache();
		$cache->flush();
	}	
	
	public function veri()
	{
		@header("Content-Type:image/png");   
		session_start();  
		$authnum = ''; 
		$_SESSION['authnum'] = '';   		  
		$str = "0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,m,n,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,M,N,P,Q,R,S,T,U,V,W,X,Y,Z";    
		$list = explode(",", $str);   
		for($i=0; $i<4; $i++){   
		    $randnum = rand(0, 57);   
		    $authnum .= $list[$randnum]; 
		}   
		$_SESSION['authnum'] = strtolower($authnum);   
		$im = imagecreate(80,25);
  		$white = imagecolorallocate($im, 255,255,255);
  		$black = imagecolorallocate($im, 0x00, 0x99, 0x33);	
  		imagestring($im, 5, 25, 8, $authnum, $black);   		
		imagepng($im);   
		imagedestroy($im);  						
	}
	
	public function err404(){
		$url = $_SERVER['REQUEST_URI'];
		$ext = substr($url, -4);
		$url_arr = explode('_', substr($url, 1, -4));
		if(empty($url_arr))
		{
			header("HTTP/1.0 404 Not Found");
			header("Location: ".url(array('home', 'err'))."");
			return;
		}
		$filename = $url_arr[0].$ext;
		if(!is_file($filename))
		{
			header("HTTP/1.0 404 Not Found");
			header("Location: ".url(array('home', 'err'))."");
			return;
		}
		$width = substr($url_arr[1], 1);
		$height = substr($url_arr[2], 1);
		$thumb = $url_arr[0].'_w'.$width.'_h'.$height.''.$ext;
		if($width == 0 && $height == 0)
		{
			@header("Content-Type:image/jpeg");
			list($width_orig, $height_orig) = getimagesize($filename);
			if($width_orig >= 400)
			{
				$im = @imagecreatefromjpeg ($filename); 
				imagejpeg($im, null, 80);	
				imagejpeg($im, $thumb, 80);
				setWater($thumb, 'static/images/watermark.png', 'Qesy', '', 9, '', $markType = 'img');
			}
			else
			{
				$im = @imagecreatefromjpeg ($filename); 
				imagejpeg($im, null, 80);	
				imagejpeg($im, $thumb, 80);
			}
			return;
		}
		$img_width = $width;//生成图片的宽
		$imt_height = $height;//生成图片的高
		$size_arr = array('80|60','100|75','120|90','130|98','150|113','160|120','200|150','240|180','300|225','450|338','500|375');
		$size = $width.'|'.$height;//获取缩略图的长和宽
		if(!in_array($size, $size_arr))
		{
			//require 'system/view/home/404.php';
			header("HTTP/1.0 404 Not Found");
			header("Location: ".url(array('home', 'err'))."");
			return;
		}
		@header("Content-Type:image/jpeg");
		   
		list($width_orig, $height_orig) = getimagesize($filename);//获取原图的长和宽
		
		$scale_org =$width_orig / $height_orig;
		 if ($width_orig / $width > $height_orig / $height){
		   $lessen_width  = $height * $scale_org;
			$lessen_height = $height;
		}else{
			$lessen_width  = $width;
			$lessen_height  = $width / $scale_org;
		}
		$dst_x = ($width  - $lessen_width)  / 2;
		$dst_y = ($height - $lessen_height) / 2;
		/*
		echo "原图比例".$scale_org."<hr>";
		echo '原图宽'.$width_orig."---原图高".$height_orig."<hr>";
		echo '小图的宽'.$width."---高".$height.'<hr>';
		echo '原图缩小后用的宽'.$lessen_width."---高".$lessen_height.'<hr>';
		*/
		
		$image_p = imagecreatetruecolor($width, $height);//生成一副缩略图
		if($ext == '.jpg'){
			$image = imagecreatefromjpeg($filename);//获取原图
		}elseif($ext == '.png'){
			$image = imagecreatefrompng($filename);//获取原图
		}elseif($ext == '.bmp'){
			$image = imagecreatefromwbmp($filename);//获取原图
		}elseif($ext == '.gif'){
			$image = imagecreatefromgif($filename);//获取原图
		}
		
		imagecopyresampled($image_p, $image, 0,0, 0, 0, $lessen_width, $lessen_height, $width_orig, $height_orig);
		//按比列缩小（缩略图，原图，上标配,下标配,左标配,右标配, ）
		
		imagejpeg($image_p, null, 80);//生成小图
		imagejpeg($image_p, $thumb, 80);//保存小图
		
		function setWater($imgSrc = '', $markImg = '',$markText = '', $TextColor = '', $markPos = '', $fontType = '', $markType = 'img')
		{
		
		    $srcInfo = @getimagesize($imgSrc);
		    $srcImg_w    = $srcInfo[0];
		    $srcImg_h    = $srcInfo[1];
		        
		    switch ($srcInfo[2]) 
		    { 
		        case 1: 
		            $srcim =imagecreatefromgif($imgSrc); 
		            break; 
		        case 2: 
		            $srcim =imagecreatefromjpeg($imgSrc); 
		            break; 
		        case 3: 
		            $srcim =imagecreatefrompng($imgSrc); 
		            break; 
		        default: 
		            die("不支持的图片文件类型"); 
		            exit; 
		    }
		        
		    if(!strcmp($markType,"img"))
		    {
		        if(!file_exists($markImg) || empty($markImg))
		        {
		            return;
		        }
		            
		        $markImgInfo = @getimagesize($markImg);
		        $markImg_w    = $markImgInfo[0];
		        $markImg_h    = $markImgInfo[1];
		            
		        if($srcImg_w < $markImg_w || $srcImg_h < $markImg_h)
		        {
		            return;
		        }
		            
		        switch ($markImgInfo[2]) 
		        { 
		            case 1: 
		                $markim =imagecreatefromgif($markImg); 
		                break; 
		            case 2: 
		                $markim =imagecreatefromjpeg($markImg); 
		                break; 
		            case 3: 
		                $markim =imagecreatefrompng($markImg); 
		                break; 
		            default: 
		                die("不支持的水印图片文件类型"); 
		                exit; 
		        }
		            
		        $logow = $markImg_w;
		        $logoh = $markImg_h;
		    }
		        
		    if(!strcmp($markType,"text"))
		    {
		        $fontSize = 16;
		        if(!empty($markText))
		        {
		            if(!file_exists($fontType))
		            {
		                return;
		            }
		        }
		        else {
		            return;
		        }
		            
		        $box = @imagettfbbox($fontSize, 0, $fontType,$markText);
		        $logow = max($box[2], $box[4]) - min($box[0], $box[6]);
		        $logoh = max($box[1], $box[3]) - min($box[5], $box[7]);
		    }
		        
		    if($markPos == 0)
		    {
		        $markPos = rand(1, 9);
		    }
		        
		    switch($markPos)
		    {
		        case 1:
		            $x = +5;
		            $y = +5;
		            break;
		        case 2:
		            $x = ($srcImg_w - $logow) / 2;
		            $y = +5;
		            break;
		        case 3:
		            $x = $srcImg_w - $logow - 5;
		            $y = +15;
		            break;
		        case 4:
		            $x = +5;
		            $y = ($srcImg_h - $logoh) / 2;
		            break;
		        case 5:
		            $x = ($srcImg_w - $logow) / 2;
		            $y = ($srcImg_h - $logoh) / 2;
		            break;
		        case 6:
		            $x = $srcImg_w - $logow - 5;
		            $y = ($srcImg_h - $logoh) / 2;
		            break;
		        case 7:
		            $x = +5;
		            $y = $srcImg_h - $logoh - 5;
		            break;
		        case 8:
		            $x = ($srcImg_w - $logow) / 2;
		            $y = $srcImg_h - $logoh - 5;
		            break;
		        case 9:
		            $x = $srcImg_w - $logow - 5;
		            $y = $srcImg_h - $logoh -5;
		            break;
		        default: 
		            die("此位置不支持"); 
		            exit;
		    }
		        
		    $dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);
		        
		    imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);
		        
		    if(!strcmp($markType,"img"))
		    {
		        imagecopy($dst_img, $markim, $x, $y, 0, 0, $logow, $logoh);
		        imagedestroy($markim);
		    }
		        
		    if(!strcmp($markType,"text"))
		    {
		        $rgb = explode(',', $TextColor);
		            
		        $color = imagecolorallocate($dst_img, $rgb[0], $rgb[1], $rgb[2]);
		        imagettftext($dst_img, $fontSize, 0, $x, $y, $color, $fontType,$markText);
		    }
		        
		    switch ($srcInfo[2]) 
		    { 
		        case 1:
		            imagegif($dst_img, $imgSrc); 
		            break; 
		        case 2: 
		            imagejpeg($dst_img, $imgSrc); 
		            break; 
		        case 3: 
		            imagepng($dst_img, $imgSrc); 
		            break;
		        default: 
		            die("不支持的水印图片文件类型"); 
		            exit; 
		    }
		        
		    imagedestroy($dst_img);
		    imagedestroy($srcim);
		}
	}
}
?>