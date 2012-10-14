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
INSERT INTO {qcms}_cate VALUES ('6','0','用户留言','','','用户留言','&nbsp;用户留言 ','1','1','guest','view','yonghuliuyan','0','0');
INSERT INTO {qcms}_cate VALUES ('7','0','联系我们','','','联系我们','<p>联系我们 </p><p>网站：<a href="http://www.q-cms.cn">http://www.q-cms.cn</a></p><p>QQ群：123456789</p><p>论坛：<a href="http://bbs.q-cms.cn">http://bbs.q-cms.cn</a></p>','1','1','other','view','lianxiwomen','0','0');
INSERT INTO {qcms}_cate VALUES ('9','0','网站首页','','/','','','1','0','cate','view','wangzhanshouye','0','1');
INSERT INTO {qcms}_form VALUES ('1','下载','a:2:{i:0;a:4:{s:10:"field_info";s:6:"地址";s:10:"field_name";s:4:"down";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}i:1;a:4:{s:10:"field_info";s:6:"大小";s:10:"field_name";s:4:"size";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}}','0','0');
INSERT INTO {qcms}_form VALUES ('2','招聘','a:3:{i:0;a:4:{s:10:"field_info";s:6:"年龄";s:10:"field_name";s:3:"age";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}i:1;a:4:{s:10:"field_info";s:6:"月薪";s:10:"field_name";s:6:"salary";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}i:2;a:4:{s:10:"field_info";s:6:"人数";s:10:"field_name";s:3:"num";s:10:"field_type";s:1:"1";s:15:"field_parameter";s:0:"";}}','0','0');
INSERT INTO {qcms}_user VALUES ('1','admin','21232f297a57a5a743894a0e4a801fc3','1','admin@163.com11','123456789','12345678','上海市徐汇区','0','2011-01-27 17:03:13','1');
