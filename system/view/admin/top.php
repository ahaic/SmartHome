<div class="navbar">
    <div class="navbar-inner">
      <div class="container" style="width: auto;padding-top: 10px;">        
        <a class="brand" href="<?=url(array('admin', 'index'))?>">QCMS PHP</a>
        <div class="nav-collapse">
         <ul class="nav pull-right">
            <li><a href="#"><i class="icon-user icon-white"></i> <?=$_COOKIE['admin']['username']?> </a></li>            
            <li><a href="<?=url(array('index'))?>"><i class="icon-home icon-white"></i> <?=$this->p_lang['home']?></a></li>
            <li><a href="<?=url(array('home', 'logout'))?>"><i class="icon-off icon-white"></i> <?=$this->p_lang['logout']?></a></li>
            <li class="divider-vertical"></li>  
           	
            
            <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-th-large icon-white"></i><?=$this->p_lang['menu']?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="#" id="flush"><i class="icon-refresh"></i><?=$this->p_lang['refresh']?></a></li>
                      <li><a href="<?=url(array('home', 'index'))?>" target="_blank"><i class="icon-home"></i><?=$this->p_lang['front']?></a></li>
                      <!--<li class="divider"></li>-->
                    </ul>
                  </li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div>
    </div><!-- /navbar-inner -->
  </div>