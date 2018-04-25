<?php 
set_time_limit(1800);
//设定页面编码
header("Content-Type:text/html;charset=utf-8");
//设定时区
date_default_timezone_set('Asia/Riyadh');

error_reporting(E_ALL ^ E_NOTICE);

$zuotianlingchen = strtotime(date('Y-m-d',time() - 86400 ));
$env = file_get_contents(__DIR__.'/.env');
$config = explode("\n", $env);
foreach ($config as $key => $value) {
	if(strstr($value, 'DB_HOST'))
	{
		$DB_HOST = explode('=', $value);
	}
	if(strstr($value, 'DB_USERNAME'))
	{
		$DB_USERNAME = explode('=', $value);
	}
	if(strstr($value, 'DB_PASSWORD'))
	{
		$DB_PASSWORD = explode('=', $value);
	}
	if(strstr($value, 'DB_DATABASE'))
	{
		$DB_DATABASE = explode('=', $value);
	}
}
$dbms='mysql';     //数据库类型
$host=$DB_HOST[1]; //数据库主机名
if($host == 'localhost')
{
	$host = '127.0.0.1';
}
$dbName=$DB_DATABASE[1];    //使用的数据库
$user=$DB_USERNAME[1];      //数据库连接用户名
$pass=$DB_PASSWORD[1];  //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName";


try {
    $pdo = new PDO($dsn, $user, $pass); //初始化PDO
    $pdo->query('set names utf8;');
} catch (PDOException $e) {
    die ("Error!: can not find database");
}

$taskList = $pdo->query("SELECT * FROM `task_list` WHERE `create_time` > '{$zuotianlingchen}' AND `check_type` = 1 AND `status` = 0");

if($taskList)
{
    $taskList = $taskList->fetchAll(PDO::FETCH_ASSOC);
    foreach ($taskList as $key => $value) {
        //处理业务
    }
}

echo 'finshed !'.PHP_EOL;

