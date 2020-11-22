<?php
$config=array(
    'mydbhost'=>'mysql.jguocloud.com',
     'mydbuser'=>'yxadmin',
     'mydbpw'=>'YuanXiao@1314',
     'mydbname'=>'tst',
     'mydbcharset'=>'utf8',
	 'mydbcode'=>'#PASS',
	 'charset'=>'utf-8',
);

/*请修改同一文件夹下的mysql_config.ini文件
 * 
 * 下面为一个配置选项，仅供参考
 * 
[beijinhonghui]
mydbhost=192.168.1.185
mydbuser=root
mydbpw=root
mydbdef=
mydbname=uisp_lw_zhongguoww
mydbcharset=utf8
mydbcode=#PASS
charset=utf-8

 * */
/*$mysql_config=parse_ini_file("mysql_config.ini",true);


$path= $_SERVER['PHP_SELF'];
$path=substr($path,1);
$path=substr($path,0,strpos($path,"/"));
$isfind=false;
foreach ($mysql_config as $key=>$val) {
	if($key==$path) {
		$isfind=true;
		$config=$mysql_config[$path];
		break;
	}
}
if(!$isfind) $config=$mysql_config['default'];


*/






?>