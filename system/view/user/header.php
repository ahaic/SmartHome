<div class="container" style="max-width:1080px">
<p style="padding-top:20px;"><form class="navbar-search pull-right" action="">
            <input type="text" id="search_txt" class="search-query span2" placeholder="Search">
            <button type="button" id="search" class="btn btn-mini">Search</button>
          </form> <img src="<?=$this->logo?>" /></p>
<div class="navbar">
    <div class="navbar-inner">
      <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="nav-collapse">
          <ul class="nav">
           
           <?
		  foreach($this->head_rs as $key => $val)
		  {
			  if(!$val['clinkture']){
				$url = url(array('home', 'cate', $val['cid']));
			  }else{
				$url = $val['clink'];
			  }
			echo '<li><a href="'.$url.'" title="'.$val['cname'].'">'.$val['cname'].'</a></li>';
		  }
		  ?>
          </ul>
         
          <ul class="nav pull-right" id="loginStr">
            
          </ul>
        </div><!-- /.nav-collapse -->
      </div>
    </div><!-- /navbar-inner -->
  </div>
</div>