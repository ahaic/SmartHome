<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function load_class($class, $instantiate = TRUE)
{
	static $objects = array();
	if($instantiate == FALSE)
	{
		require LIB.'class/'.$class.EXT;
		return;
	}
	if(isset($objects[$class]))
	{
		return $objects[$class];
	}
	if(file_exists(LIB.'class/'.$class.EXT))
	{
		require LIB.'class/'.$class.EXT;
		$objects[$class] = new $class();
		return $objects[$class];
	}
	else 
	{
		return FALSE;
	}
}

function unser_str($str)
{
	$result =preg_replace('/s:(\d+):"(.*?)";/se', "'s:'.strlen('$2').':\"$2\";'", $str); 
	return unserialize ($result); 	
}

function load_file($file_arr, $folder = '')
{
	$folder = empty($folder) ? 'common/' : $folder.'/';
	if(is_array($file_arr))
	{
		foreach($file_arr as $key => $val)
		{
			require LIB.$val.'/'.$key.EXT;
		}
	}
	else 
	{
		require LIB.$folder.$file_arr.EXT;
	}
}

function msg($str)
{
	echo '<font color="#ff0000"><b>'.ucfirst($str).'</b></font>';
	return;
}

function exec_script($str)
{	
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script>'.$str.'</script>';
}

function url($url_arr, $type = 0)
{
	$p_site = unser_str(file_get_contents(LIB.'config.qcms'));
	if($url_arr == array('home', 'index'))
	{
		return SITEPATH;
	}
	$url = '';
	foreach ($url_arr as $key => $val)
	{
		if(!empty($type)){
			if($val != 'home'){
				$url .= '/'.$val;
			}
		}else{
			$url .= '/'.$val;
		}		
	}
	if(empty($p_site['mode'])){
		$result = 'index.php?q='.substr($url.'.html', 1);
	}else{
		$result = substr($url.'.html', 1);
	}
	return SITEPATH.$result;
}

function page_bar($count, $size, $url = '', $num = 9, $parameter = 'p')
{	
	$url =empty($url) ? $_SERVER['REQUEST_URI'] : $url;
	if(!stripos($url, $parameter.'=')){
		if(!empty($_GET)){
			$page_url = $url.'&'.$parameter.'=';
		}else{
			$page_url = $url.'?'.$parameter.'=';
		}
		
	}else{	
		$page_url = substr($url, 0,  (strripos($url, $parameter.'=')+strlen($parameter.'=')));
	}
	$p = empty($_GET[$parameter]) ? 1 : $_GET[$parameter];
	$toall = ceil($count/$size);
	$toall_str = '<li>Toall:'.$count.'</li>';
	if($p > $toall)$p = $toall;
	$str = '';
	$pre = ($p <= 1) ? '<li><a href="'.$page_url.'1">«</a></li>' : '<li><a href="'.$page_url.($p-1).'">«</a></li>';
	$next = ($p >= $toall) ? '<li><a href="'.$page_url.$toall.'">»</a></li>' : '<li><a href="'.$page_url.($p+1).'">»</a></li>';
	$pre = '';
	$next = '';
	if($toall <= $num)
	{
		for($i=1;$i<=$toall;$i++)
		{			
			if($p == $i){
				$str .= '<a class="btn">'.$i.'</a>';
			}else{
				$str .= '<a class="btn" href="'.$page_url.$i.'">'.$i.'</a>';
			}
			
		}
		return '<div class="btn-toolbar"><div class="btn-group"><a class="btn" href="'.$page_url.'1">«</a>'.$pre.$str.$next.'<a class="btn" href="'.$page_url.$toall.'">»</a></div></div>';
	}
	if(($toall - $p) > ceil($num/2) && $p < ceil($num/2))
	{
		for($i=1;$i<=$num;$i++)
		{			
			if($p == $i){
				$str .= '<a class="btn">'.$i.'</a>';
			}else{
				$str .= '<a class="btn" href="'.$page_url.$i.'">'.$i.'</a>';
			}
		}
		
		return '<div class="btn-toolbar"><div class="btn-group"><a class="btn" href="'.$page_url.'1">«</a>'.$pre.$str.$next.'<a class="btn" href="'.$page_url.$toall.'">»</a></div></div>';
	}
	if(($toall - $p) < ceil($num/2))
	{
		for($i = ($toall - $num + 1);$i <= $toall;$i++)
		{
			if($p == $i){
				$str .= '<a class="btn">'.$i.'</a>';
			}else{
				$str .= '<a class="btn" href="'.$page_url.$i.'">'.$i.'</a>';
			}
		}
		return '<div class="btn-toolbar"><div class="btn-group"><a class="btn" href="'.$page_url.'1">«</a>'.$pre.$str.$next.'<a class="btn" href="'.$page_url.$toall.'">»</a></div></div>';
	}
	for($i = ($p -  floor($num/2));$i <= ($p + floor($num/2));$i++)
	{
			if($p == $i){
				$str .= '<a class="btn">'.$i.'</a>';
			}else{
				$str .= '<a class="btn" href="'.$page_url.$i.'">'.$i.'</a>';
			}
	}		
	return '<div class="btn-toolbar"><div class="btn-group"><a class="btn" href="'.$page_url.'1">«</a>'.$pre.$str.$next.'<a class="btn" href="'.$page_url.$toall.'">»</a></div></div>';
}


function easy_page($page, $toall, $url){
	$page_bar = array();
	$page_bar['first_page'] = $url.'&p=0';
	$page_bar['pre_page'] = $url.'&p='.($page-1);
	$page_bar['now_page'] = $url.'&p='.$page;
	$page_bar['next_page'] = $url.'&p='.($page+1);
	$page_bar['end_page'] = $url.'&p='.($toall-1);
	$page_bar['now'] = ($page+1);
	$page_bar['toall'] = $toall;
	$page_bar['style'] = ($toall <= 1) ? 'none' : 'block';
	$page_bar['page'] = '<a href="'.$page_bar['first_page'].'">第一页</a>&nbsp;<a href="'.$page_bar['pre_page'].'">上一页</a>&nbsp;&nbsp;'.$page_bar['now'].'&nbsp;&nbsp;<a href="'.$page_bar['next_page'].'">下一页</a>&nbsp;<a href="'.$page_bar['end_page'].'">最后一页</a>';
	return $page_bar;
}

function isSInaApp(){
	if(!class_exists('SaeStorage'))
	{
		class SaeStorage
		{
			public function write($fakeDomain,$filename,$data)
			{
				file_put_contents($filename,$data);
			}
			public function read($fakeDomain,$filename)
			{
				return file_get_contents($filename);
			}
			public function delete($fakeDomain,$filename)
			{
				return unlink(filename);
			}
			public function fileExists($fakeDomain,$filename)
			{
				return file_exists(filename);
			}
		}
	}
	
	return new SaeStorage();
}
?>