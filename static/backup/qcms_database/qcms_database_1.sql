CREATE TABLE `{qcms}_cate` (
  `cid` int(11) NOT NULL auto_increment,
  `pcid` int(11) NOT NULL default '0',
  `cname` varchar(50) NOT NULL default '',
  `cimg` varchar(255) default NULL,
  `clink` varchar(255) default '',
  `ckeyword` varchar(255) default NULL,
  `cinfo` text,
  `con` int(3) NOT NULL default '0',
  `csort` int(11) NOT NULL default '0',
  `ctemp` varchar(255) NOT NULL default '',
  `ntemp` varchar(255) NOT NULL default '',
  `cpy` varchar(255) NOT NULL default '',
  `cfield` int(1) NOT NULL default '0',
  `clinkture` int(3) NOT NULL default '0',
  PRIMARY KEY  (`cid`,`csort`,`con`,`pcid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_ext` (
  `eid` int(11) NOT NULL auto_increment,
  `etitle` varchar(255) NOT NULL default '',
  `einfo` text NOT NULL,
  `etype` int(3) NOT NULL default '0' COMMENT '0:field，1:page,2:js',
  PRIMARY KEY  (`eid`,`etype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_form` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `field` text,
  `login` int(11) NOT NULL default '0' COMMENT '1:必须登录',
  `type` int(11) NOT NULL default '0' COMMENT '1:表单，0 模型',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_forminfo` (
  `id` int(11) NOT NULL auto_increment,
  `form_id` int(11) NOT NULL default '0',
  `field` text NOT NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_guest` (
  `gid` int(11) NOT NULL auto_increment,
  `gtitle` varchar(255) NOT NULL default '',
  `ginfo` text NOT NULL,
  `gtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `uid` int(11) NOT NULL default '0',
  `gtype` int(11) NOT NULL default '0' COMMENT '0:留言本，1：评论',
  `nid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gid`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_money` (
  `id` int(11) NOT NULL auto_increment,
  `num` varchar(255) NOT NULL default '',
  `money` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `flag` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_news` (
  `nid` int(11) NOT NULL auto_increment,
  `ntitle` varchar(255) NOT NULL default '',
  `nkeyword` varchar(255) default '',
  `ncontent` text NOT NULL,
  `ntime` datetime NOT NULL default '0000-00-00 00:00:00',
  `cid` int(11) NOT NULL default '0',
  `nimg` varchar(255) default '',
  `npy` varchar(255) NOT NULL default '',
  `nsort` int(11) NOT NULL default '0',  
  `nfield` text NOT NULL,
  `count` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `isimg` int(11) NOT NULL default '0',
  `outlink` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nid`,`cid`,`count`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_module` (
  `mid` int(11) NOT NULL auto_increment,
  `mtitle` varchar(255) default NULL,
  `status` int(11) NOT NULL default '0',
  `sort` int(11) NOT NULL default '0' COMMENT '0',
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_order` (
  `oid` int(11) NOT NULL auto_increment,
  `onum` varchar(255) NOT NULL default '' COMMENT '数量',
  `ono` varchar(255) NOT NULL default '' COMMENT '订单号',
  `uid` int(11) NOT NULL default '0',
  `otime` datetime NOT NULL default '0000-00-00 00:00:00',
  `flag` int(3) NOT NULL default '0',
  `nid` int(11) NOT NULL default '0' COMMENT '产品ID',
  PRIMARY KEY  (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_pic` (
  `pid` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `{qcms}_user` (
  `uid` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `sex` int(11) NOT NULL default '0',
  `email` varchar(255) NOT NULL default '',
  `qq` varchar(20) default '',
  `tel` varchar(50) default '',
  `address` varchar(255) default NULL,
  `money` int(11) NOT NULL default '0',
  `add_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `level` int(5) NOT NULL default '0',
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO {qcms}_cate VALUES ('1','0','公司新闻','','','公司新闻','公司新闻 ','1','1','list_news','view_news','gongsixinwen','0','0');
INSERT INTO {qcms}_cate VALUES ('2','0','产品展示','','','产品展示','产品展示 ','1','1','list_pro','view_pro','chanpinzhanshi','0','0');
INSERT INTO {qcms}_cate VALUES ('3','0','资料下载','','','资料下载','&nbsp;资料下载 ','1','1','list_down','view_down','ziliaoxiazai','1','0');
INSERT INTO {qcms}_cate VALUES ('4','0','在线招聘','','','在线招聘','&nbsp;在线招聘 ','1','1','list_job','view_job','zaixianzhaopin','2','0');
INSERT INTO {qcms}_cate VALUES ('5','0','关于我们','','','关于我们','QCMS是一个小型网站管理系统，灵活，方便是最大特色，为初学者快速度架设网站首选。ASP+ACCESS，ASP+SQL，PHP+MYSQL,.NET+SQL;只要一个ASP、.NET或PHP空<br />间即可直接架设，无需更多复杂的操作，程序开源，模版分离，动态标签，只要会HTML基础就可以做出个性化的网站。 ','1','1','other','view','guanyuwomen','0','0');
INSERT INTO {qcms}_cate VALUES ('6','0','在线反馈','','','在线反馈','在线反馈 ','1','1','form','view','zaixianfankui','0','0');
INSERT INTO {qcms}_cate VALUES ('7','0','用户留言','','','用户留言','&nbsp;用户留言 ','1','1','guest','view','yonghuliuyan','0','0');
INSERT INTO {qcms}_cate VALUES ('8','0','联系我们','','','联系我们','<p>联系我们 </p><p>网站：<a href="http://www.q-cms.cn">http://www.q-cms.cn</a></p><p>QQ群：123456789</p><p>论坛：<a href="http://bbs.q-cms.cn">http://bbs.q-cms.cn</a></p>','1','1','other','view','lianxiwomen','0','0');
INSERT INTO {qcms}_cate VALUES ('9','0','网站首页','','/','','','1','0','cate','view','wangzhanshouye','0','1');
INSERT INTO {qcms}_form VALUES ('1','下载','a:2:{i:0;a:4:{s:10:"field_info";s:6:"地址";s:10:"field_name";s:4:"down";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}i:1;a:4:{s:10:"field_info";s:6:"大小";s:10:"field_name";s:4:"size";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}}','0','0');
INSERT INTO {qcms}_form VALUES ('2','招聘','a:3:{i:0;a:4:{s:10:"field_info";s:6:"年龄";s:10:"field_name";s:3:"age";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}i:1;a:4:{s:10:"field_info";s:6:"月薪";s:10:"field_name";s:6:"salary";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}i:2;a:4:{s:10:"field_info";s:6:"人数";s:10:"field_name";s:3:"num";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}}','0','0');
INSERT INTO {qcms}_form VALUES ('3','用来考女球迷的世界杯选择题','a:5:{i:0;a:4:{s:10:"field_info";s:33:"以下哪个是葡萄牙球星？";s:10:"field_name";s:6:"click1";s:10:"field_type";s:1:"3";s:15:"field_parameter";s:19:"A罗|B罗|C罗|D罗";}i:1;a:4:{s:10:"field_info";s:33:"以下哪个是阿根廷球星？";s:10:"field_name";s:6:"click2";s:10:"field_type";s:1:"3";s:15:"field_parameter";s:27:"梅东|梅南|梅西|梅北";}i:2;a:4:{s:10:"field_info";s:30:"以下哪个是荷兰球星？";s:10:"field_name";s:6:"click3";s:10:"field_type";s:1:"3";s:15:"field_parameter";s:42:"东风破|范佩西|双结棍|千里之外";}i:3;a:4:{s:10:"field_info";s:33:"以下哪个是西班牙球星？";s:10:"field_name";s:6:"click4";s:10:"field_type";s:1:"3";s:15:"field_parameter";s:39:"托风斯|托火斯|托雷斯|托电斯";}i:4;a:4:{s:10:"field_info";s:33:"以下哪个是意大利球星？";s:10:"field_name";s:6:"click5";s:10:"field_type";s:1:"3";s:15:"field_parameter";s:39:"加图索|减图索|乘图索|除图索";}}','0','1');
INSERT INTO {qcms}_forminfo VALUES ('1','3','a:5:{s:6:"click1";s:4:"A罗";s:6:"click2";s:6:"梅北";s:6:"click3";s:9:"范佩西";s:6:"click4";s:9:"托雷斯";s:6:"click5";s:9:"加图索";}','2011-08-23 16:24:28');
INSERT INTO {qcms}_guest VALUES ('1','QCMS系统什么时候能发布','QCMS系统什么时候能发布','2011-08-23 07:13:59','1','0','0');
INSERT INTO {qcms}_news VALUES ('1','22日行情:侧滑全键盘实用手机不到1300','','&nbsp;2011年8月22日，索尼爱立信CK15i (参数 报价 论坛 软件) (行货带发票)在商家最新到货，商家给出的开卖价为1298元，配件有：单电、单充、耳机、数据线等。索尼爱立信CK15i是一款侧滑全键盘造型的实用性手机。rn<p>　　索尼爱立信CK15i的机身造型十分时尚，其采用了火热的侧滑全键盘设计，触控+键盘带来了多样的操作方式，对于文 字的录入有着出色的表现，其装备有一块3.0英寸的触控屏，屏幕分辨率为240x400像素，画面质量还是值得肯定的，机身背部安置一颗320万像素摄像 头，用作日常随拍还是不错的，此外该机还配有无线WIFI功能，也是弥补了一下没有3G网络的遗憾。</p>rn<p>　　索尼爱立信CK15i是最近刚刚发布的一款新机，该机的外观设计十分惹人喜爱，侧滑全键盘的设计照顾到了不同操作习惯的消费者，虽然该机没有搭载智能系统，但是触控体验还是令人满意的，今日该机新鲜到货，报价不足1300元，对于学生群体来说是个不错的选择。</p>rn<p>　　索尼爱立信CK15i(行货)</p>','2011-08-22 06:36:17','1','','22rixingqing:cehuaquanjianpanshiyongshoujibudao1300','0','N;','0','1');
INSERT INTO {qcms}_news VALUES ('2','2000元可以买双核 最超值智能机全搜索','','<p>转眼间已经到了8月下旬，在过去的这段时间之内智能手机市场也发生着巨大变化。经过了将近一个月的修正，各大品牌智 能手机价格逐渐走向平稳，索尼爱立信MT15i(参数 报价 图片 论坛 软件)此前一直维持在2300元左右，如今最低已经降至了2099元。不仅如此，8月16日，我们又迎来了一位悍 将——小米手机，在具备强劲硬件配置的同时，这款手机也为我们带来了更大的惊喜，上市价格仅为1999元，这也让我们在购机时有了更多的选择。而从整个市 场行情来看，2000元预算也是大众购机的理想价位，除了以上两款机型还有哪些机型可供我们参考呢，下面我们来共同揭晓答案。</p>rn<p>　　小米手机</p>rn<p>　　机型亮点：Android 2.3.5操作系统、1.5GHz高通MSM8260双核处理器、1GB RAM、480×854像素分辨率、1930毫安锂电池等</p>rn<p>　　2011年8月16日小米手机的发布给我们带来了太多惊喜，除了超强的硬件配置，更为诱人的是不到2000元的售 价，这也让我们在购机的时候有了新的选择。这款手机搭载目前最高1.5GHz主频高通MSM8260双核处理器，并且运行内存也达到了惊人的1GB容量， 如此强劲的硬件配置以至于在跑分环节战胜了当世机皇三星I9100。</p>rn<p>　　除了高性能，MIUI也是小米手机主打的方向之一，它是一个基于Android深度开发的第三方操作系统。此次发布 的小米手机内置有两个MIUI系统，可以任意切换，最大限度的规避了传统刷机带来的风险。此外，小米手机还支持原生Android操作系统，这一点难能可 贵。不过大家对此还要保持冷静，小米手机究竟怎么样，上市之后一见分晓吧。</p>','2011-08-22 06:44:04','1','','2000yuankeyimaishuanghezuichaozhizhinengjiquansousuo','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('3','ThinkPad明年一季度将推Ultrabook商务本','','<p>Ultrabook所倡导的轻薄、便携、超长续航相信在商务笔记本领域更受欢迎，近日联想内部人士透露，联想ThinkPad将推出Ultrabook标准的笔记本，并计划在明年第一季度发售。</p>rn<p>ThinkPad X220</p>rn<p>　　轻薄、超长续航一直是联想ThinkPad商务本的优势之一 而借助于intel Ultrabook设计标准，将会带来为产品带来更纤薄的设计外型。同时依旧保持ThinkPad商务本出色安全性和易用性，这对于目前商务笔记本市场将带来一定积极的影响。</p>rn<p>　　目前在ThinkPad家族中，X系列是极致轻薄的代表，而采用Ultrabook标准的ThinkPad，极有可能率先出现在这个系列中。而关于售价方面，由于定位于ThinkPad X系列相信它的售价也会远远高于1000美元。</p>','2011-08-22 06:47:31','1','','ThinkPadmingnianyijidujiangtuiUltrabookshangwuben','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('4','22日八大热门本：7英寸便携平板仅2350元','','&nbsp;三星Galaxy Tab P1010平板电脑采用7英寸屏幕搭配Android 2.2操作系统，便携性相当出色。目前这款平板电脑的最新报价为2350元，比前段时间降价50元，经销商还送贴膜。rn<p>　　外观方面，三星Galaxy Tab P1010平板电脑顶部的设计还是延续了三星一贯的手机设计风格，它采用了7英寸大的TFT电容屏，支持多点触控；分辨率达到1024×600像素，显示效果继承了三星一贯的优良品质，清晰而又艳丽。该机拥有12毫米的机身厚度，如此薄的机身内却装有4000mAh的电池；在机身背面，该机配备了一颗500万像素的标准摄像头。</p>rn<p>　　配置方面，三星Galaxy Tab P1010平板电脑搭载了ARM A8处理器，512MB内存和16GB硬盘，集成PowerVR SGX 540显示芯片，集成网卡，WIFI无线上网，移动3G上网，蓝牙模块，HDMI高清接口，Android2.2操作系统。<br /></p>','2011-08-22 06:50:32','1','','22ribadaremenben7yingcunbianxiepingbanjin2350yuan','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('5','拍照娱乐功能主打 最值得购买平板电脑推荐','','&nbsp;不少消费者都认为平板电脑拍照又大、又蠢实在不适合，但是随着微博的普及越来越多的人选择用操作更方便的平板电脑来体验，这样一来平板电脑对拍照的需求就越来越大了。而不少明星也拿起平板电脑来自拍或者记录身边的点滴，前不久我们就看到了著名足球明星加图索就拿着一台苹果iPad 2进行拍摄，简直就是“霸气外露”无人能挡。rn<p>　　不过要说到平板电脑拍照，如今市场上不少平板电脑都拥有强大的摄像头，配合丰富的拍照功能，整体效果丝毫不逊色于手机产品。而今天小编要为大家介绍的几款平板电脑就是拥有强大拍照功能的旗舰产品，希望他们的出现能为您的生活增添色彩，同时也让您在选购过程中不至于迷茫。那么闲话少说，还是让我们看看这些拍照旗舰究竟是“谁”吧。</p>rn<p>　　既然刚刚提到了“加图索”那么我们第一款要推荐的平板电脑当然是苹果iPad 2，虽然在像素方面后置摄像头仅有70像素，但是摄像以及拍照效果还是可圈可点的。此外整机设计简约时尚，机身厚度仅为8.8毫米，纤薄的机身也让它拥有非常出色的持握感，重量也比较轻巧。正面采用一块9.7英寸分辨率为1024×768像素触控屏，显示效果清晰自然。</p>rn<p>　　系统方面，苹果iPad 2采用的是iOS 4操作系统，该平台下拥有非常丰富的软件应用，扩展性能极为强劲。此外，硬件性能方面，iPad 2表现力更强，它采用了一颗1GHz主频A5双核处理器，相比一代iPad的单核处理器，处理性能得到大幅提升。最令人欣慰的是，性能提升的同时，使用时间却丝毫不减，充满电后仍然可以使用十小时，iPad 2整体表现堪称完美。</p>','2011-08-22 06:51:35','1','','paizhaoyulegongnengzhudazuizhidegoumaipingbandiannaotuijian','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('6','12.2mm超轻薄卡片DC 索尼TX55详细评测','','&nbsp;我们都知道索尼TX系列是以纤薄、轻巧为取胜的卡片相机，发展了几代的TX系列如今更是把轻薄小巧这个概念推到了极致。8月10日索尼发布了TX系列全新机型，TX55以12.2mm的纤薄体型，以及92.9×54.4mm的长宽比成为当仁不让的世界最小具备光学防抖功能的卡片DC。ZOL评测实验室也在第一时间拿到了这台相机，究竟这TX55有多大的能耐，此次评测就能见分晓。rn<p>　　索尼TX55(资料 报价 图片 论坛)以“薄、小”见长，除了靓丽的外形，TX55还能为我们带来哪些方面的惊喜呢？首先，1620万像素1/2.3英寸背照式CMOS传感器，为今年索尼TX系列相机的主力标配。其次，5倍光变卡尔蔡司镜头也是首次应用于TX系列相机之上。同时，索尼TX55相机还有多项拍摄模式的创新，全新的照片效果模式里收纳了诸如HDR绘画、微缩景观、玩具相机等主流效果模式。</p>rn<p>　　对于一台针对女性用户推出的相机，索尼TX55在外观设计方面无疑是出色的。机身细节的设计方面，更是体现出了女性用户对于“柔、美”特质的倾向。到底TX55有着怎样的外观表现呢？接下来，就让我们先体验一下吧。<br /></p>','2011-08-22 06:52:51','1','','12.2mmchaoqingbaokapianDCsuoniTX55xiangxipingce','0','N;','1','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('7','卖点不只是价格 近期热门平板电视点评','','&nbsp;8月对于平板电视市场来说，平淡之中又不缺乏创新与激情，它们一起共同爆发。促销、新品、首发等词语也相续频繁的出现，使得彩电市场上的“战况”异常激烈。rn<p>　　新平板电视、新概念的不断推出逐步改变人们探讨的方向，日前3D电视、智能电视、云电视等技术名词渐渐成为了业内人士以及消费者关注的焦点。不过从近期市场上最热门的平板电视来看，最吸引消费者注意的是，随着新品的推出，“老”型号产品的价格开始不断跳水，比如某些品牌42寸液晶都降到了4000元左右，这与一年前相比，真可谓“恐怖”。</p>rn<p>　　对于消费者来说，合适的价格当然会很具吸引力。但随着多功能智能电视的出现，人们开始摆脱了单纯被动收看电视节目，互动体验、影视点评、体感游戏等这些有趣的功能也越来越开始被年轻人所使用、喜欢，因此这类产品的关注度也大幅提高。</p>rn<p>　　今天在这里，笔者这里整理了目前市场上比较热门的平板电视电视，它们在价格以及功能方面，各有各自的强势之处，因此也吸引了许多消费者的关注，下面我们一起来看看吧。<br /></p>','2011-08-22 06:53:23','1','','maidianbuzhishijiagejinqiremenpingbandianshidianping','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('8','打发拥堵时间 乘车必备数码产品大盘点','','&nbsp;　　北京的路况一直让生活在北京的居民们无可奈何，数百万的机动车保有量也让北京已 经很发达的交通道路不堪重负，对于生活在北京的人们来说，堵车已经是一个家常便饭的事情。而堵车本来也是一个非常让人恼火的事情，可以说是一种荒度光阴， 对于堵车时候的无聊时光如何打发也是很多上班族经常聊起的话题。而对于打发堵车的时间来说，数码产品就是几乎必备的产品了。rn<p>　　对于司机朋友来说，应该是最为痛恨堵车的了，相比坐公交的人们来说，开车堵在路上着急搓火不说，慢慢烧的可是自己的油钱啊！对于堵在路上来说使用类似MP4、电子书一类的产品基本是不可能了，毕竟开车还要看路，使用这些产品也是极度的不安全。</p>rn<p>　　听音乐就成为了最好的选择，很多车内也都内置了CD机，但是对于一张盘仅仅十首歌左右的容量来说，还真未必能抗衡北京几乎能饿死人的堵车情况，那么这时候MP3就成为了一个必备的产品。</p>','2011-08-22 06:54:00','1','','dafayongdushijianchengchebibeishumachanpindapandian','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('9','录音长达500多小时 三洋PS380仅4G/899元','','&nbsp;虽然录音笔问世以来，外观方面并没有本质的变化。然而随着相关技术的发展，录音笔正在通过更加出色录音效果、长时间录音等功能，吸引着特殊需求的用户。三洋ICR-PS380RM是同系列的最新产品，4GB的存储空间是之前产品所不具备的。现在，这款产品正在进行低价促销，要价4G仅899元，十分的划算，有需要的朋友可以咨询一下商家。rn<p>　　三洋ICR-PS380RM采用了黑色的机身烤漆材质设计，不但体现出了专业的设计水平，同时也显示出专业的品质表现。机身采用了翻转麦克风的设计，能够保证用户获得更加出色的使用效果。另外三洋ICR-PS380RM配置了一块单色液晶显示屏，能够及时向用户反馈整机的运行信息。</p>rn<p>　　性能方面，三洋ICR-PS380RM表现同样体现出其物超所值的特点，整机在录音质量方面达到了专业的水平，同时两种录音品质的设计使用户可以根据自己的使用或者选择进行切换。<br />　　产品的左侧进设计有耳机插孔，此耳机接口为标准的3.5mm耳机插孔，可以与用户日常的耳机实现通用。背部设计有推拉式开关按键、锁定按键、播放速度选定。其中播放速度选定分为正常、慢速、快读。</p>rn<p>　　三洋ICR-PS380RM的供电系统有1组AAA 7号电池构成。三洋ICR-PS380RM采用推拉式设计，用户日常不使用情况，将其收起完全不会被察觉。三洋ICR-PS380RM随机附件包括了USB线、耳机、麦克风、音频线，涵盖了用户日常能够使用到的所有附件。</p>rn<p>　　编辑点评：另外三洋ICR-PS380RM的最长录音时间为557小时，内置的电池的续航时间达到了25小时，超长的续航时间给消费者留下了深刻的印象。这款产品不仅具有录音笔的功能，还能够作为mp3播放器使用，为用户的日常使用增添了色彩。</p>','2011-08-22 06:54:36','1','','luyinchangda500duoxiaoshisanyangPS380jin4G/899yuan','0','N;','2','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('10','三星GALAXY Tab 10.1本周开卖 售3688元','','&nbsp;&nbsp;新浪数码讯 8月22日消息，三星近日在北京召开了GALAXY Tab 10.1/8.9评测会，并向媒体透露GALAXY Tab 10.1将于本周六在大中电器中塔店首发的，零售价3688元。而GALAXY Tab 8.9由于供货的原因暂不发售。 rn<p>　　GALAXY Tab 10.1拥有8.6mm的轻薄机身，重量仅有565克，比iPad 2还要略轻薄些，是目前市售最薄的平板电脑。拥有1280x800分辨率的10.1英寸全触摸屏；预装Android 3.1操作系统、搭载1GHz双核处理器、1GB内存、16GB存储，支持Flash播放等；提供有黑白两种颜色可选。</p>rn<p>&nbsp;&nbsp;&nbsp; 据悉，此次国内发售的GALAXY Tab 10.1仅提供16GB/WiFi版，售价3688元。首发当天购买还可获赠原装皮套。</p>','2011-08-22 06:55:40','1','','sanxingGALAXYTab10.1benzhoukaimaishou3688yuan','0','N;','4','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('11','QCMS 新版发布','','&nbsp;QCMS 新版发布','2011-08-22 07:04:15','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('12','QCMS 新版发布','','&nbsp;QCMS 新版发布2','2011-08-22 07:09:46','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('13','QCMS 新版发布3','','&nbsp;QCMS 新版发布3','2011-08-22 07:09:59','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu3','0','N;','0','1');
INSERT INTO {qcms}_news VALUES ('14','QCMS 新版发布4','','&nbsp;QCMS 新版发布4','2011-08-22 07:10:12','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu4','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('15','QCMS 新版发布5','','&nbsp;QCMS 新版发布5','2011-08-22 07:10:27','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu5','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('16','QCMS 新版发布6','','&nbsp;QCMS 新版发布6','2011-08-22 07:10:40','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu6','0','N;','0','1');
INSERT INTO {qcms}_news VALUES ('17','QCMS 新版发布7','','&nbsp;QCMS 新版发布7','2011-08-22 07:10:54','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu7','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('18','QCMS 新版发布8','','&nbsp;QCMS 新版发布8','2011-08-22 07:11:06','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu8','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('19','QCMS 新版发布9','','&nbsp;QCMS 新版发布9','2011-08-22 07:11:18','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu9','0','N;','0','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('20','QCMS 新版发布10','','QCMS 新版发布10','2011-08-22 07:11:33','2','/static/temp/default/chanpin.gif','QCMSxinbanfabu10','0','N;','7','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('21','QCMS 新版1.52下载','','&nbsp;QCMS 新版1.52下载 ','2011-08-22 08:08:15','3','/static/temp/default/images/chanpin.gif','QCMSxinban1.52xiazai','0','a:2:{s:4:"down";s:33:"http://www.q-cms.cn/qcms_1.52.rar";s:4:"size";s:4:"500K";}','8','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('22','网站测试工程师','网站测试工程师','		职责描述： <br />1.负责网站测试工作。2.按照测试流程和计划，构建测试环境，设计测试脚本和用例，执行测试脚本和测试用例，寻找Bug，跟踪并验证Bug。 <br />3.确认问题得以解决，按照标准格式填写并提交Bug报告，完成软件开发的集成测试工作。 <br /><br />要求： <br />1.能独立测试网站项目，具备较好的测试分析，编写计划和编写用例的能力。 <br />2.熟练使用SQL查询。 <br />3.具备较强的团队精神，工作认真细致，有上进心。 <br />4.3年以上的工作经验。 ','2011-08-23 06:52:56','4','','wangzhanceshigongchengshi','0','a:3:{s:3:"age";s:5:"20-30";s:6:"salary";s:4:"4000";s:3:"num";s:1:"5";}','6','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('23','.net软件工程师','.net软件工程师','<p>&nbsp;<strong>职位要求：</strong></p><p>专业技能(2项以上)： <br />熟练掌握C#,ASP.Net等开发语言。 <br />熟练掌握HTML，JavaScript，CSS，Jquery。 <br />熟悉Web Service开发。 <br />熟悉面向对象设计，熟悉常用的设计模式。 <br />熟悉Oracle，SQL server其中一种数据库的维护、管理、SQL编写等技能。 <br />工作积极主动，具有强烈的责任心、事业心。 <br />学历大学本科及以上。 <br /><strong></strong></p><p><strong>优先选择条件：</strong><br />有过ArcGis工作经验。 <br />优秀的英语能力。 <br />良好的沟通和表达能力。 <br />企业应用开发。</p>','2011-08-23 06:54:08','4','','.netruanjiangongchengshi','0','a:3:{s:3:"age";s:5:"20-30";s:6:"salary";s:4:"6000";s:3:"num";s:1:"5";}','2','1','0','0','0');
INSERT INTO {qcms}_news VALUES ('24','PHP高级程序员','PHP高级程序员','&nbsp;岗位职责： <br /><br />1. PHP程序开发及MySQL数据库设计； <br /><br />2. 与Flash程序员配合完成网页游戏项目的系统开发。 <br /><br /><br />技术要求： <br /><br />1. 扎实的PHP语言基础和掌握完全面向对象的编程思想； <br /><br />2. 熟练掌握MySQL和SQL语法及优化； <br /><br />3. 熟悉分布式Memcache的配制，编程及优化； <br /><br />4. 具备良好的代码习惯，要求结构清晰，命名规范，逻辑性强，代码冗余率低； <br /><br />5. 富于团队精神和敬业精神，具有良好的自学能力和独立解决问题的能力； <br /><br />6. 思维严密，勤于思考，具备良好的执行能力； <br /><br />7. 熟悉Linux下的LAMP环境管理与配制尤佳； <br /><br />8. 有过百万PV网站项目成功实施经验者优先考虑。 ','2011-08-23 06:55:52','4','','PHPgaojichengxuyuan','0','a:3:{s:3:"age";s:5:"20-40";s:6:"salary";s:4:"6000";s:3:"num";s:1:"6";}','3','1','0','0','0');
INSERT INTO {qcms}_user VALUES ('1','admin','21232f297a57a5a743894a0e4a801fc3','1','admin@163.com11','123456789','12345678','上海市徐汇区','0','2011-01-27 17:03:13','1');
