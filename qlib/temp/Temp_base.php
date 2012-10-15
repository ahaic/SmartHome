<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Temp_base
{
	private $_cid_all;
	protected  $p_site;
	protected  $p_lang;
	protected $p_skin;
	public $y;
	public $p_cid;
	public $p_nid;
	public $p_eid;
	
	
	
	public function temp_index($temp)
	{
		$search = array('{qcms:webname}', '{qcms:web_keyword}', '{qcms:email}', '{qcms:web_count}', '{qcms:icp}', '{qcms:path}', '{qcms:here}', '{qcms:img_path}', '{qcms:css_path}', '{qcms:js_path}', '{qcms:skin}');
		$replace = array($this->p_site['webname'], $this->p_site['keyword'], $this->p_site['email'], $this->p_site['count'], $this->p_site['icp'], $this->sitepath, '<a href="'.$this->sitepath.'">'.$this->p_lang['home'].'</a>&nbsp;>&nbsp;', IMG_PATH, CSS_PATH, JS_PATH, $this->p_skin_img);
		foreach ($this->p_lang as $key => $val)
		{
			$search[] = '{lang:'.$key.'}';
			$replace[] = $val;
		}			
		return str_replace($search, $replace, $temp);
	}
	
	public function temp_copyright($temp){
		preg_match_all('/'.base64_decode('e3FjbXM6Y29weXJpZ2h0fQ==').'/', $temp, $matches);
		$c = count($matches[0]);
		if(empty($c)){
			$temp .= base64_decode('PGEgaHJlZj0iaHR0cDovL3d3dy5xLWNtcy5jbiIgdGFyZ2V0PSJfYmxhbmsiPlFDTVM8L2E+');			
		}else{
			$temp = str_replace(base64_decode('e3FjbXM6Y29weXJpZ2h0fQ=='), base64_decode('PGEgaHJlZj0iaHR0cDovL3d3dy5xLWNtcy5jbiIgdGFyZ2V0PSJfYmxhbmsiPlFDTVM8L2E+'), $temp);
		}
		$this->y = 1;
		return $temp;
	}
	
	public function temp_cate($temp)
	{
		$cate_obj = $this->_load_model('Q_Cate');
		$rs_temp = $cate_obj->select(array('cid' => $this->p_cid));
		$search = array('{qcms:cname}', '{qcms:pcid}', '{qcms:cid}', '{qcms:cimg}', '{qcms:ckeyword}', '{qcms:cinfo}', '{qcms:webname}', '{qcms:web_keyword}', '{qcms:email}', '{qcms:web_count}', '{qcms:icp}', '{qcms:path}', '{qcms:here}', '{qcms:img_path}', '{qcms:css_path}', '{qcms:js_path}', '{qcms:skin}');
		$replace = array($rs_temp[0]['cname'],  $rs_temp[0]['pcid'], $rs_temp[0]['cid'], $rs_temp[0]['cimg'], $rs_temp[0]['ckeyword'], $rs_temp[0]['cinfo'], $this->p_site['webname'], $this->p_site['keyword'], $this->p_site['email'], $this->p_site['count'], $this->p_site['icp'], $this->sitepath, '<a href="'.url(array('home', 'index'), $this->p_site["shorturl"]).'">'.$this->p_lang['home'].'</a>&nbsp;>&nbsp;'.self::_class_here($rs_temp[0]['cid']), IMG_PATH, CSS_PATH, JS_PATH, $this->p_skin_img);
		foreach ($this->p_lang as $key => $val)
		{
			$search[] = '{lang:'.$key.'}';
			$replace[] = $val;
		}		
		return str_replace($search, $replace, $temp);
	}
	
	public function temp_view($temp)
	{
		$news_obj = $this->_load_model('Q_News');
		$cate_obj = $this->_load_model('Q_Cate');
		$user_obj = $this->_load_model('Q_User');
		$form_obj = $this->_load_model('Q_Form');
		$rs_news = $news_obj->select(array('nid' => $this->p_nid));	
		
		$pre = $news_obj->db_obj->select('SELECT cid,nid,ntitle FROM '.$news_obj->db_prefix.'news WHERE cid=\''.$rs_news[0]['cid'].'\' AND nid < \''.$rs_news[0]['nid'].'\' ORDER BY nid DESC LIMIT 0,1');	
		$next = $news_obj->db_obj->select('SELECT cid,nid,ntitle FROM '.$news_obj->db_prefix.'news WHERE cid=\''.$rs_news[0]['cid'].'\' AND nid > \''.$rs_news[0]['nid'].'\' ORDER BY nid ASC LIMIT 0,1');	
			
		if(empty($pre)){
			$preStr = '';
		}else{
			$preStr = '<a href="'.url(array('home', 'view', $pre[0]['nid']), $this->p_site["shorturl"]).'">'.$pre[0]['ntitle'].'</a>';
		}
		if(empty($next)){
			$nextStr = '';
		}else{
			$nextStr = '<a href="'.url(array('home', 'view', $next[0]['nid']), $this->p_site["shorturl"]).'">'.$next[0]['ntitle'].'</a>';
		}
		if($rs_news[0]['uid'] == 0)
		{
			$author = $this->p_lang['anonymous'];
		}
		else
		{
			$rs_user = $user_obj->select(array('uid' => $rs_news[0]['uid']));
			$author = empty($rs_user[0]['username']) ? '' : $rs_user[0]['username'];			
		}		
		$rs_cate = $cate_obj->select(array('cid' => $rs_news[0]['cid']));
		if(!empty($rs_cate[0]['cfield'])){
			$form_rs = $form_obj->select(array('id' => $rs_cate[0]['cfield']));
			$cfield_arr = empty($form_rs[0]['field']) ? array() : @unserialize($form_rs[0]['field']);
		}
		$tag_arr = explode(',', $rs_news[0]['nkeyword']);
		foreach ($tag_arr as $tval)
		{
			$tags .= '<a href="'.url(array('home', 'search', urlencode($tval)), $this->p_site["shorturl"]).'">'.$tval.'</a> ';
		}
		
		$contArr = explode('[page]', $rs_news[0]['ncontent']);
		$count = count($contArr);
		if(empty($_GET['p']) || $_GET['p'] <= 0){
			$page = 0;
		}elseif($_GET['p'] >= ($count-1)){
			$page = ($count-1);
		}else{
			$page = $_GET['p'];
		}
		$pageArr = easy_page($page, $count, url(array('home', 'view', $rs_news[0]['nid']), $this->p_site["shorturl"]));
		$contStr = $contArr[$page];
		$news_content = str_replace(array('{', '}'), array('@{@', '@}@'), $contStr);
		$news_info = str_replace(array('{', '}'), array('@{@', '@}@'), strip_tags(substr($rs_news[0]['ncontent'], 0, $this->p_site['infolen'])));
		$search = array('{qcms:cname}', '{qcms:cid}', '{qcms:cimg}', '{qcms:ckeyword}', '{qcms:cinfo}', '{qcms:author}', 
		'{qcms:id}', '{qcms:title}', '{qcms:url}', '{qcms:keyword}', '{qcms:tags}', '{qcms:content}', '{qcms:time}', '{qcms:img}', '{qcms:count}', 
		'{qcms:webname}', '{qcms:web_keyword}', '{qcms:email}', '{qcms:web_count}', '{qcms:icp}', '{qcms:path}', '{qcms:here}', '{qcms:info}', '{qcms:pre}', '{qcms:next}');
		$replace = array($rs_cate[0]['cname'], $rs_cate[0]['cid'], $rs_cate[0]['cimg'], $rs_cate[0]['ckeyword'], $rs_cate[0]['cinfo'], $author,
		$rs_news[0]['nid'], $rs_news[0]['ntitle'], url(array('home', 'view', $rs_news[0]['nid']),$this->p_site["shorturl"]), $rs_news[0]['nkeyword'], $tags, $news_content, $rs_news[0]['ntime'], $rs_news[0]['nimg'], '<script type="text/javascript" src="'.url(array('home', 'count', $rs_news[0]['nid']), $this->p_site["shorturl"]).'"></script>',
		$this->p_site['webname'], $this->p_site['keyword'], $this->p_site['email'], $this->p_site['count'], $this->p_site['icp'], $this->sitepath, '<a href="'.$this->sitepath.'">'.$this->p_lang['home'].'</a>&nbsp;>&nbsp;'.self::_class_here($rs_news[0]['cid']), $news_info,
		$preStr, $nextStr);
		foreach($pageArr as $k => $v){
			$search[] = '{qcms:'.$k.'}';
			if($count <= 1){
				$replace[] = '';
			}else{
				$replace[] = $v;
			}			
		}	
		$nfield = empty($rs_news[0]['nfield']) ? '' : @unserialize($rs_news[0]['nfield']);
		if(is_array($cfield_arr) && is_array($nfield))
		{
			foreach($cfield_arr as $ckey => $cval){
				switch($cval['field_type']){
					case 1:
						$search[] = '{qcms:'.$cval['field_name'].'}';
						$replace[] = $nfield[$cval['field_name']];
						break;
					case 2:
						$search[] = '{qcms:'.$cval['field_name'].'}';
						$replace[] = $nfield[$cval['field_name']];
						break;
					case 3:
						$search[] = '{qcms:'.$cval['field_name'].'}';
						$replace[] = $nfield[$cval['field_name']];
						break;
					case 4:
						$search[] = '{qcms:'.$cval['field_name'].'}';
						if(is_array($nfield[$cval['field_name']])){
							$replace[] = '<li>'.implode('</li><li>', $nfield[$cval['field_name']]).'</li>';
						}else {
							$replace[] = '';
						}						
						break;
					case 5:
						$search[] = '{qcms:'.$cval['field_name'].'}';
						$replace[] = $nfield[$cval['field_name']];
						break;
					case 6:
						$search[] = '{qcms:'.$cval['field_name'].'}';
						$m_pic = explode('|', $nfield[$cval['field_name']]);
						if(empty($m_pic)){
							$replace[] = '';
						}else{
							$replace[] = '<li>'.implode('</li><li>', $m_pic).'</li>';
						}									
						break;									
				}
			}
		}
		foreach ($this->p_lang as $lkey => $lval)
		{
			$search[] = '{lang:'.$lkey.'}';
			$replace[] = $lval;
		}
		$search[] = '{qcms:css_path}';
		$search[] = '{qcms:img_path}';
		$search[] = '{qcms:js_path}';
		$search[] = '{qcms:skin}';
		$replace[] = CSS_PATH;
		$replace[] = IMG_PATH;
		$replace[] = JS_PATH;
		$replace[] = $this->p_skin_img;
		return str_replace($search, $replace, $temp);
	}
	
	public function temp_diy($temp){
		$ext_obj = self::_load_model('Q_Tag');
		$rs = $ext_obj->select(array('eid' => $this->p_eid)); 
		if(file_exists($this->p_skin.'diy.html')){
			$search = array('{qcms:id}', '{qcms:title}', '{qcms:content}');
			$replace = array($rs[0]['eid'], $rs[0]['etitle'], $rs[0]['einfo']);
			$search[] = '{qcms:css_path}';
			$search[] = '{qcms:img_path}';
			$search[] = '{qcms:js_path}';
			$search[] = '{qcms:skin}';
			$replace[] = CSS_PATH;
			$replace[] = IMG_PATH;
			$replace[] = JS_PATH;
			$replace[] = $this->p_skin_img;
			$str = file_get_contents($this->p_skin.'diy.html');
			$str = str_replace($search, $replace, $str);
		}else{
			$str = $rs[0]['einfo'];
		}
		return $str;
	}
	
	public function temp_search($temp){			
		$search = array('{qcms:webname}', '{qcms:web_keyword}', '{qcms:email}', '{qcms:web_count}', '{qcms:icp}', '{qcms:path}', '{qcms:here}', '{qcms:img_path}', '{qcms:css_path}', '{qcms:js_path}', '{qcms:skin}');
		$replace = array($this->p_site['webname'], $this->p_site['keyword'], $this->p_site['email'], $this->p_site['count'], $this->p_site['icp'], $this->sitepath, '<a href="'.$this->sitepath.'">'.$this->p_lang['home'].'</a>&nbsp;>&nbsp;', IMG_PATH, CSS_PATH, JS_PATH, $this->p_skin_img);
		foreach ($this->p_lang as $key => $val)
		{
			$search[] = '{lang:'.$key.'}';
			$replace[] = $val;
		}	
		if(!empty($_GET['keyword'])){
			$cid = empty($_GET['cid']) ? 0 : intval($_GET['cid']);
			$keyArr = explode(' ', $_GET['keyword']);
			$key = implode(',', $keyArr);
			$search[] = '{qcms:cid}';
			$search[] = '{qcms:key}';
			$replace[] = $cid;
			$replace[] = $key;
		}		
		return str_replace($search, $replace, $temp);
	}
	
	public function temp_include($temp)
	{
		$search = array();
		$replace = array();
		preg_match_all('/{include:([\s\S.]*?)}/', $temp, $matches);
		foreach ($matches[1] as $key => $val)
		{
			if(file_exists($this->p_skin.$val.'.html'))
			{
				$search[] = '{include:'.$val.'}';
				$replace[] = file_get_contents($this->p_skin.$val.'.html');
			}
			else
			{
				$search[] = '{include:'.$val.'}';
				$replace[] = '';
				msg('Temp : '.$this->p_skin.$val.'.html err<br>');
			}
		}
		return str_replace($search, $replace, $temp);
	}
	
	public function temp_php($temp)
	{
		$search = array();
		$replace = array();
		preg_match_all('/<{php:([\s\S.]*?)}>/', $temp, $matches);
		foreach ($matches[1] as $key => $val)
		{
			$search[] = '<{php:'.$val.'}>';
			$replace[] = eval($val);
		}
		return str_replace($search, $replace, $temp);
	}
	
	public function temp_tag($temp)
	{
		$search = array();
		$replace = array();
		preg_match_all('/{tag:([0-9]+)}/',$temp, $matches);
		if(empty($matches[1]))return $temp;
		$ext_obj = self::_load_model('Q_Tag');
		$rs = $ext_obj->select(array('eid' => $matches[1])); 
		if($rs == FALSE) return $temp;
		foreach ($rs as $key => $val)
		{
			$search[] = '{tag:'.$val['eid'].'}';
			$replace[] = $val['einfo'];
		}
		return str_replace($search, $replace, $temp);
	}
	
	
	
	public function temp_menu($temp)
	{
		$cate_obj = self::_load_model('Q_Cate');
		$replace_all = array();
		 preg_match_all('/{menu([\s\S.]*?)}([\s\S.]*?){\/menu}/i',$temp, $matches);
		 if(empty($matches[1]))return $temp;
		 foreach ($matches[0] as $mkey => $mval)
		 {		 	
		 	preg_match('/{menu([\s\S.]*?)}([\s\S.]*?){\/menu}/i',$mval, $match);		 			 	
		 	$parameters = self::_get_parameters($match[1]);		 	
		 	$row = empty($parameters['row']) ? 10 : $parameters['row'];
		 	$rs = $cate_obj->select(array('pcid' => '0', 'con' => 1), array(0, $row), '*', 0, 0, array('csort' => 'ASC')); 
		 	if($rs != FALSE)
			{				
				$search = array('{field:i}', '{field:j}', '{field:m_name}', '{field:m_id}', '{field:m_keyword}', '{field:m_info}', '{field:m_img}', '{field:m_url}', '{field:current}');
				$str = '';
				$i = 0;
				$j = 0;				
				foreach ($rs as $key => $val)
				{
					$i += 1;
					$j = $i%2;
					$current =($this->p_cid == $val['cid'])? 'current' : 'notcurrent';
					$m_url = url(array('home', 'cate', $val['cid']), $this->p_site["shorturl"]);
					if($val['clinkture'] == 1)
				 	{
				 		$m_url = $val['clink'];
				 	}
					$replace = array($i, $j, $val['cname'], $val['cid'], $val['ckeyword'], $val['cinfo'], $val['cimg'], $m_url, $current);
					$str .= str_replace($search, $replace, $match[2]);
				}
				$replace_all[] =$str;
			}			
		 }
		 return str_replace($matches[0], $replace_all, $temp);
	}

	public function temp_class($temp)
	{		
		$cate_obj = self::_load_model('Q_Cate');
		$replace_all = array();
		$cid_select = empty($_GET['id']) ? 0 : $_GET['id'];
		$pcid_rs = $cate_obj->select(array('cid' => $cid_select));	
		 preg_match_all('/{class([\s\S.]*?)}([\s\S.]*?){\/class}/i',$temp, $matches);
		 if(empty($matches[1]))return $temp;
		 foreach ($matches[0] as $mkey => $mval)
		 {		 	
		 	preg_match('/{class([\s\S.]*?)}([\s\S.]*?){\/class}/i',$mval, $match);		 			 	
		 	$parameters = self::_get_parameters($match[1]);	
		 	$row = empty($parameters['row']) ? 10 : $parameters['row'];
		 	$cid = empty($parameters['cid']) ? $pcid_rs[0]['pcid'] : $parameters['cid'];
		 	$rs = $cate_obj->select(array('pcid' => $cid, 'con' => 1), array(0, $row), '*', '0', '0', array('csort' => 'ASC'));		 	
			if($rs != FALSE)
			{
				$search = array('{field:i}', '{field:j}', '{field:c_name}', '{field:c_id}', '{field:c_keyword}', '{field:c_info}', '{field:c_img}', '{field:c_url}', '{field:current}');
				$str = '';
				$i = 0;
				$j = 0;				
				foreach ($rs as $key => $val)
				{
					$i += 1;
					$j = $i%2;
					$current =($this->p_cid == $val['cid'])? 'current' : 'notcurrent';
					$c_url = url(array('home', 'cate', $val['cid']), $this->p_site["shorturl"]);
					if($val['clinkture'] == 1)
				 	{
				 		$c_url = $val['clink'];
				 	}					
					$replace = array($i, $j, $val['cname'], $val['cid'], $val['ckeyword'], $val['cinfo'], $val['cimg'], $c_url, $current);
					$str .= str_replace($search, $replace, $match[2]);
				}
				$replace_all[] = $str;
			}
		 }		 
		 return str_replace($matches[0], $replace_all, $temp);
	}

	public function temp_list($temp)
	{		
		$news_obj = self::_load_model('Q_News');
		$cate_obj = self::_load_model('Q_Cate');
		$form_obj = self::_load_model('Q_Form');
		$replace_all = array();		
		 preg_match_all('/{list([\s\S.]*?)}([\s\S.]*?){\/list}/i',$temp, $matches);
		 if(empty($matches[1]))return $temp;
		 foreach ($matches[0] as $mkey => $mval)
		 {
		 	$count = '';
		 	preg_match('/{list([\s\S.]*?)}([\s\S.]*?){\/list}/i',$mval, $match); 			 	
		 	$parameters = self::_get_parameters($match[1]);	
		 	$cid = empty($parameters['cid']) ? $this->p_cid : $parameters['cid'];
		 	$cid = empty($cid) ? 0 : $cid;
		 	$row = empty($parameters['row']) ? 10 : $parameters['row'];	
		 	$key = empty($parameters['key']) ? '' : $parameters['key'];
		 	$len = empty($parameters['len']) ? 30 : $parameters['len']; 
		 	$ord = empty($parameters['ord']) ? 0 : $parameters['ord'];
		 	$type = empty($parameters['type']) ? 0 : $parameters['type'];
		 	$img = empty($parameters['img']) ? 0 : $parameters['img'];
		 	$page = empty($parameters['page']) ? 0 : $parameters['page']; 
		 	$ord_arr = self::_order($ord);
		 	$time = empty($parameters['time']) ? 0 : $parameters['time'];
		 	$keyArr = explode(',', $key);
		 	$keyStr = array();
		 	if(!empty($keyArr[0])){
		 		foreach ($keyArr as $val){
		 			$keyStr[] = ' ntitle LIKE \'%'.$val.'%\' ';
		 		}
		 		$keyCond = ' AND ('.implode('OR', $keyStr).') ';
		 	}
		 	$offset = empty($_GET['p']) ? 0 : ($_GET['p']-1) * $row;
		 	self::_all_cid($cid);
		 	$cond_arr = array('cid' => $this->_cid_all);
		 	$cid_rs = $cate_obj->select($cond_arr, '', 'cname, cid, cimg, cpy, clinkture, clink, cfield', 0, 'cid');		 	
		 	if(!empty($type)){
		 		$cond_arr['type'] = $type;
		 	}
		 	if(!empty($img)){
		 		$cond_arr['isimg'] = 1;
		 	}
		 	$rs = $news_obj->select_all($cond_arr, ' limit '.$offset.','.$row.'', '*', $count, 0, 0, $keyCond.$ord_arr); 		 	
		 	if($rs != FALSE)
			{	
				//-- userList --
				foreach ($rs as $k => $v){
					$uidArr[] = $v['uid'];
				}	
				if(!empty($uidArr)){
					$userObj = $this->_load_model('Q_User');
					$userArr = $userObj->select(array('uid' => $uidArr), '', 'uid,username', 0, 'uid');
				}		
				
				$str = '';
				$i = 0;
				$j = 0;		
				$idArr = array();				
				foreach ($rs as $key => $val)
				{					
					$i += 1;
					$j = $i%2;
					$url = url(array('home', 'view', $val['nid']), $this->p_site["shorturl"]);
				 	$c_url = url(array('home', 'cate', $val['cid']), $this->p_site["shorturl"]);
				 	$form_rs = $form_obj->select(array('id' => $cid_rs[$val['cid']]['cfield']));
				 	if(!empty($form_rs)){
				 		$cfield_arr = @unserialize($form_rs[0]['field']);
				 	}		 			
				 	if($cid_rs[$val['cid']]['clinkture'] == 1)
				 	{
				 		$c_url = $cid_rs[$val['cid']]['clink'];
				 	}
				 	if($val['outlink'] == 1){
				 		$url = $val['npy'];
				 	}
					$tag_arr = explode(',', $val['nkeyword']);
					foreach ($tag_arr as $tval)
					{
						$tags .= '<a href="'.url(array('home', 'search', urlencode($tval)), $this->p_site["shorturl"]).'">'.$tval.'</a> ';
					}
					$news_content = str_replace(array('{', '}'), array('@{@', '@}@'), $val['ncontent']);
					$news_info = str_replace(array('{', '}'), array('@{@', '@}@'), strip_tags(substr($val['ncontent'], 0, $this->p_site['infolen'])));
				 	$nfield = empty($val['nfield']) ? '' : @unserialize($val['nfield']);
				 	$search = array('{field:i}', '{field:j}', '{field:title}', '{field:id}', '{field:keyword}', '{field:tag}', '{field:content}', '{field:time}', '{field:count}', '{field:img}', '{field:url}', '{field:cname}', '{field:cimg}', '{field:curl}', '{field:author}', '{field:uid}', '{field:info}');
				 	$replace = array($i, $j, self::_substr($val['ntitle'], $len), $val['nid'], $val['nkeyword'], $tags, $news_content, self::_time($val['ntime'], $time), $val['count'], $val['nimg'], $url, $cid_rs[$val['cid']]['cname'], $cid_rs[$val['cid']]['cimg'], $c_url, $userArr[$val['uid']]['username'], $val['uid'], $news_info);	 	
				 	if(is_array($cfield_arr) && is_array($nfield))
					{
						foreach($cfield_arr as $ckey => $cval){
							switch($cval['field_type']){
								case 1:
									$search[] = '{field:'.$cval['field_name'].'}';
									$replace[] = $nfield[$cval['field_name']];
									break;
								case 2:
									$search[] = '{field:'.$cval['field_name'].'}';
									$replace[] = $nfield[$cval['field_name']];
									break;
								case 3:
									$search[] = '{field:'.$cval['field_name'].'}';
									$replace[] = $nfield[$cval['field_name']];
									break;
								case 4:
									$search[] = '{field:'.$cval['field_name'].'}';
									if(is_array($nfield[$cval['field_name']])){
										$replace[] = '<li>'.implode('</li><li>', $nfield[$cval['field_name']]).'</li>';
									}else {
										$replace[] = '';
									}									
									break;
								case 5:
									$search[] = '{field:'.$cval['field_name'].'}';
									$replace[] = $nfield[$cval['field_name']];
									break;
								case 6:
									$search[] = '{field:'.$cval['field_name'].'}';
									$m_pic = explode('|', $nfield[$cval['field_name']]);
									if(empty($m_pic)){
										$replace[] = '';
									}else{
										$replace[] = '<li>'.implode('</li><li>', $m_pic).'</li>';
									}									
									break;									
							}
						}
					}
					$str .= str_replace($search, $replace, $match[2]);
				}
				$replace_all[] = $str;
			}else{
				$replace_all[] = '';
			}			
			 if($page != 0)
			 {
			 	$page_url = '';
			 	if(empty($_GET['c']) && empty($_GET['m']))
			 	{
			 		$page_url = '?';
			 	}
			 	$temp = str_replace('{page}', page_bar($count[0]['count'], $row, ''), $temp);	
			 }	
			 $this->_cid_all = '';
		 }	
			 
		 return str_replace($matches[0], $replace_all, $temp);
	}
	
	public function temp_loop($temp)
	{
		$replace_all = array();
		preg_match_all('/{loop ([\s\S.]*?)}([\s\S.]*?){\/loop}/i',$temp, $matches);
		if(empty($matches[0]))return $temp;
		foreach ($matches[0] as $mkey => $mval)
		 {
		 	preg_match('/{loop([\s\S.]*?)}([\s\S.]*?){\/loop}/i',$mval, $match);
		 	$sql = trim($match[1]);
			$d_obj = new Db_class();
			$sql = str_replace('[pre]', $d_obj->db_prefix, $sql);			
			$rs = $d_obj->db_obj->select($sql); 	
			if($rs != FALSE)
			{				
				$str = '';
				$i = 0;
				$j = 0;
				foreach ($rs as $key => $val)
				{
					$i += 1;
					$j = $i%2;
					$search = array('{field:i}', '{field:j}');
					$replace = array($i, $j);					
					foreach ($val as $mkey => $mval)
					{
						$search[] = '{field:'.$mkey.'}';
						$replace[] = $mval;
					}
					
					$str .= str_replace($search, $replace, $match[2]);
				}			
				$replace_all[] = $str;
			}
		 }		 
		 return str_replace($matches[0], $replace_all, $temp);
	}
	
	public function temp_table($temp)
	{
		$replace_all = array();
		preg_match_all('/{table([\s\S.]*?)}([\s\S.]*?){\/table}/i',$temp, $matches);
		if(empty($matches[1]))return $temp;
		foreach ($matches[0] as $mkey => $mval)
		{
			$cond = '';
			preg_match('/{table([\s\S.]*?)}([\s\S.]*?){\/table}/i',$mval, $match);		 			 	
		 	$parameters = self::_get_parameters($match[1]);	
		 	$name = empty($parameters['name']) ? '' : $parameters['name'];
		 	$row = empty($parameters['row']) ? 10 : $parameters['row'];
		 	$ord = empty($parameters['ord']) ? 10 : $parameters['ord'];		 	
		 	$cond .= empty($parameters['cid']) ? '' : ' WHERE cid = '.$parameters['cid'];
		 	$cond .= empty($parameters['pcid']) ? '' : ' WHERE pcid = '.$parameters['pcid'];
		 	$cond .= empty($parameters['etype']) ? '' : ' WHERE etype = '.$parameters['etype'];
		 	$cond .= empty($parameters['gtype']) ? '' : ' WHERE gtype = '.$parameters['gtype'];
		 	$cond .= empty($parameters['flag']) ? '' : ' WHERE flag = '.$parameters['flag'];
		 	$cond .= empty($parameters['level']) ? '' : ' WHERE level = '.$parameters['level'];
		 	$d_obj = new Db_class();
		 	$rs = $d_obj->db_obj->select('SELECT * FROM '.$d_obj->db_prefix.$name.$cond.' ORDER BY '.$ord.' DESC LIMIT 0,'.$row.''); 
			if($rs != FALSE)
			{				
				$str = '';
				$i = 0;
				$j = 0;
				foreach ($rs as $key => $val)
				{
					$i += 1;
					$j = $i%2;
					$search = array('{field:i}', '{field:j}');
					$replace = array($i, $j);					
					foreach ($val as $mkey => $mval)
					{
						$search[] = '{field:'.$mkey.'}';
						$replace[] = $mval;
					}
					
					$str .= str_replace($search, $replace, $match[2]);
				}			
				$replace_all[] = $str;
			}

		}		 
		return str_replace($matches[0], $replace_all, $temp);
	}
	
	public function temp_global($temp)
	{
		$search = array();
		$replace = array();
		$search_sub = array();
		$replace_sub = array();
		preg_match_all('/{time:([0-9]+)@([\s\S.]*?)}/',$temp, $matches);
		preg_match_all('/{substr:([0-9]+)@([\s\S.]*?)}/',$temp, $matches_sub);
		preg_match_all('/{count:([0-9]+)}/',$temp, $matches_cate);
		
		if(!empty($matches[1]))
		{
			$i = 0;
			while($i < count($matches[1]))
			{			
				$search[] = $matches[0][$i];			
				$replace[] = self::_time($matches[2][$i], $matches[1][$i]);			
				$i++;
			}
			$temp = str_replace($search, $replace, $temp);
		}
		
		if(!empty($matches_sub[1]))	
		{
			
			$i = 0;
			while($i < count($matches_sub[1]))
			{			
				$search_sub[] = $matches_sub[0][$i];			
				$replace_sub[] = self::_substr($matches_sub[2][$i], $matches_sub[1][$i]);			
				$i++;
			}
			
			$temp = str_replace($search_sub, $replace_sub, $temp);
		}
		
		if(!empty($matches_cate[1]))
		{
			$i = 0;
			while($i < count($matches_cate[1]))
			{		
				if($matches_cate[1][$i] == 999)
				{
					$search_sub[] = $matches_cate[0][$i];						
					$replace_sub[] = $replace_sub[] = self::_count_guest(0);
				}
				elseif($matches_cate[1][$i] == 888)
				{
					$search_sub[] = $matches_cate[0][$i];	
					$replace_sub[] = self::_count_guest(1);
				}
				else
				{
					$search_sub[] = $matches_cate[0][$i];		
					$replace_sub[] = self::_count_cate($matches_cate[1][$i]);
				}							
				$i++;
			}			
			$temp = str_replace($search_sub, $replace_sub, $temp);
		}
		return $temp;
	}
	
	protected function temp_module($temp){
		preg_match_all('/{module:([\s\S.]*?)}/',$temp, $matches);
		if(empty($matches[1]))return $temp;
		$str = '';
		$search = array();
		$replace = array();
		foreach($matches[1] as $v){
			$actArr = explode('@', $v);
			if(!file_exists('module/'.$actArr[0].'/'.$actArr[0].'_module'.EXT)){
				break;
			}
			require 'module/'.$actArr[0].'/'.$actArr[0].'_module'.EXT;
			$m = $actArr[0].'_module';
			$class = new $m();
			$search[] = '{module:'.$actArr[0].'@'.$actArr[1].'}';
			$replace[] = $class->$actArr[1]();
		}
		return str_replace($search, $replace, $temp);
	}
	
	protected function temp_pic($temp){
		preg_match_all('/{img:([\s\S.]*?)}/',$temp, $matches);
		if(empty($matches[1]))return $temp;
		$str = '';
		$search = array();
		$replace = array();
		foreach($matches[1] as $v){
			$actArr = explode('@', $v);
			$search[] = '{img:'.$actArr[0].'@'.$actArr[1].'@'.$actArr[2].'}';
			$replace[] = self::_img($actArr[0], $actArr[1], $actArr[2]);
		}
		return str_replace($search, $replace, $temp);
	}
	
	private function _count_cate($cid)
	{
		$news_obj = self::_load_model('Q_News');
		self::_all_cid($cid);
		$cond_arr = array('cid' => $this->_cid_all);
		$rs = $news_obj->select($cond_arr, '', 'COUNT(*) AS count');
		$this->_cid_all = '';
		return $rs[0]['count'];
	}
	
	private function _count_guest($type)
	{
		$guest_obj = self::_load_model('Q_Guest');
		$rs = $guest_obj->select(array('gtype' => $type), '', 'COUNT(*) as count');
		return $rs[0]['count'];
	}
	
	private function _load_model($model)
	{
		$base = new Home();
		return $base->load_model($model);
	}	

	private function _get_parameters($str)
	{
		if(empty($str))
		{
			return array();
		}
		$str_arr = explode(" ", trim($str));
		$parameters_arr = array();
		foreach ($str_arr as $key => $val)
		{
			$str_arr[$key] = explode('=', $val);
		}
		foreach ($str_arr as $key => $val)
		{
			$parameters_arr[$val[0]] = $val[1];
		}
		return $parameters_arr;
	}
	
	
	private function _substr($str,$len)
	{
		$len = ($len < 2) ? 2 : $len;
    	for($i=0;$i<$len;$i++)
    	{
	        $temp_str=substr($str,0,1);
	        if(ord($temp_str) > 127)
	        {
	            $i++;
	        	if($i<$len)    
	        	{
	            	$new_str[]=substr($str,0,3);
	            	$str=substr($str,3);
	            }
	        }
	    	else 
	    	{
	        	$new_str[]=substr($str,0,1);
	        	$str=substr($str,1);
	        }
    	}
    	return join($new_str);
	} 
	
	private function _order($ord = 0)
	{
		$ord_arr = array();
		switch($ord)
		{
			case 1:
				$ord_arr = ' ORDER BY nsort desc,ntime desc ';
				break;
			case 2:
				$ord_arr = ' ORDER BY nsort desc,count desc ';
				break;
			default:
			$ord_arr = ' ORDER BY nsort desc,nid desc ';	
			break;
		}
		return $ord_arr;
	}
	
	private function _time($time_str, $t = 0)
	{
		switch($t)
		{
			case 1:
				return date('Y-m-d', strtotime($time_str));
				break;
			case 2:
				return date('m-d', strtotime($time_str));
				break;
			default:
				return date('Y-m-d H:i:s', strtotime($time_str));
				break;			
		}
	}	
	
	private function _all_cid($cid)
	{
		$this->_cid_all[] = $cid;
		$cate_obj = self::_load_model('Q_Cate');
		$cid_arr = $cate_obj->select(array('pcid' => $cid), '', 'cid, pcid');
		
		if(empty($cid_arr)) return;
		foreach ($cid_arr as $key => $val)
		{
			$this->_cid_all[] = $val['cid'];
			self::_sub_cid($val['cid']);
		}
		return $cid_arr;
	}
	
	private function _sub_cid($cid)
	{
		$cate_obj = self::_load_model('Q_Cate');		
		$cid_arr = $cate_obj->select(array('pcid' => $cid), '', 'cid');	
		if(empty($cid_arr))return ;
		foreach ($cid_arr as $key => $val)
		{
			$this->_cid_all[] = $val['cid'];			
			self::_sub_cid($val['cid']);
			
		}
		return;
	}
	
	private function _class_here($cid)
	{
		$c_url = '';
		$cate_obj = self::_load_model('Q_Cate');
		$rs = $cate_obj->select(array('cid' => $cid));
		$c_url = url(array('home', 'cate', $rs[0]['cid']), $this->p_site["shorturl"]);
		if($rs[0]['pcid'] != 0)
		{
			 
			 $here = self::_class_here($rs[0]['pcid'])."<a href='".$c_url."'>".$rs[0]['cname']."</a>&nbsp;>&nbsp;";
		}
		else
		{
			 $here = "<a href='".$c_url."'>".$rs[0]['cname']."</a>&nbsp;>&nbsp;";
		}
		return $here;
	}
	
	protected  function load_config()
	{		
		if(is_file(LIB.'config.qcms'))
		{
			$this->p_site = unser_str(file_get_contents(LIB.'config.qcms'));
			$this->p_lang = require LIB.'language/'.$this->p_site['language'].EXT;
		}else{
			echo 'SYS ERROR!';
			exit();
		}	
		return $this->_site;
	}
	
	private function _img($url, $width, $height)
	{
		$url=str_replace('/static/','static/',$url);	
		$ext = substr($url, -4);		
		$url_arr = explode('_', substr($url, 0, -4));
		if(empty($url_arr))
		{
			return;
		}		
		return $url_arr[0].'_w'.$width.'_h'.$height.''.$ext;
	}
}
?>